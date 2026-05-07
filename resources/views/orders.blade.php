<x-layout>
    <ul>
        @foreach($orders as $order)
        <li><a href="/orders/{{$order->id}}">{{ $order->id }} Amount: {{ $order->amount }}</a></li>
        @endforeach
    </ul>
    <div id="notification">
    </div>   
</x-layout>