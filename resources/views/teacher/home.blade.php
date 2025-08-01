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
        </div>
    </div>
</div>