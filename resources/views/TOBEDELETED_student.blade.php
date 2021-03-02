<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head></head>

<body>
    <div>
        <h1>Student protected page</h1>
        <a href="/">Home</a>
        <v-btn small color="orange" class="white--text" @click="getUser">Get user</v-btn>
    </div>
</body>
</html>