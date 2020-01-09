@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12" style="text-align: center;">
                            <div class="user_img">
                                <img src="{{ asset('profile.jpg') }}" class="profile">
                            </div>
                            <div class="user_details">
                                <h2>{{ Auth::user()->name }}</h2>
                                <p class="email">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="user_action row">
                                <div class="col"><a href="{{ route('editDetails') }}" class="btn btn-primary">Edit Details</a></div>
                                <div class="col"><a href="{{ route('chagnePassword') }}" class="btn btn-secondary">Change Password</a></div>
                            </div>  
                        </div>   
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
