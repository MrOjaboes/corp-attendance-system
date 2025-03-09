@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css"
        media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <h4 class="page-title text-left">Schedules</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Schedule</a></li>


        </ol>
    </div>
@endsection


@section('content')
    @include('includes.flash')

    <!--Show Validation Errors here-->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!--End showing Validation Errors here-->

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <form class="form-horizontal" method="POST" action="{{ route('schedule.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="time_in" class="col-sm-3 control-label">Time In</label>


                                    <div class="bootstrap-timepicker">
                                        <input type="datetime" value="{{ $schedule ? \Carbon\Carbon::parse($schedule->time_in)->format('H:i:s') : '' }}"
                                            class="form-control timepicker" id="time_in" name="time_in" required>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="time_out" class="col-sm-3 control-label">Time Out</label>


                                    <div class="bootstrap-timepicker">
                                        <input type="text" value="{{ $schedule ? \Carbon\Carbon::parse($schedule->time_out)->format('H:i:s') : '' }}"
                                            class="form-control timepicker" id="time_out" name="time_out" required>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                    Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    </div> <!-- end row -->



@endsection


@section('script')
    <!-- Responsive-table-->
    <script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>
@endsection
