@extends('layouts.master')

@section('title')
    Admin
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">
            @if (isset($product))
                {{ Form::model($product, array('route' => array('item.redact', $product->id), 'method' => 'put')) }}
                <a href="/admin/item"></a>
            @else
                {{ Form::open(array('action' => array('ItemController@postItem'), 'method' => 'post')) }}
            @endif
            <!-- name -->
                <div class="form-group">
                {{ Form::label('title', 'Имя') }}
                {{ Form::text('title') }}
                </div>
                <div class="form-group">
                {{ Form::label('imagePath', 'Картинка') }}
                {{ Form::text('imagePath') }}
                </div>
                <div class="form-group">
                {{ Form::label('category', 'Категория') }}
                {{ Form::text('category') }}
                </div>
                <div class="form-group">
                {{ Form::label('price', 'Цена') }}
                {{ Form::text('price') }}
                </div>
                <div class="form-group">
                {{ Form::label('description', 'Описание') }}
                {{ Form::textarea('description') }}
                </div>
                {{ Form::submit('Done') }}
            {{ Form::close() }}
            @if (isset($product))
                {{ Form::open(['method' => 'delete', 'route' => ['item.delete', $product->id]]) }}
                {{ Form::hidden('id', $product->id) }}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {{ Form::close() }}
            @endif

        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/shopping_cart.js') }}"></script>
@endsection