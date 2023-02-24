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
    <div class="container form-container mb-5 mt-4" style="min-height: 286px;">
       @error('colorCreateError')
          <div class="alert alert-danger">{{ $message }}</div>
       @enderror
        <form id="createProductForm" action="{{ url('admin/tag') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
           @csrf
   		    <div class="form-group mb-3">
			    <label for="name">Tag Name</label>
             <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="20" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
			<a href="{{ url()->previous() }}" class="btn btn-primary mt-3 btn-lg">Back</a>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Create Tag"/>
        </form>
    </div>
@endsection