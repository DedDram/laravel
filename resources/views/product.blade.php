@extends('layouts.master')
@section('title', 'Товар')
@section('content')
    <h1>iPhone X 64GB</h1>
    <h2>{{$category}}</h2>
    <p>Цена: <b>71990 ₽</b></p>
    <img src="{{Storage::url($product->image)}}">
    <p>Отличный продвинутый телефон с памятью на 64 gb</p>
    <form action="{{route('basket-add', $product)}}" method="post">
        <button type="submit" class="btn btn-success" role="button">добавить в корзину</button>
        @csrf
    </form>
@endsection
