@php
    $user = Auth::user();
@endphp


@if($qr && $qrData)
    <div class="scan">
        <div class="title">
            Attendance QR Code
        </div>
        <div class="con" id="apr-generated-p">
            <div class="col qr-c">
                <div class="box qr-card">
                    {!! $qr !!}
                </div>
            </div>
            <div class="col qr-de">
                <div class="box qr-detail">
                    <div class="top">
                        <div class="generated-at">
                            {{ $qrData['created_at'] }}
                        </div>
                    </div>
                    <div class="mid">
                        <i class="fa-regular fa-clock"></i>
                        <div class="duration-fe" data-expired="{{ $qrData['expired_at'] }}">0:00:00</div>
                    </div>
                    <div class="bottom">
                        <div class="row">
                            <span class="label">Subject:</span>
                            <span class="value">{{ $qrData['subject'] }}</span>
                        </div>
                        <div class="row">
                            <span class="label">Group:</span>
                            <span class="value">{{ $qrData['group'] }}</span>
                        </div>
                        <div class="row">
                            <span class="label">Room:</span>
                            <span class="value">{{ $qrData['room'] }}</span>
                        </div>
                        <div class="row">
                            <span class="label">Time:</span>
                            <span class="value">{{ $qrData['study_time'] }}</span>
                        </div>
                        @if($qrData['note'])
                            <div class="row"><span class="label">Note:</span> {{ $qrData['note'] }}</div>
                        @endif
                    </div>
                </div>
                <div class="btn-row">
                    <button onclick="downloadQrCode()" class="btn-down-qr"><i class="fa-solid fa-qrcode"></i> Download</button>
                    <form action="{{ route('qr.end')}}" method="POST" id="qr-end">
                        <button type="submit" class="btn-end-qr">End</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="scan" id="aqr-btn-p">
        <div class="title">
            Attendance QR Code
        </div>
        <div class="con">
            <div class="row">
                <div class="block-2 box btn-gen-qr" id="btn-gen">
                    <div class="icon">
                        <i class="fa-solid fa-qrcode"></i> 
                    </div>
                    <div class="message">Generate</div>
                </div>
            </div> 
        </div>
    </div>
    <div class="scan" id="aqr-generate-p" style="display: none;">
        <div class="title">
            Generate attendance
        </div>
        <div class="con">
            <form action="{{ route('qr.create')}}" method="POST" class="box gen-qr-form" id="qr-form">
                @csrf
                <div class="gen-fm-fe">
                    <div class="col">
                        <div class="form-row contain">
                            <span class="action-label">Subject</span>
                            <select name="subject">
                                @foreach ($user->teacher->subjects as $subject)
                                    <option value="{{ $subject->title }}">{{ $subject->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row contain">
                            <span class="action-label">Group</span>
                            <select name="group">
                                @foreach ($user->teacher->groups as $group)
                                    <option value="{{ $group->group_name }}">{{ $group->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <span class="action-label">Room</span>
                            <input type="text" name="room" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <span class="action-label">Note (optional)</span>
                            <input type="text" name="note" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="form-row contain">
                                <span class="action-label">Study Start Time</span>
                                <input type="time" name="time_start_study" class="form-control" required>
                            </div>
                            <div class="form-row contain">
                                <span class="action-label">Study End Time</span>
                                <input type="time" name="time_end_study" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <span class="action-label">Duration (min)</span>
                            <input type="number" name="duration" class="form-control" min="1" max="1440" required>
                        </div>
                    </div>
                </div>
                <div class="gen-fe">
                    <input type="hidden" name="generated_at" id="generated-at">
                    <div class="real-time" id="show-datetime"></div>
                    <button type="submit">Generate</button>
                </div>
            </form>
        </div>
    </div>
@endif


