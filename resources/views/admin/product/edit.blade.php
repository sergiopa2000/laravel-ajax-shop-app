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
        <form id="createProductForm" action="{{ url('admin/product/' . $product->id) }}" method="post" enctype="multipart/form-data" style="width: 100%;">
           @csrf
           @method('put')
   		    <div class="form-group mb-3">
			    <label for="name">Product Name</label>
             <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" minlength="8" maxlength="20" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
			
   		    <div class="form-group mb-3">
			    <label for="description">Product Price</label>
             <input id="number" type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
              @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
			
   		    <div class="form-group mb-3">
			    <label for="description">Product Description</label>
             <textarea id="description" rows="8" type="number" name="description" class="form-control @error('description') is-invalid @enderror" minlength="15" required>{{ old('description', $product->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
			
			<div class="form-group mb-3">
    			<label for="idCategory">Product Category</label>
             <select id="idCategory" name="idCategory" class="form-select @error('category') is-invalid @enderror">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == $product->idCategory) selected @endif>{{ ucfirst($category->name) }}</option>
                @endforeach
             </select>
              @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
			</div>
	       <div class="form-group mb-3">
			    <label for="images">Product Images - Max 2MB each</label>
			    <div class="images-container">
                    @foreach($product->images as $image)
                    <div>
                       <img loading="lazy" src="{{ url('product/display/'. $image->path) }}" class="slider-img" alt="post-thumb">
                       <span class="deleteImageButton" data-url="{{ url('deleteImage/' . $image->id) }}">&#10006;</span>
                    </div>
                    @endforeach
			    </div>
                <div class="multiple-uploader" id="multiple-uploader">
                    <div class="mup-msg">
                        <span class="mup-main-msg">Click to upload images.</span>
                        <span class="mup-msg" id="max-upload-number">Upload up to 8 images</span>
                        <span class="mup-msg">Only png, jpg or jpeg images</span>
                    </div>
                </div>
                @error('images')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
			</div>
   		    <div class="form-group mb-3">
    		    <label for="tags">Tags</label>
		        <!-- TAGS -->
		        <div class="tag-container">
    		        @foreach($tags as $tag)
    		    	<div style="width:fit-content;" class="@if(in_array($tag->id, $productTags)) tag-active @endif tag-input-container flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                        <input @if(in_array($tag->id, $productTags)) value="1" @else value="0" @endif type="hidden" name="tags[{{$tag->id}}]"/>
                        {{ $tag->name }}
    				</div>
    				@endforeach
				</div>
			</div>
   		    <div class="form-group mb-3">
    		    <label for="tags">Colors</label>
		        <!-- TAGS -->
		        <div class="tag-container">
    		        @foreach($colors as $color)
    		        <style>
    		            .{{ $color->name }}-active{
    		                color: {{ $color->hexcode }};
    		                border: 1px solid {{ $color->hexcode }}
    		            }
    		            
    		            .{{ $color->name }}:hover{
    		                color: {{ $color->hexcode }};
    		                border: 1px solid {{ $color->hexcode }}
    		            }
    		        </style>
    		    	<div data-class="{{ $color->name }}-active" style="width:fit-content;" class="@if(in_array($color->id, $productColors)) {{ $color->name }}-active @endif color-input-container {{ $color->name }} flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                        <input @if(in_array($color->id, $productColors)) value="1" @else value="0" @endif type="hidden" name="colors[{{$color->id}}]"/>
                        {{ $color->name }}
    				</div>
    				@endforeach
				</div>
			</div>
            <a href="{{ url()->previous() }}" class="btn btn-primary mt-3 btn-lg">Back</a>
            <input class="btn btn-primary mt-3 btn-lg" type="submit" value="Update Product"/>
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