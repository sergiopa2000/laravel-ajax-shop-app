@extends('layout')
@section('styles')
<link rel="stylesheet" href="{{ url('assets/css/dashboard.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('assets/css/themify-icons.css') }}" type="text/css" />
<style>
    .container-menu-desktop{
        height: 85px !important;    
    }
    
    .navbar, footer{
        padding: 8px 10%;
    }
    
    a{
        text-decoration: none !important;
    }
    
    th{
        font-weight: 800 !important; 
    }
    
    td, th{
        text-align: center;
    }
    
    .sidebar-brand{
        padding-top: 40px !important;
    }
    
    .ti-trash, .ti-pencil{
        cursor: pointer;
        font-size: 2em;
    }
    
    .table td{
        max-width: 250px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
@endsection
@section('content')
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">Admin Dashboard</span>
            </a>

			<ul class="sidebar-nav">
				<li class="sidebar-header">
					Resources
				</li>

					<li class="sidebar-item @if($productActive ?? '') active @endif">
						<a class="sidebar-link" href="{{ url('admin/product') }}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Products</span>
            </a>
					</li>

					<li class="sidebar-item @if($colorActive ?? '') active @endif">
						<a class="sidebar-link" href="{{ url('admin/color') }}">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Colors</span>
            </a>
					</li>

					<li class="sidebar-item @if($categoryActive ?? '') active @endif">
						<a class="sidebar-link" href="{{ url('admin/category') }}">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Categories</span>
            </a>
					</li>

					<li class="sidebar-item @if($tagActive ?? '') active @endif">
						<a class="sidebar-link" href="{{ url('admin/tag') }}">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Tags</span>
            </a>
					</li>

					<li class="sidebar-item @if($userActive ?? '') active @endif">
						<a class="sidebar-link" href="{{ url('admin/user') }}">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Users</span>
            </a>
				</ul>
			</div>
		</nav>
        
		<div class="main">
			<main class="content" style="padding: 10px;">
				<div class="container-fluid p-0">
				    @yield('table')
				</div>
			</main>
		</div>
	</div>
	
@yield('modals')
@endsection