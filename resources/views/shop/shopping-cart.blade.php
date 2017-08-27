@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    @if(Session::has('cart'))
        <div class="shopping-cart row">
            <div class="col-sm-10 col-md-8 col-md-offset-2 col-sm-offset-1">
                <table>
                    <tr>
                        <th>Наименование</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                    @foreach($products as $product)
                        <tr data-product="{{ $product['item']['id'] }}" class="action_buttons">
                            <td class="table__name">{{ $product['item']['title'] }}</td>
                            <td>
                                <button type="button" data-action="dec" class="btn btn-xs"> - </button>
                                <input type="text" value="{{ $product['qty'] }}">
                                <button type="button" data-action="inc" class="btn btn-xs"> + </button>
                            </td>
                            <td>{{ $product['price'] }}</td>
                            <td>{{ $product['price'] * $product['qty'] }}</td>
                            <td>
                                <button type="button" data-action="remove" class="btn btn-xs btn-danger"> х </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong>Total: <span  id="totalprice">{{ $totalPrice }}</span></strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <a href="{{ route('checkout') }}" type="button" class="btn btn-success">Checkout</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2>No Items in Cart!</h2>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/checkout.js') }}"></script>
@endsection