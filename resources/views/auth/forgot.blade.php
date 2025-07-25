@extends('layouts.auth')

@section('title', 'SETEC Institute - Forgot Password')

@section('content')
    <div class="auth">
        <div class="form-box">
            <div class="form-title">
                <h2 class="title">Forgot Password</h2>
                <p class="des">Enter your email to get the code.</p>
            </div>
            <form action="">
                <div class="form-row">
                    <span class="action-label">Email</span>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                <button type="submit">Send</button>
            </form>
            <div class="link-support">
                <div>Forget email?</div>
                <a href="{{ url('/support')}}">Click here</a>
            </div>
        </div>
    </div>
@endsection
