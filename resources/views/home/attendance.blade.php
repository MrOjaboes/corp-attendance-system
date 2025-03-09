@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css"
        media="screen">
@endsection


@section('content')
    <div class="card">

        <div class="card-body">
            <h3>{{ ucfirst($employee->name) }}'s Attendance for
                {{ \Carbon\Carbon::createFromDate(today())->format('D d M, Y') }}</h3>

        </div>
    </div>
 <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">

                    @if ($attendanceOpen)
                    <h5>Time Left to Submit Attendance: <span id="countdown"></span></h5>

                        <form action="{{ route('staff.attendance-store') }}" method="post">


                            @csrf
                            <input type="hidden" name="emp_id" value="{{ $employee->id }}">


                            @php

                                $date_picker = \Carbon\Carbon::createFromDate(today())->format('Y-m-d');
                            @endphp

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkmark" style="height: 40px" id="check_box"
                                    name="attd[{{ $date_picker }}][{{ $employee->id }}]" required type="checkbox"
                                    id="inlineCheckbox1" value="1">

                                    <button type="submit" class="btn btn-success" style="display: flex; margin:10px">Check In</button>
                            </div>

                        </form>
                    @else
                        <p id="elapsed-message" style="color:red; font-weight:bold;">Time Elapsed. Attendance is closed.</p>
                    @endif

            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
 </div>
 <script>
    document.addEventListener("DOMContentLoaded", function() {
        let countdownTime = {{ $countdownTime }};
        let countdownElement = document.getElementById("countdown");
        let attendanceForm = document.getElementById("attendance-form");
        let elapsedMessage = document.getElementById("elapsed-message");

        function updateCountdown() {
            let now = new Date().getTime();
            let timeLeft = countdownTime - now;

            if (timeLeft > 0) {
                let hours = Math.floor(timeLeft / (1000 * 60 * 60));
                let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                countdownElement.innerHTML = `${hours}h ${minutes}m ${seconds}s`;

                setTimeout(updateCountdown, 1000);
            } else {
                attendanceForm.style.display = "none"; // Hide form
                elapsedMessage.style.display = "block"; // Show "Time Elapsed" message
            }
        }

        updateCountdown();
    });
</script>
@endsection

<style>
    .checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 50px;
  width: 50px;
  background-color: #eee;
}
</style>

