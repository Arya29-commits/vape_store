<!DOCTYPE html>
<html>
<head>
    <title>Toko Vape</title>
</head>
<body>
    <h1>Toko Vape</h1>
    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    @yield('content')
</body>
</html>
