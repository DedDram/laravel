<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=UTF-8">
    <title> Отбор клиентов по критериям</title>
</head>
<body>
<style>
    /* для элемента input c type="radio" */
    .custom-radio {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }

    /* для элемента label связанного с .custom-radio */
    .custom-radio + label {
        display: inline-flex;
        align-items: center;
        user-select: none;
    }

    /* создание в label псевдоэлемента  before со следующими стилями */
    .custom-radio + label::before {
        content: '';
        display: inline-block;
        width: 1em;
        height: 1em;
        flex-shrink: 0;
        flex-grow: 0;
        border: 1px solid #adb5bd;
        border-radius: 50%;
        margin-right: 0.5em;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 50% 50%;
    }

    /* стили при наведении курсора на радио */
    .custom-radio:not(:disabled):not(:checked) + label:hover::before {
        border-color: #b3d7ff;
    }

    /* стили для активной радиокнопки (при нажатии на неё) */
    .custom-radio:not(:disabled):active + label::before {
        background-color: #b3d7ff;
        border-color: #b3d7ff;
    }

    /* стили для радиокнопки, находящейся в фокусе */
    .custom-radio:focus + label::before {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* стили для радиокнопки, находящейся в фокусе и не находящейся в состоянии checked */
    .custom-radio:focus:not(:checked) + label::before {
        border-color: #80bdff;
    }

    /* стили для радиокнопки, находящейся в состоянии checked */
    .custom-radio:checked + label::before {
        border-color: #0b76ef;
        background-color: #0b76ef;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }

    /* стили для радиокнопки, находящейся в состоянии disabled */
    .custom-radio:disabled + label::before {
        background-color: #e9ecef;
    }

    /* INPUT */
    input[type="checkbox"] {
        appearance: none;
        width: 40px;
        height: 16px;
        border: 1px solid #aaa;
        border-radius: 2px;
        background: #ebebeb;
        position: relative;
        display: inline-block;
        overflow: hidden;
        vertical-align: middle;
        transition: background 0.3s;
        box-sizing: border-box;
    }

    input[type="checkbox"]:after {
        content: '';
        position: absolute;
        top: -1px;
        left: -1px;
        width: 14px;
        height: 14px;
        background: white;
        border: 1px solid #aaa;
        border-radius: 2px;
        transition: left 0.1s cubic-bezier(0.785, 0.135, 0.15, 0.86);
    }

    input[type="checkbox"]:checked {
        background: #a6c7ff;
        border-color: #8daee5;
    }

    input[type="checkbox"]:checked:after {
        left: 23px;
        border-color: #8daee5;
    }

    input[type="checkbox"]:hover:not(:checked):not(:disabled):after,
    input[type="checkbox"]:focus:not(:checked):not(:disabled):after {
        left: 0px;
    }

    input[type="checkbox"]:hover:checked:not(:disabled):after,
    input[type="checkbox"]:focus:checked:not(:disabled):after {
        left: 22px;
    }

    input[type="checkbox"]:disabled {
        opacity: 0.5;
    }


    input {
        padding: 5px;
        margin: 10px 0;
        border-radius: 10px;
        border: 2px solid #dfdfdf;
    }
    input[type="number"] {
        width: 50px !important;
    }
    input[type=submit] {
        height: 30px;
        width: 200px;
    }

    *, *:before, *:after {
        box-sizing: border-box;
    }

    select {
        width: 20%;
        padding: 5px;
        border-radius: 10px;
        border: 2px solid #dfdfdf;
    }
</style>
<script>
    function validate() {
        if (repaint_immediately.checked == 1) {
            document.getElementById('submit2').style.display = "none";
        } else {
            document.getElementById('submit2').style.display = "block";
        }
    }
    function changeValue() {
        if (document.getElementById('repaint_immediately').checked) {
            let form = document.getElementById("form");
            form.submit();
        }
    }
</script>
<form action="select_clients.php" id="form" method="GET">
    <tr>
        <th>Отбор клиентов по критериям</th>
        <th>.....</th>
    </tr> <!--ряд с ячейками заголовков-->
    <tr>
        <td><br> <br>
            Возраст от : <input type="number" name="age_from" onchange="changeValue()"
                                value="<?php echo $_GET ["age_from"] ?>"> до :
            <input type="number" name="age_to" onchange="changeValue()" value="<?php echo $_GET ["age_to"] ?>">
            Статус: <select name="status" onchange="changeValue()">
                <option></option>
                <option <?php if ($_GET ["status"] == "Пенсионер") {
                    echo 'selected';
                } ?> >Пенсионер
                </option>
                <option <?php if ($_GET ["status"] == "Социальный статус") {
                    echo 'selected';
                } ?> >Социальный статус
                </option>
                <option <?php if ($_GET ["status"] == "Партнерская карта") {
                    echo 'selected';
                } ?> >Партнерская карта
                </option>
            </select>
            <br> <br>

            Пол: <input class="custom-radio" type="radio" id="Gender_all" onchange="changeValue()" <?php if ($_GET ["gender"] == "*") {
                echo 'checked';
            } ?> name="gender" value="*"> <label for="Gender_all">Не учитывать</label>
            <input class="custom-radio" type="radio" onchange="changeValue()" id="Gender_F" <?php if ($_GET ["gender"] == "F") {
                echo 'checked';
            } ?> name="gender" value="F"> <label for="Gender_F">Жен</label>
            <input class="custom-radio" type="radio"  onchange="changeValue()" id="Gender_M" <?php if ($_GET ["gender"] == "M") {
                echo 'checked';
            } ?> name="gender" value="M"> <label for="Gender_M">Муж</label>
            <br>
            Координата : <input type="text" name="coord" onchange="changeValue()" value="<?php echo $_GET ["coord"] ?>">
            Радиус, км : <input type="number" name="radius"onchange="changeValue()"  value="<?php echo $_GET ["radius"] ?>">
            Доля нахождения в круге:
            <select name="proc" onchange="changeValue()">
                <option <?php if ($_GET ["proc"] == "25%") {
                    echo 'selected';
                } ?> >25%
                </option>
                <option <?php if ($_GET ["proc"] == "50%") {
                    echo 'selected';
                } ?> >50%
                </option>
                <option <?php if ($_GET ["proc"] == "75%") {
                    echo 'selected';
                } ?> >75%
                </option>
            </select>
            <br>
            Приобретенные товары : <input type="text" name="goods" onchange="changeValue()" value="<?php echo $_GET ["goods"] ?>">
            <br>
            Минимальная сумма покупок по выбранным товарам : <input onchange="changeValue()" type="number" name="min_sum"
                                                                    value="<?php echo $_GET ["min_sum"] ?>">
            <br>
            Минимальная пауза после последней покупки, дней: <input onchange="changeValue()" type="number" name="min_days"
                                                                    value="<?php echo $_GET ["min_days"] ?>">
            <br>
            Максимальная пауза после последней покупки, дней: <input onchange="changeValue()" type="number" name="max_days"
                                                                     value="<?php echo $_GET ["max_days"] ?>">
            <br>
            <input type="checkbox" id="birthday" name="birthday" onchange="changeValue()" <?php if ($_GET ["birthday"] == "on") {
                echo 'checked';
            } ?>>
            <label for="birthday">День рождения</label>
            +/-, дней: <input type="number" name="days_of_birthday" onchange="changeValue()" value="<?php echo $_GET ["days_of_birthday"] ?>">
            <br>
            <input type="checkbox" id="repaint_immediately" onclick="validate()" name="repaint_immediately" <?php if ($_GET ["repaint_immediately"] == "on") {
                echo 'checked';
            } ?>>
            <label for="repaint_immediately">Немедленно отбирать клиентов</label>
            <br>
            <p><input type="submit" name="action" id="submit2" value="Отобрать клиентов" <?php if ($_GET ["repaint_immediately"] == "on") {
                    echo 'style="display:none;"';
                } ?>></p>
        </td>
        <td>
        </td>
    </tr>
</form>


<?php

$action = $_GET ["action"];
$gender = $_GET ["gender"];
$age_from = $_GET ["age_from"];
$age_to = $_GET ["age_to"];
$status = $_GET ["status"];
$coord = $_GET ["coord"];
$radius = $_GET ["radius"];
$proc = $_GET ["proc"];
$goods = $_GET ["goods"];
$min_sum = $_GET ["min_sum"];
$min_days = $_GET ["min_days"];
$max_days = $_GET ["max_days"];
$birthday = $_GET ["birthday"];
$days_of_birthday = $_GET ["days_of_birthday"];


echo('Отбор ....' . PHP_EOL . '<br>');
echo('action =' . $action . PHP_EOL . '<br>');
echo('gender =' . $gender . PHP_EOL . '<br>');
echo('age_from =' . $age_from . PHP_EOL . '<br>');
echo('age_to =' . $age_to . PHP_EOL . '<br>');
echo('status =' . $status . PHP_EOL . '<br>');
echo('coord =' . $coord . PHP_EOL . '<br>');
echo('radius =' . $radius . PHP_EOL . '<br>');
echo('proc =' . $proc . PHP_EOL . '<br>');
echo('goods =' . $goods . PHP_EOL . '<br>');
echo('min_sum =' . $min_sum . PHP_EOL . '<br>');
echo('min_days =' . $min_days . PHP_EOL . '<br>');
echo('max_days =' . $max_days . PHP_EOL . '<br>');
echo('birthday =' . $birthday . PHP_EOL . '<br>');
echo('days_of_birthday =' . $days_of_birthday . PHP_EOL . '<br>');

//   формирование запроса с учетом отобранных параметров


exit();


//}
?>
</body>
</html>
