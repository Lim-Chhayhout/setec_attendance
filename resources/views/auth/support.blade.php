@extends('layouts.auth')

@section('title', 'SETEC Institute - Support')

@section('content')
    <header class="header-content">SETEC Support</header>
    <div class="support">
        <div class="col">
            <a href="{{ url('/forgot')}}" class="btn-link">
                <span>I Forgot my Password</span>
                <img src="{{ asset('assets/auth/images/Polygon.png')}}" width="14px">
            </a>
            <div class="guide">
                <p>ដើម្បីប្រើប្រាស់ <span>SETEC attendance</span> និស្សិតត្រូវអនុវត្តន៍ដូចខាងក្រោម៖</p>
                <ol>
                    <li>ត្រូវតែផ្លាស់ប្តូរលេខសម្ងាត់ក្នុងករណីទើបតែចូលប្រើប្រាស់ជាលើកដំបូង</li>
                    <li>ត្រូវចូលទៅកែប្រែអាសយដ្ឋាន <span>Email</span> ឱ្យបានត្រឹមត្រូវ</li>
                    <li>ករណីមិនអាចចូលទៅប្រើប្រាស់បាន សូមទំនាក់ទំនងមកកាន់វិទ្យាស្ថាន</li>
                </ol>
            </div>
            <div class="info">
                <div class="row">
                    <div class="title">Telegram:</div>
                    <div><span>093 822 848, 012 688 338</span> (For support)</div>
                </div>
                <div class="row">
                    <div class="title">Mobile:</div>
                    <div>010 880 612, 011 600 619</div>
                </div>
                <div class="row">
                    <div class="title">Facebook:</div>
                    <a href="https://www.setecu.com/" target="_blank">www.facebook.com/setecedu</a>
                </div>
                <div class="row">
                    <div class="title">Address:</div>
                    <div>No. 86A, Street 110, Russian Federation Boulevard,</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="con">
                <div class="overlay">
                    <a href="#" class="play-btn">
                        <img src="{{ asset('assets/auth/images/Polygon.png')}}" width="14px">
                    </a>
                </div>
                <img src="{{ asset('assets/auth/images/maxresdefault.jpg')}}" width="100%">
            </div>
        </div>
    </div>
@endsection