@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Change Password</div>

                <div class="card-body">
                    <form method="post" action="{{ route('updatePassword') }} ">
                        @csrf
                      <div class="form-group">
                        <label for="oldPassword">Old Password</label>
                        <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword" aria-describedby="emailHelp" placeholder="Enter old password" name="oldPassword">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="newpassword">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="newpassword" placeholder="Password" name="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="newpasswordb">Retype new password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="newpasswordb" placeholder="Retype new password" name="password_confirmation">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      
                      <button type="submit" class="btn btn-primary">Change Password</button>
                      <a href="{{ route('home') }}" class="btn btn-secondary float-right">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
