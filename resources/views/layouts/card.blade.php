<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-success">Новина</span>
            @endif
            @if($product->isRecommend())
                <span class="badge badge-warning">Рекомендуем</span>
            @endif
            @if($product->isHit())
                <span class="badge badge-danger">Хит продаж!</span>
            @endif
        </div>
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
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
