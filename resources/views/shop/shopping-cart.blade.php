@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    <div id="shopping_cart"></div>
    <hr>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
            <a href="{{ route('checkout') }}" type="button" class="btn btn-success">Checkout</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/checkout.js') }}"></script>
@endsection