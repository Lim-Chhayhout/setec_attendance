@if(session()->has('qr_session'))
    @php
        $qrData = session('qr_session');
    @endphp
    <div class="scan">
        <div class="title">
            Attendance QR Code
        </div>
        <div class="con" id="apr-generated-p">
            <div class="col qr-c">
                <div class="box qr-card">
                    {!! $qrData['qr'] !!}
                </div>
            </div>
            <div class="col qr-de">
                <div class="box qr-detail">
                    <div class="top">
                        <div class="generated-at">
                            {{ $qrData['created_at_format'] }}
                        </div>
                    </div>
                    <div class="mid">
                        <i class="fa-regular fa-clock"></i>
                        @php
                            $remaining = $qrData['expires_at'] - now()->timestamp;
                        @endphp
                        <div class="duration-fe" data-remaining="{{ $remaining }}"></div>
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
                            <span class="value">{{ $qrData['time_start_study'] }} - {{ $qrData['time_end_study'] }}</span>
                        </div>
                        @if($qrData['note'])
                            <div class="row">
                                <span class="label">Note:</span>
                                <span class="value">{{ $qrData['note'] ?? '' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="btn-row">
                    <button onclick="downloadQrCode()" class="btn-down-qr"><i class="fa-solid fa-qrcode"></i> Download</button>
                    <button class="btn-stop-qr">Stop</button>
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
                    <div class="des">Attendance QR Code</div>
                </div>
            </div> 
        </div>
    </div>
    <div class="scan" id="aqr-generate-p" style="display: none;">
        <div class="title">
            Generate attendance
        </div>
        <div class="con">
            <form action="{{ route('generate.post')}}" method="POST" class="box gen-qr-form" id="qr-form">
                @csrf
                <div class="gen-fm-fe">
                    <div class="col">
                        <div class="form-row">
                            <span class="action-label">Subject</span>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <span class="action-label">Group</span>
                            <input type="text" name="group" class="form-control" required>
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
                            <div class="form-row time">
                                <span class="action-label">Study Start Time</span>
                                <input type="time" name="time_start_study" class="form-control" required>
                            </div>
                            <div class="form-row time">
                                <span class="action-label">Study End Time</span>
                                <input type="time" name="time_end_study" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <span class="action-label">Duration (min)</span>
                            <input type="number" name="duration" class="form-control" required>
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

