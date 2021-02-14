<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jeune Barreau Neuchâtelois - JBNE</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>

    </style>

    <style>
        body {
            font-family: 'Nunito';
        }

        [v-cloak] {
            display: none;
        }
    </style>
</head>

<body class="">
    <div id="app" v-cloak>
        <v-app>
            <h1>JBNE - Laravel 8</h1>
            {{-- <example-component></example-component> --}}
            <v-row no-gutters>
                <v-col cols="12">
                    <a href="/about">About</a> |
                    <a href="/login">Login</a> |
                    <a href="/home">Home</a> |
                    <a href="/admin/index">Admin</a> |
                    <a href="/permanences">Permanences</a>
                </v-col>
            </v-row>
            {{-- <login-component></login-component> --}}
            <v-row no-gutters justify-center>
                <v-col cols="12">
                    <v-btn small color="blue" class="white--text" @click="incrementCounter">Increment</v-btn>
                    <v-btn small color="orange" class="white--text" @click="getUser">Get user</v-btn>

                </v-col>
                <v-col cols="12">
                    <v-btn small color="pink" class="white--text" @click="login">Login</v-btn>
                    <v-btn small color="success" class="white--text" @click="register">Register</v-btn>
                    <a href="/forgot-password">Forgot password</a>
                    {{-- <v-btn small color="error" class="white--text" @click="forgotPassword">Forgot password</v-btn> --}}
                    @if (Auth::check())
                    <v-chip class="ma-2" color="success" outlined>
                        User is logged in
                    </v-chip>
                    <v-btn small color="warning" class="white--text" @click="logout">Logout</v-btn>
                    @else
                    <v-chip class="ma-2" color="error">
                        User is not logged in
                    </v-chip>
                    @endif
                </v-col>
                <v-col cols="12">
                    @role('student')
                    I am <span style="color: green;">a</span> student!
                    @else
                    I am <span style="color: red;">not</span> a student.
                    @endrole
                    <br />
                    @role('lawyer')
                    I am <span style="color: green;">a</span> lawyer!
                    @else
                    I am <span style="color: red;">not</span> an lawyer.
                    @endrole
                    <br />
                    @role('admin')
                    I am <span style="color: green;">a</span> admin!
                    @else
                    I am <span style="color: red;">not</span> a admin.
                    @endrole
                </v-col>
            </v-row>
        </v-app>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>