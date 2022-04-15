@extends('admin.layouts.app')

@section('content')
<div class="row col">
  <div class="flex items-center justify-end mb-2 mr-3">
    <a href="{{ route("auth.redirect", ["provider" => "google"]) }}">
      <button class="btn btn-outline-primary"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/800px-Google_%22G%22_Logo.svg.png" width="20" class="mr-2">Sign In with Google</button>
    </a>
  </div>
  <div class="flex items-center justify-end mb-2 mr-3">
    <a href="{{ route("auth.redirect", ["provider" => "wordpress"]) }}">
      <button class="btn btn-outline-info"><img src="https://www.pngall.com/wp-content/uploads/2016/05/WordPress-Logo-PNG-HD.png" width="20" class="mr-2">Sign In with Wordpress</button>
    </a>
  </div>
  <div class="flex items-center justify-end mb-2 mr-3">
    <a href="{{ route("auth.redirect", ["provider" => "microsoft"]) }}">
      <button class="btn btn-outline-success"><img src="https://cdn-icons-png.flaticon.com/512/732/732221.png" width="20" class="mr-2">Sign In with Microsoft</button>
    </a>
  </div>
</div>
@endsection