<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
            @endif
            @error('email')
            {{ $message }}
            @enderror
            <label for="email">Email</label>
            <input type="email" name="email" value="lawyer@example.com">
            <label for="password">Password</label>
            <input type="password" name="password">
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>