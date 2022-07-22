@extends('auth.layouts.master')

@isset($category)
    @section('title', 'Редактировать категорию ' . $category->name)
@else
    @section('title', 'Создать категорию')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($category)
            <h1>Редактировать Категорию <b>{{ $category->name }}</b></h1>
                @else
                    <h1>Добавить Категорию</h1>
                @endisset

                <form method="POST" enctype="multipart/form-data"
                      @isset($category)
                      action="{{ route('categories.update', $category) }}"
                      @else
                      action="{{ route('categories.store') }}"
                    @endisset
                >
                    <div>
                        @isset($category)
                            @method('PUT')
                        @endisset
                        @csrf
                        <div class="input-group row">
                            <label for="alias" class="col-sm-2 col-form-label">Алиас: </label>
                            <div class="col-sm-6">
                                @error('alias')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name="alias" id="alias"
                                       value="{{ old('alias', isset($category) ? $category->alias : null) }}">
                            </div>
                        </div>
                        <br>
                        <div class="input-group row">
                            <label for="name" class="col-sm-2 col-form-label">Название: </label>
                            <div class="col-sm-6">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name', isset($category) ? $category->name : null) }}">
                            </div>
                        </div>


                            <br>
                        <div class="input-group row">
                            <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                            <div class="col-sm-6">
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
							<textarea name="description" id="description" cols="72"
                                      rows="7">{{ old('description', isset($category) ? $category->description : null) }}</textarea>
                            </div>
                        </div>
                        <br>

                        <div class="input-group row">
                            <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                            <div class="col-sm-10">
                               <input type="file" name="image" id="image" class="btn btn-default btn-file">
                            </div>
                        </div>
                        <button class="btn btn-success">Сохранить</button>
                    </div>
                </form>
    </div>
@endsection

