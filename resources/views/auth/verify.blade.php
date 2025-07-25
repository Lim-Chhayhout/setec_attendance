@extends('layouts.auth')

@section('title', 'SETEC Institute - Verify Email')

@section('content')
    <div class="auth">
        <div class="form-box">
            <div class="form-title">
                <h2 class="title">Verify Email</h2>
                <p class="des">We sent a code to <b>test01@gmail.com.</b></p>
            </div>
            <form action="">
                <div class="form-row">
                    <span class="action-label">Code</span>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                <button type="submit">Confirm</button>
            </form>
            <div class="link-support">
                <a href="{{ url('/support')}}">Didn't get a code?</a>
            </div>
        </div>
    </div>
@endsection
