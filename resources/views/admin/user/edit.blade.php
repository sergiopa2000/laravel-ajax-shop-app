@extends('layout')
@section('styles')
<link href="{{ url('assets/css/uploader.css') }}" rel="stylesheet" type="text/css">
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
       @error('productCreateError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
        <form action="{{ url('admin/user/' . $user->id) }}" method="post" style="width: 100%;">
           @csrf
           @method('put')
		    <div class="form-group mb-3">
			    <label for="name">User name</label>
             <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" minlength="8" maxlength="60" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
		    <label for="email">User email</label>
             <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" minlength="8" maxlength="60" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			 <label for="verified">User verified</label>
			 <select name="verified" class="form-select @error('verified') is-invalid @enderror">
			     @if($user->email_verified_at)
			         <option value="yes" selected>Yes</option>
			         <option value="no">No</option>
			     @else
     		         <option value="yes">Yes</option>
			         <option value="no" selected>No</option>
			     @endif
			 </select>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
		    <div class="form-group mb-3">
			    <label for="password">User new password</label>
             <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Edit User"/>
        </form>
    </div>
   <!-- Delete Image form -->
  <form action="" method="post" id="deleteImageForm">
       @csrf
       @method('delete')
   </form>
@endsection

@section('scripts')
<script src="{{ url('assets/js/tags.js') }}"></script>
<script src="{{ url('assets/js/colors.js') }}"></script>

<script type="text/javascript" src="{{ url('assets/js/delete-image.js') }}" defer></script>
<script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>

<script src="{{ url('assets/js/multiple-uploader.js') }}"></script>
<script>
    let multipleUploader = new MultipleUploader('#multiple-uploader').init({
        maxUpload : 8, // maximum number of uploaded images
        maxSize:2, // in size in mb
        filesInpName:'images', // input name sent to backend
        formSelector: '#createProductForm', // form selector
    });
</script>
@endsection