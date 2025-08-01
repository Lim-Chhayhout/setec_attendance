@extends('layouts.auth')

@section('title', 'SETEC Institute - Login Attendance')

@section('content')
    <div class="auth">
        <div class="logo">
            <img src="{{ asset('assets/global/images/logo.png')}}">
        </div>
        <div class="form-box">
            <h2 class="form-title">Login</h2>
            <form id="login-form" method="POST">
                @csrf
                <div class="form-row" id="rowEP">
                    <span class="action-label">Username or email</span>
                    <input type="text" name="identifier" class="form-control" required>
                </div>
                <div class="form-row" id="rowPW">
                    <span class="action-label">Password</span>
                    <input type="password" name="password" class="form-control" required>
                    <span id="show-password" class="password-look" style="display: none;">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                    <span id="close-password" class="password-look" style="display: none;">
                        <i class="fa-regular fa-eye-slash"></i>
                    </span>
                </div>
                <div id="error-login" class="error-login" >
                    <span id="error-icon" style="display: none;">!</span>
                    <div id="error-text"></div>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="link-support">
                <div>Trouble with login?</div>
                <a href="{{ url('/support')}}">Click here</a>
            </div>
        </div>
    </div>
@endsection

<script>
    window.routes = {
        loginPost: "{{ route('login.post') }}"
    };
</script>


