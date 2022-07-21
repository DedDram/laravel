@extends('layouts.master')
@section('title', 'Товар')
@section('content')
    <h1>{{$product->name}}</h1>
    <h2>{{$category}}</h2>
    <p>Цена: <b>{{$product->price}} ₽</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{$product->name}}</p>
    <form action="{{route('basket-add', $product)}}" method="post">
        <button type="submit" class="btn btn-success" role="button">добавить в корзину</button>
        @csrf
    </form>
@endsection
