@extends('admin.layouts.app')

@section('content')

@include('admin.layouts.simple-page-header', ['title' => 'Configurations', 'state' => 'Terms and Conditions', 'model' => 'configurations'])

<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('admin.configurations.update', 1) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <textarea class="ckeditor form-control" name="wysiwyg-editor">{{ $content->terms_contents ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
      <!-- TABLE WRAPPER -->
    </div>
    <!-- SECTION WRAPPER -->
  </div>
</div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
  </script>
@endsection
