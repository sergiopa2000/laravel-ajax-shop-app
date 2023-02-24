@extends('admin.index-layout')
@section('table')
<link href="{{ url('assets/css/uploader.css') }}" rel="stylesheet" type="text/css">
<div class="row" style="width: 100%;margin: 0;">
	<div id="admin-events" class="alert"></div>
@if(session('productDeleteSuccess'))
    <div class="alert alert-success">{{ session('productDeleteSuccess') }}</div>
@endif
@error('productDeleteError')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@if(session('productUpdateSuccess'))
    <div class="alert alert-success">{{ session('productUpdateSuccess') }}</div>
@endif
@error('productUpdateError')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@if(session('productCreated'))
  <div class="alert alert-success">{{ session('productCreated') }}</div>
@endif
@error('productCreateError')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="col-12 col-lg-8 col-xxl-9" style="width: 100%;padding: 0;">
	<div class="card flex-fill">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th>Id</th>
					<th class="d-none d-xl-table-cell">Name</th>
					<th class="d-none d-xl-table-cell">Price</th>
					<th>Description</th>
					<th>Category</th>
					<th class="d-none d-md-table-cell">Created at</th>
					<th class="d-none d-md-table-cell">Delete</th>
					<th class="d-none d-md-table-cell">Edit</th>
				</tr>
			</thead>
			<tbody id="admin-product-table">
			    @foreach($products as $product)
				<tr>
				    <td>{{ $product->id }}</td>
					<td>{{ $product->name }}</td>
					<td class="d-none d-xl-table-cell">{{ $product->price }} $</td>
					<td class="d-none d-md-table-cell">{{ $product->description }}</td>
					<td class="d-none d-md-table-cell">{{ $product->category->name }}</td>
					<td class="d-none d-md-table-cell">{{ $product->created_at }}</td>
				    <td class="d-none d-md-table-cell"><a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-type="product" data-url="{{ url('admin/product/' . $product->id) }}" data-name="{{ $product->name }}"><i class="ti-trash mr-2" style="color:red;"></i></a></td>
				    <td class="d-none d-md-table-cell"><a class="editButton" href="" data-toggle="modal" data-target="#editProductModal" data-name="{{ $product->name }}" data-description="{{ $product->description }}" data-price="{{ $product->price }}" data-category="{{ $product->category->id }}" data-images="{{ $product->images }}" data-tags="{{ $product->tags }}" data-colors="{{ $product->colors }}" data-url="{{ url('admin/product/' . $product->id) }}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
<a href="" data-toggle="modal" data-target="#createProductModal" data-type="Product" data-url="{{ url('admin/product/') }}" class="btn btn-primary" style="margin-top: 10px;">New Product</a>
@endsection

@section('modals')
<!-- Delete Product Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="deleteForm">
                @method('delete')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Delete product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:0;background:transparent;">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" value="Delete"></input>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="post" id="createForm">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Create product</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:0;background:transparent;">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
             	   <div class="form-group mb-3">
					    <label for="name">Product Name</label>
		             <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" minlength="8" maxlength="20" required>
		              @error('name')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		             @enderror
					</div>
					
		   		    <div class="form-group mb-3">
					    <label for="description">Product Price</label>
		             <input id="number" type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
		              @error('price')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		             @enderror
					</div>
					
		   		    <div class="form-group mb-3">
					    <label for="description">Product Description</label>
		             <textarea id="description" rows="8" type="number" name="description" class="form-control @error('description') is-invalid @enderror" minlength="15" required>{{ old('description') }}</textarea>
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
		                    <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
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
		    		    	<div style="width:fit-content;" class="tag-input-container flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
		                        <input value='{"id": {{ $tag->id }}, "value": 0}' type="hidden" name="tags[]"/>
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
		    		    	<div data-class="{{ $color->name }}-active" style="width:fit-content;" class="color-input-container {{ $color->name }} flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
		                        <input value='{"id": {{ $color->id }}, "value": 0}' type="hidden" name="colors[]"/>
		                        {{ $color->name }}
		    				</div>
		    				@endforeach
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="submit" value="Create Product"/>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="post" id="editForm">
                @method('put')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:0;background:transparent;">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="form-group mb-3">
					    <label for="edit-name">Product Name</label>
		             <input id="edit-name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" minlength="8" maxlength="20" required>
		              @error('name')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		             @enderror
					</div>
					
		   		    <div class="form-group mb-3">
					    <label for="edit-price">Product Price</label>
		             <input id="edit-price" type="number" name="price" class="form-control @error('price') is-invalid @enderror" required>
		              @error('price')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		             @enderror
					</div>
					
		   		    <div class="form-group mb-3">
					    <label for="edit-description">Product Description</label>
		             <textarea id="edit-description" rows="8" type="number" name="description" class="form-control @error('description') is-invalid @enderror" minlength="15" required></textarea>
		              @error('description')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		             @enderror
					</div>
					
					<div class="form-group mb-3">
		    			<label for="edit-category">Product Category</label>
		             <select id="edit-category" name="idCategory" class="form-select @error('category') is-invalid @enderror">
		                @foreach($categories as $category)
		                    <option id="edit-category-{{ $category->id }}" value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
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
		    		    	<div style="width:fit-content;" class="tag-input-container flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
		                        <input type="hidden" name="tags[{{$tag->id}}]"/>
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
		    		    	<div data-class="{{ $color->name }}-active" style="width:fit-content;" class="color-input-container {{ $color->name }} flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
		                        <input type="hidden" name="colors[{{$color->id}}]"/>
		                        {{ $color->name }}
		    				</div>
		    				@endforeach
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" value="Delete"></input>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('assets/js/review-delete-modal.js') }}"></script>

<script src="{{ url('assets/js/tags.js') }}"></script>
<script src="{{ url('assets/js/colors.js') }}"></script>

<script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>

<script src="{{ url('assets/js/multiple-uploader.js') }}"></script>
<script>
    let multipleUploader = new MultipleUploader('#multiple-uploader').init({
        maxUpload : 8, // maximum number of uploaded images
        maxSize:2, // in size in mb
        filesInpName:'images', // input name sent to backend
        formSelector: '#createForm', // form selector
        required: true
    });
</script>

<script type="text/javascript" src="{{ url('assets/js/create-modal.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/product-edit-modal.js') }}"></script>
@endsection