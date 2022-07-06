<?php
ini_set("memory_limit", "1000M");
set_time_limit(0);
$database = 'med2'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'Lechis13131'; // пароль
$conn = new PDO("mysql:host=localhost;dbname=" . $database . ";charset=UTF8", $user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Med_zapis_bot
include('/var/www/com/laravel/public/Med_zapis_bot/vendor/autoload.php'); //Подключаем библиотеку

use Telegram\Bot\Api;

$telegram = new Api('5280536821:AAEHgt65_dC2KZSe-bcUD9Q04et5j2ulT1U'); //Устанавливаем токен, полученный у BotFather
$result = $telegram->getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

$text = $result["message"]["text"]; //Текст сообщения
$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
$name = $result["message"]["from"]["username"]; //Юзернейм пользователя
$keyboard = [["Укажите номер телефона"]]; //Клавиатура
$phone_number = $result["message"]["contact"]["phone_number"];

//проверяем не были уже записан chat_id
$sql0 = $conn->query("SELECT t1.header, t2.*  FROM xyfq1_clinics_items as t1 left JOIN xyfq1_clinics_agents as t2 on t2.item_id=t1.id  where t2.chat_id = '{$chat_id}'");
$result0 = $sql0->fetchAll(PDO::FETCH_ASSOC);

if ($text) {
    if ($text == "/start" || $text == "Начать") {
        $reply = "Добро пожаловать в бота!!!";
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
        //  $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
        //  $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
    } elseif (preg_match('~/start (\d+)$~m', $text, $match) || preg_match('~(\d+)$~m', $text, $match)) {
        $clinic_id = $match[1];
        $sql = $conn->query("SELECT t1.header, t2.*  FROM xyfq1_clinics_items as t1 left JOIN xyfq1_clinics_agents as t2 on t2.item_id=t1.id  where t1.id = '{$clinic_id}'");
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $date = date('H:i');
        //если агент и клиника есть, агент включил поддерку бота и юзер пишет в рабочее время
        if (!empty($result[0]['phoneBot']) && !empty($result[0]['nameBot']) && ($date > date('H:i', strtotime($result[0]['start'])) && $date < date('H:i', strtotime($result[0]['finish'])))) {
            $reply = $result[0]['header'] . PHP_EOL . 'представитель - ' . $result[0]['nameBot'] . PHP_EOL . 'готов(а) ответить на Ваши вопросы, задавайте ...'.PHP_EOL.
                '<a href="https://t.me/'. $result[0]['username'] .'">нажмите эту ссылку для начала диалога</a>';
        } //если агент и клиника есть, агент включил поддерку бота НО юзер пишет в НЕ рабочее время
        elseif (!empty($result[0]['phoneBot']) && !empty($result[0]['nameBot']) && ($date < date('H:i', strtotime($result[0]['start'])) || $date > date('H:i', strtotime($result[0]['finish'])))) {
            $reply = $result[0]['header'] . PHP_EOL . 'представитель - ' . $result[0]['nameBot'] . PHP_EOL . 'текущее время по Москве - ' . $date
                . PHP_EOL . 'представитель готов проконсультировать вас с ' .  date('H:i', strtotime($result[0]['start'])) . ' по ' .  date('H:i', strtotime($result[0]['finish']));
        } //если агент и клиника есть и агент НЕ включил поддерку бота
        elseif ((empty($result[0]['phoneBot']) || empty($result[0]['nameBot'])) && !empty($result)) {
            $reply = 'К сожалению представитель клиники ' . PHP_EOL . $result[0]['header'] . ' пока не активировал поддержку телеграм бота';
        } elseif (empty($result)) {
            $reply = 'Клиники с таким ID нет в базе.';
        } //агента у клиники пока нет
        else {
            $reply = 'К сожалению у клиники ' . PHP_EOL . $result[0]['header'] . ' пока нет зарегистрированного у нас представителя.';
        }
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply,  'parse_mode' => 'HTML']);
    } elseif (preg_match('~/start (\d+)_agent$~m', $text, $match) || preg_match('~(\d+)_agent$~m', $text, $match)) {
        $clinic_id = $match[1];
        $sql = $conn->query("SELECT t1.header, t2.*  FROM xyfq1_clinics_items as t1 left JOIN xyfq1_clinics_agents as t2 on t2.item_id=t1.id  where t1.id = '{$clinic_id}'");
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        //если агент и клиника есть и агент включил поддерку бота - отправлям кнопку запроса телефона и записываем в базу chat_id в таблицу агента
        if (!empty($result[0]['phoneBot']) && !empty($result[0]['nameBot'])) {
            $keyboard = array(
                array(
                    array(
                        'text' => "Укажите номер телефона!",
                        'request_contact' => true
                    )
                )
            );
            $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
            $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Укажите номер телефона!', 'reply_markup' => $reply_markup]);

            $sql = "UPDATE `xyfq1_clinics_agents` SET `chat_id` = '{$chat_id}',`username` = '{$name}'  WHERE `item_id` = '{$clinic_id}';";
            $conn->query($sql);
        }else{
            $reply = 'Если вы представитель клиники - ' . PHP_EOL . $result[0]['header'] . ' и хотите подключить телеграм бота, в <a href="https://med-otzyv.ru/nastrojki/profile">личном кабинете</a> представителя клиники нужно сохранить Ваше имя и телефон.';
            $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply,  'parse_mode' => 'HTML']);
        }

    } else {
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML']);
    }
} elseif (!empty($phone_number) && !empty($result0)) {
    $phone_number = str_replace('+', '', $phone_number);
    $sql = $conn->query("SELECT * FROM `xyfq1_clinics_agents` WHERE `item_id` = '{$result0[0]['item_id']}' AND `phoneBot` = '{$phone_number}'");
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        $reply = 'Спасибо, Ваш телефон внесен в базу, как представителя клиники и на него в рабочее время (указанное в настройках) будут поступать вопросы пользователей.';
    } else {
        $reply = 'Телефон, указанный вами не совпадает с тем, который сохранен в  настройках для телеграм бота. Внесите изменения и повторите пройденные шаги.';
    }
    $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'HTML']);
} else {
    $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Отправьте текстовое сообщение.']);
}
