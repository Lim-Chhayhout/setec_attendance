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
                    Welcome back, <span>{{ $user->student->first_name }} {{ $user->student->last_name }}</span>
                </div>
                <div class="des" id="show-datetime"></div>
            </div>
        </div>
        <div class="row">
            <div class="block-4 box">
                <div class="message">Last Attendance <span id="last-attday"></span></div>
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Time Slot</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Check-in Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1:00 – 2:30&nbsp;PM</td>
                            <td>WP (1H)</td>
                            <td class="present">✅ Present</td>
                            <td>1:02&nbsp;PM</td>
                        </tr>

                        <tr>
                            <td>2:45 – 4:15&nbsp;PM</td>
                            <td>SA II (3C)</td>
                            <td class="absent">❌ Absent</td>
                            <td>–</td>
                        </tr>

                        <tr>
                            <td>4:15 – 5:15&nbsp;PM</td>
                            <td>PP (3C)</td>
                            <td class="present">✅ Present</td>
                            <td>4:18&nbsp;PM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>