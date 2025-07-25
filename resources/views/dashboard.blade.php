<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="{{ asset('assets/global/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
</head>
<body>

    <div class="dashboard-container">
        @if (auth()->user()->role === 'student')
            @include('components.sidebar-student')
        @elseif (auth()->user()->role === 'teacher')
            @include('components.sidebar-teacher')
        @endif
        <div class="con">
            @include('components.head')
            <div class="main" id="main-content">
                @if (auth()->user()->role === 'student')
                    @include('student.home')
                @elseif (auth()->user()->role === 'teacher')
                    @include('teacher.home')
                @endif
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/global/app.js')}}"></script>
    <script src="{{ asset('assets/dashboard/app.js')}}"></script>
</body>
</html>