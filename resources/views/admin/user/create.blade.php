@extends('layout')
@section('styles')
<style>
    .form-select{
        display: block;
        width: 100%;
        padding: .375rem 2.25rem .375rem .75rem;
        -moz-padding-start: calc(0.75rem - 3px);
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-position-x: right 0.75rem;
        background-position-y: center;
        background-size: 16px 12px;
        border: 1px solid #ced4da;
        border-radius: .375rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>
@endsection
@section('content')
    <div class="container form-container mb-5 mt-4">
       @error('userCreateError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
        <form action="{{ route('user.store') }}" method="POST" style="width: 100%;">
           @csrf
           @method('post')
		    <div class="form-group mb-3">
			    <label for="name">User name</label>
             <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" minlength="8" maxlength="60" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
		    <label for="email">User email</label>
             <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" minlength="8" maxlength="60" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			 <label for="verified">User verified</label>
			 <select name="verified" class="form-select @error('verified') is-invalid @enderror" required>
     		         <option value="yes">Yes</option>
			         <option value="no" selected>No</option>
			 </select>
           @error('verified')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
 		    <div class="form-group mb-3">
			 <label for="isAdmin">User is admin</label>
			 <select name="isAdmin" class="form-select @error('isAdmin') is-invalid @enderror" required>
     		         <option value="yes">Yes</option>
			         <option value="no" selected>No</option>
			 </select>
              @error('isAdmin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			    <label for="password">User password</label>
             <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" required>
              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Add User"/>
        </form>
    </div>
</div>
@endsection