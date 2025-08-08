@php
    $user = Auth::user();
@endphp

@if ($user->role === 'student')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Default Title')</title>
        <link rel="stylesheet" href="{{ asset('assets/global/style.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/auth/student/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
        <script src="https://unpkg.com/html5-qrcode"></script>
    </head>
    <body>

        <div class="dashboard-container">
            @include('components.sidebar')
            <div class="con">
                @include('components.head')
                <div class="main" id="main-content">
                    @include('student.home')
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/global/app.js')}}"></script>
        <script src="{{ asset('assets/auth/student/app.js')}}"></script>
        
    </body>
    </html>
@elseif ($user->role === 'teacher')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Default Title')</title>
        <link rel="stylesheet" href="{{ asset('assets/global/style.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/auth/teacher/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    </head>
    <body>

        <div class="dashboard-container">
            @include('components.sidebar')
            <div class="con">
                @include('components.head')
                <div class="main" id="main-content">
                    @include('teacher.home')
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/global/app.js')}}"></script>
        <script src="{{ asset('assets/auth/teacher/app.js')}}"></script>

    </body>
    </html>
@endif