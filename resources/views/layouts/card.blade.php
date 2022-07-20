<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
        </div>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x_silver.jpg" alt="iPhone X 256GB">
        <div class="caption">
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} ₽</p>
            <p>
            <form action="{{route('basket-add', $product)}}" method="post">
                <button type="submit" class="btn btn-primary" role="button">добавить в корзину</button>
                <a href="{{route('product', [$product->category->alias, $product->alias])}}" class="btn btn-default"
                   role="button">Подробнее</a>
                @csrf
            </form>
            </p>
        </div>
    </div>
</div>
