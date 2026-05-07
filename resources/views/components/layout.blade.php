
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        @vite(['resources/css/app.css', 'resources/js/bootstrap.js', 'resources/js/orders.js',])
        <link rel="stylesheet" href="{{ asset('/style.css') }}">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/orders">All Orders</a></li>
                @if(auth()->check())
                <li><a href="/orders/create">New Order</a></li>
                <li><a href="/logout">Logout</a></li>
                @else
                <li><a href="/login">Login</a></li>
                @endif
            </ul>
        </nav>
        {{ $slot }}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>