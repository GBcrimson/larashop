<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Дааа, детка, новый заказ!</h2>

<div>
        <div>
            <ul>
                @foreach($cart->items as $item)
                    <li>
                        {{ $item['item']['title'] }} ({{ $item['item']['price'] }} рублей за штуку)| {{ $item['qty'] }}штук =
                        <strong>{{ $item['price'] }} рублей </strong>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <strong>Итого: {{ $cart->totalPrice }} рублей</strong>
        </div>
    <div>
        Адрес: {{$order->address}}<br/>
        Имя: {{$order->name}}<br/>
        Телефон: {{$order->phone}}<br/>
    </div>
    {{--{{ $order }}<br/>--}}

</div>

</body>
</html>