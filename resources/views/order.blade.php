<x-layout>
    
    <h1 class="text-bold">Order View</h1>
    <div id="navigation">

    </div>
    <input type="hidden" id="orderId" value="{{ $order->id }}">
    <h2>Order #{{ $order->id }}</h2>
    <p><b>{{ $order->name }} - {{ $order->user->email }}</b></p>
    <div id="notification">
        Amount: {{ $order->amount }}
    </div>   
</x-layout>