@php
    $user = Auth::user();
@endphp
<div class="home">
    <div class="title">
        Home
    </div>
    <div class="con">
        <div class="row">
            <div class="block-1 box">
                <div class="message">
                    Welcome back, <span><span>{{ $user->teacher->first_name }} {{ $user->teacher->last_name }}</span></span>
                </div>
                <div class="des" id="show-datetime"></div>
            </div>
            <div class="block-2 box">
                <div class="pro-icon icon">
                    <i class="fa-regular fa-clock" style="color: #1d9100;"></i>
                </div>
                <div class="message">O II (1H)</div>
                <div class="des">24:17</div>
            </div>
        </div>
    </div>
</div>