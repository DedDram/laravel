@extends('layouts.master')
@section('title', 'Корзина')
@section('content')
    <h1>Корзина</h1>
    <p>Оформление заказа</p>
    <div class="panel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>
                        <a href="{{route('product', [$product->category->alias, $product->alias])}}">
                            <img height="56px" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            {{$product->name}}
                        </a>
                    </td>
                    <td><span class="badge">{{$product->pivot->count}}</span>
                        <div class="btn-group form-inline">
                            <form action="{{route('basket-remove', $product)}}" method="post">
                                <button type="submit" class="btn btn-danger"
                                        href="{{route('basket-remove', $product)}}"><span
                                        class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                    @csrf
                                </button>
                            </form>
                            <form action="{{route('basket-add', $product)}}" method="post">
                                <button type="submit" class="btn btn-success"
                                        href="{{route('basket-add', $product)}}"><span
                                        class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    @csrf
                                </button>
                            </form>

                        </div>
                    </td>
                    <td>{{$product->price}} ₽</td>
                    <td>{{$product->getPriceForCount()}} ₽</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Общая стоимость:</td>
                <td>{{$order->getFullPrice()}} ₽</td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{route('basket-place')}}">Оформить
                заказ</a>
        </div>
    </div>
@endsection


