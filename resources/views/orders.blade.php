<x-layout>
    <table class="table">
        @foreach($orders as $order)
        <tr><td>{{ $loop->iteration }}</td><td><a href="/orders/{{$order->id}}">Order #{{ $order->id }} Amount: {{ $order->amount }}</a></td></tr>
        @endforeach
    </table>
    <div id="notification">
    </div>   
</x-layout>