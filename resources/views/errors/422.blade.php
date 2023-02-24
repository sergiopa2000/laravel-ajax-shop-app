@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ url('assets/css/404.css') }}" type="text/css" />
@endsection

@section('content')
<a href="{{ url('/') }}">
 <svg height="0.8em" width="0.8em" viewBox="0 0 2 1" preserveAspectRatio="none">
  <polyline
        fill="none" 
        stroke="#777777" 
        stroke-width="0.1" 
        points="0.9,0.1 0.1,0.5 0.9,0.9" 
  />
</svg> Home
</a>
<div class="background-wrapper">
	<h1 id="visual">422</h1>
</div>
<p>Your uploads exceeded the maximum size of <b style="color: red;">8MB</b>!</p>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('assets/js/404.js') }}"></script>
@endsection
