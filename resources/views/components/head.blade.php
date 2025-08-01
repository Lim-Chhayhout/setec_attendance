@php
    $user = Auth::user();
@endphp

@if ($user->role === 'student')
    <div class="header box">
        <div class="page-lander">
            Student / <span id="lander-text"></span>
        </div>
        <nav>
            <div class="item">
                <div class="icon">
                    <i class="fa-regular fa-bell"></i>
                </div>
            </div>
            <div class="item">
                <div class="profile" onclick="openProfile()">
                    <img src="{{ asset('storage/uploads/' . $user->student->image) }}" width="100%">
                </div>
            </div>
        </nav>
    </div>
    <div id="profilePopup" class="popup">
        <div class="popbox">
            <div class="box profile">
                <div class="profile-picture">
                    <img src="{{ asset('storage/uploads/' . $user->student->image) }}">
                </div>
                <div class="user-profile">
                    <div class="fullname">
                        {{ $user->student->first_name ?? ''}} {{ $user->student->last_name ?? ''}}
                    </div>
                    <div class="username">
                        #{{ $user->username ?? '' }}
                    </div>
                </div>
            </div>
            <div class="box profile">
                <div class="row">
                    <div class="title">Major</div>
                    <div class="data">{{ $user->student->major ?? '' }}, year {{ $user->student->year ?? '' }}</div>
                </div>
                <div class="row">
                    <div class="title">Group</div>
                    <div class="data">{{ $user->student->group->group_name ?? '' }}</div>
                </div>
                <div class="row">
                    <div class="title">Email</div>
                    <div class="data">{{ $user->email ?? '' }}</div>
                </div>
                <div class="row">
                    <div class="title">Address</div>
                    <div id="data-profile">{{ $user->student->full_address ?? '' }},</div>
                    {{ $user->student->province ?? '' }}.
                </div>  
                <div class="setting-profile">
                    <a href="#">Change my email</a>
                    <a href="#">Change my password</a>
                </div>
            </div>
            <div onclick="closeProfile()" class="btn-close">
                <div class="clc">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
@elseif ($user->role === 'teacher')
    <div class="header box">
        <div class="page-lander">
            Teacher / <span id="lander-text"></span>
        </div>
        <nav>
            <div class="item">
                <div class="icon">
                    <i class="fa-regular fa-bell"></i>
                </div>
            </div>
            <div class="item">
                <div class="profile" onclick="openProfile()">
                    <img src="{{ asset('storage/uploads/' . $user->teacher->image) }}" width="100%">
                </div>
            </div>
        </nav>
    </div>
    <div id="profilePopup" class="popup">
        <div class="popbox">
            <div class="box profile">
                <div class="profile-picture">
                    <img src="{{ asset('storage/uploads/' . $user->teacher->image) }}" width="100%">
                </div>
                <div class="user-profile">
                    <div class="fullname">
                        {{ $user->teacher->first_name ?? ''}} {{ $user->teacher->last_name ?? ''}}
                    </div>
                    <div class="username">
                        #{{ $user->username ?? '' }}
                    </div>
                </div>
            </div>
            <div class="box profile">
                <div class="row">
                    <div class="title">Position</div>
                    <div class="data">
                        @foreach ($user->teacher->positions as $position)
                            <div style="margin-bottom: 8px;"> {{ $position->title }} </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="title">Email</div>
                    <div class="data">{{ $user->email ?? '' }}</div>
                </div>
                <div class="row">
                    <div class="title">Address</div>
                    <div id="data-profile">{{ $user->teacher->full_address ?? '' }},</div>
                    {{ $user->teacher->province ?? '' }}.
                </div>  
                <div class="setting-profile">
                    <a href="#">Change my email</a>
                    <a href="#">Change my password</a>
                </div>
            </div>
            <div onclick="closeProfile()" class="btn-close">
                <div class="clc">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
@endif