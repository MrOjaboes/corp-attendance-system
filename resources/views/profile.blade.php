@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css"
        media="screen">
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ ucfirst($user->name) }}'s Proile</h3>

        </div>
    </div>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="{{$user->name}}" placeholder="Enter full Name" id="name" name="name"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" value="{{$user->email}}" id="email" name="email">

                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">Password Update</h4>
                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update-password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Current Password</label>
                            <input type="password" class="form-control" placeholder="********"  name="current_password"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="name">New Password</label>
                            <input type="password" class="form-control" placeholder="********"  name="password"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="name">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="********"  name="password_confirmation"
                                required />
                        </div>



                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
