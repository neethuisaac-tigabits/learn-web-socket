
<!DOCTYPE html>
<head>
    {{-- ... --}}

    @vite(['resources/css/app.css', 'resources/js/bootstrap.js', 'resources/js/orders.js',])
    <link rel="stylesheet" href="{{ asset('/style.css') }}">
</head>
<body>
    <h1 class="text-bold">Home</h1>
    <div id="navigation">

    </div>
    <input type="hidden" id="orderId" value="{{ $order->id }}">
    <h2>Order #{{ $order->id }}</h2>
    <p><b>{{ $order->name }}</b></p>
    <div id="notification">
        
    </div>   
</body>