<div class="scan">
    <div class="title">
        Scan
    </div>
    <div class="con">
        <div class="row">
            <div class="block-2 box btn-scan" id="open-camera">
                <div class="icon">
                    <i class="fa-regular fa-camera"></i>
                </div>
                <div class="message">Scan</div>
            </div>
            <div class="block-3 box btn-upload">
                <input type="file" id="qr-file" accept="image/*">
                <div class="icon">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <div class="message">Upload</div>
            </div>
        </div>
        <div class="row">
            <div class="block-4 box">
                <div class="message">Today’s Schedule <span id="today-attday"></span></div>
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

<div id="cam-popup" class="cam-width" style="display: none;">
    <div class="cam-con">
        <div class="header">
            <div class="logo">
                <h2>Attendance Scan</h2>
            </div>
            <div class="btn-close" id="close-camera">
                <div class="clc">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="camera" id="camera">
            <div class="reader" id="reader"></div>
        </div>
        <div class="footer">
            <button class="btn-flash">
                <i class="fa-solid fa-bolt"></i> Flash
            </button>
        </div>
    </div>
</div>