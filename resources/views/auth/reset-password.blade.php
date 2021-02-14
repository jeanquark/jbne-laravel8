<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>

<body>
    <div>
        @if (session('status'))
            <div class="">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @error('email')
                {{ $message }}
            @enderror
            @error('password')
                {{ $message }}
            @enderror
            <input type="hidden" name="token" value="{{ request()->route('token') }}" />
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ request()->email }}" />
            <label for="password">Password</label>
            <input type="password" name="password" value="password" />
            <label for="password_confirmation">Password confirmation</label>
            <input type="password" name="password_confirmation" value="password" />
            <button type="submit">Update Password</button>
        </form>
    </div>
</body>

</html>