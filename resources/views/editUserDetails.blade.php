@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Details</div>

                <div class="card-body">
                    <form method="post" action="{{ route('updateDetails') }} ">
                        @csrf
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="emailHelp" placeholder="name" name="name" value="{{ $userDetails->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>

                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{ route('home') }}" class="btn btn-secondary float-right">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
