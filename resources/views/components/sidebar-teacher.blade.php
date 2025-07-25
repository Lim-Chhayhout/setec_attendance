<div class="sidebar box">
    <div class="row">
        <div class="logo">
            <img src="{{ asset('assets/global/images/logo.png')}}" width="100%">
        </div>
    </div>
    <div class="con">
        <div class="row">
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
        </div>
        <form action="{{ route('logout.post')}}" method="POST" class="row">
            @csrf
            <button type="submit" class="btn-logout">
                Logout
            </button>
        </form>
    </div>
</div>