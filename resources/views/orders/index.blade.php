@extends('includes.template')

@section('content')
    <div class="container">
        <h1>Все заказы</h1>

        @if($orders->isEmpty())
            <p>Нет доступных заказов.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Заказ #</th>
                    <th>Статус</th>
                    <th>Общая стоимость</th>
                    <th>Дата создания</th>
                    <th>Детали</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td><a href="{{ route('orders.show', $order->id) }}">Подробнее</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
