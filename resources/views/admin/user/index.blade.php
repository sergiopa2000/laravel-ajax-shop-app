@extends('admin.index-layout')
@section('table')
<div class="row" style="width: 100%;margin: 0;">
@if(session('userDeleteSuccess'))
    <div class="alert alert-success">{{ session('userDeleteSuccess') }}</div>
@endif
@error('userDeleteError')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@if(session('userUpdateSuccess'))
    <div class="alert alert-success">{{ session('userUpdateSuccess') }}</div>
@endif
@error('userUpdateError')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@if(session('userCreated'))
  <div class="alert alert-success">{{ session('userCreated') }}</div>
@endif
@error('userCreateError')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="col-12 col-lg-8 col-xxl-9" style="width: 100%;padding: 0;">
	<div class="card flex-fill">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th>Id</th>
					<th class="d-none d-xl-table-cell">Name</th>
					<th class="d-none d-xl-table-cell">Email</th>
					<th>Verified</th>
					<th>Admin</th>
					<th class="d-none d-md-table-cell">Account date</th>
					<th class="d-none d-md-table-cell">Delete</th>
					<th class="d-none d-md-table-cell">Edit</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($users as $user)
				<tr>
				    <td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td class="d-none d-xl-table-cell">{{ $user->email }}</td>
					@if($user->email_verified_at == null)
					    <td><span class="badge bg-danger">No</span></td>
					@else
					    <td><span class="badge bg-success">Yes</span></td>
					@endif
					@if($user->isAdmin == 0)
					    <td><span class="badge bg-danger">No</span></td>
					@else
					    <td><span class="badge bg-success">Yes</span></td>
					@endif
					<td class="d-none d-md-table-cell">{{ $user->created_at }}</td>
					@if($user->id != Auth::user()->id)
					    <td class="d-none d-md-table-cell"><a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-url="{{ url($user->name) }}" data-name="{{ $user->name }}"><i class="ti-trash mr-2" style="color:red;"></i></a></td>
					    <td class="d-none d-md-table-cell"><a href="{{ url('admin/user/' . $user->id . '/edit') }}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
					@else
					    <td class="d-none d-md-table-cell"></td>
					    <td class="d-none d-md-table-cell"><a href="{{ url('admin/user/' . $user->id . '/edit') }}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
<a href="{{ url('admin/user/create') }}" class="btn btn-primary" style="margin-top: 10px;">New User</a>
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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('assets/js/review-delete-modal.js') }}"></script>
@endsection