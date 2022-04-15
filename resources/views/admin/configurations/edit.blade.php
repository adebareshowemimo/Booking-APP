@extends('admin.layouts.app')

@section('content')

@include('admin.layouts.page-header')

<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable" class="table table-striped table-bordered text-nowrap w-100"></table>
        </div>
      </div>
      <!-- TABLE WRAPPER -->
    </div>
    <!-- SECTION WRAPPER -->
  </div>
</div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $('.ckeditor').ckeditor();
    });
  </script>
@endsection
