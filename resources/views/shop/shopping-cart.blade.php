@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    <div id="shopping_cart"></div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/checkout.js') }}"></script>
@endsection