@extends('layouts.auth')

@section('title', 'SETEC Institute - Reset Password')

@section('content')
    <div class="auth">
        <div class="form-box">
            <div class="form-title">
                <h2 class="title">Reset Password</h2>
                <p class="des">Hi <b>std0123,</b> Please set a new password.</p>
            </div>
            <form action="">
                <div class="form-row">
                    <span class="action-label">New password</span>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="form-row">
                    <span class="action-label">Confirm password</span>
                    <input type="password" id="cf-password" name="cf-password" class="form-control">
                </div>
                <button type="submit">Reset</button>
            </form>
        </div>
    </div>
@endsection
