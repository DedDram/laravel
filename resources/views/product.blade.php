@extends('layouts.master')
@section('title', 'Товар')
@section('content')
    <h1>{{$category->name}}</h1>
    <h2>{{$category}}</h2>
    <p>Цена: <b>{{$category->price}} ₽</b></p>
    <img src="/">
    <p>{{$category->name}}</p>
    <form action="{{route('basket-add', $product)}}" method="post">
        <button type="submit" class="btn btn-success" role="button">добавить в корзину</button>
        @csrf
    </form>
@endsection
