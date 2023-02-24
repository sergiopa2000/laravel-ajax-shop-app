@extends('admin.index-layout')
@section('table')
<div class="row" style="width: 100%;margin: 0;">
    
    @if(session('categoryDeleteSuccess'))
        <div class="alert alert-success">{{ session('categoryDeleteSuccess') }}</div>
    @endif
    @error('categoryDeleteError')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    @if(session('categoryUpdateSuccess'))
        <div class="alert alert-success">{{ session('categoryUpdateSuccess') }}</div>
    @endif
    @error('categoryUpdateError')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
   @if(session('categoryCreated'))
      <div class="alert alert-success">{{ session('categoryCreated') }}</div>
   @endif
   @error('categoryCreateError')
      <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	<div class="col-12 col-lg-8 col-xxl-9" style="width: 100%;padding: 0;">
		<div class="card flex-fill">
			<table class="table table-hover my-0">
				<thead>
					<tr>
						<th>Id</th>
						<th class="d-none d-xl-table-cell">Name</th>
						<th class="d-none d-xl-table-cell">Delete</th>
					</tr>
				</thead>
				<tbody>
				    @foreach($categories as $category)
					<tr>
					    <td>{{ $category->id }}</td>
						<td>{{ $category->name }}</td>
					    <td class="d-none d-md-table-cell"><a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-type="category" data-url="{{ url('admin/category/' . $category->id) }}" data-name="{{ $category->name }}"><i class="ti-trash mr-2" style="color:red;"></i></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<a href="{{ url('admin/category/create') }}" class="btn btn-primary" style="margin-top: 10px;">New Category</a>
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
                    <h5 class="modal-title">Delete category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:0;background:transparent;">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
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
@endsection