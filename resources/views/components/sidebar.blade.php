@php
    $user = Auth::user();
@endphp
<div class="sidebar box">
    <div class="row">
        <div class="logo">
            <img src="{{ asset('assets/global/images/logo.png')}}" width="100%">
        </div>
    </div>
    <div class="con">
        <div class="row">
            @if ($user->role === 'student')
                <nav class="menu-sidebar">
                    <div class="item" data-url="{{ route('student.page', 'home') }}">
                        <div class="icon">
                            <i class="fa-regular fa-house"></i>
                        </div>
                        <div class="title">Home</div>
                        <input type="hidden" value="Home">
                    </div>
                    <div class="item" data-url="{{ route('student.page', 'scan') }}">
                        <div class="icon">
                            <i class="fa-regular fa-camera"></i> 
                        </div>
                        <div class="title">Scan</div>
                        <input type="hidden" value="Scan">
                    </div>
                    <div class="item" data-url="{{ route('student.page', 'attendance') }}">
                        <div class="icon">
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                        <div class="title">My Attendance</div>
                        <input type="hidden" value="My Attendance">
                    </div>
                </nav>
            @elseif ($user->role === 'teacher')
                <nav class="menu-sidebar">
                    <div class="item" data-url="{{ route('teacher.page', 'home') }}">
                        <div class="icon">
                            <i class="fa-regular fa-house"></i>
                        </div>
                        <div class="title">Home</div>
                        <input type="hidden" value="Home">
                    </div>
                    <div class="item" data-url="{{ route('teacher.page', 'attendanceqrcode') }}">
                        <div class="icon">
                            <i class="fa-solid fa-qrcode"></i> 
                        </div>
                        <div class="title">Attendance QR Code</div>
                        <input type="hidden" value="Attendance QR Code">
                    </div>
                    <div class="item" data-url="{{ route('teacher.page', 'attendance') }}">
                        <div class="icon">
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                        <div class="title">Attendance</div>
                        <input type="hidden" value="Attendance">
                    </div>
                </nav>
            @endif
        </div>
        <form id="logout-form" action="{{ route('logout.post')}}" method="POST" class="row">
            @csrf
            <button type="submit" class="btn-logout" >
                Logout
            </button>
        </form>
    </div>
</div>