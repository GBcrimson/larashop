@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    @if(Session::has('success'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-list">
                <li class="nav-header">Краска</li>
                <li class="active"><a href="#">Отечественные</a></li>
                <li><a href="#">Иномарки</a></li>
                <li class="divider"></li>
                <li class="nav-header">Инструменты</li>
                <li><a href="#">Отечественные</a></li>
                <li><a href="#">Иномарки</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            @foreach($products->chunk(4) as $productChunk)
                <div class="row">
                    @foreach($productChunk as $product)
                        <div class="col-sm-6 col-md-3 product__element">
                            <div class="thumbnail">
                                    <img src="{{ $product->imagePath }}" alt="{{ $product->title }}" class="img-responsive">
                                <div class="caption">
                                    <h3>{{ $product->title }}</h3>
                                    <p class="description">{{ $product->description }}</p>
                                    <div class="clearfix">
                                        <pre class="price">{{ $product->price }} ₽</pre>
                                        <a href="{{ route('product.add', ['id' => $product->id]) }}"
                                           class="btn btn-primary addtocart" role="button">В корзину</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/shopping_cart.js') }}"></script>
@endsection