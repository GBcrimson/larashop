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
            <div class="product__container">
                @foreach($products as $product)
                    <div class="product__element">
                        <div class="thumbnail">
                            {{--@foreach($product->photos as $image)--}}
                            {{--<img src="{{ $image->filename }}" alt="{{ $product->title }}" class="img-responsive">--}}
                            {{--@endforeach--}}
                            <div class="product__image">
                                <img src="{{ $product->photos->first() ? $product->photos->first()->filename : 'https://camo.githubusercontent.com/341831200626efe3e0cf83317801fcac2200fbe2/68747470733a2f2f662e636c6f75642e6769746875622e636f6d2f6173736574732f323639323831302f323130343036312f34643839316563302d386637362d313165332d393230322d6637333934306431306632302e706e67'}}" alt="{{ $product->title }}" class="img-responsive">

                            </div>
                            <div class="product__caption">
                                <div class="product__description">
                                    <h3>{{ $product->title }}</h3>
                                </div>
                                {{--<p class="description">{{ $product->description }}</p>--}}
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
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/shopping_cart.js') }}"></script>
@endsection