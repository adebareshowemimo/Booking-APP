@extends('admin.layouts.app')

@section('title', (isset($entry) ? 'Edit ' : 'Create ') . $title)

@section('content')
  @include('admin.layouts.page-header')

  <!-- DataTales Example -->
  <div class="card shadow mb-4 clearfix">
    <div class="card-body">
      <form class="needs-validation" action="{{ isset($entry) ? route('admin.'. $model .'.update', $entry) : route('admin.'. $model .'.store') }}" method="POST">
        @csrf
        @isset($entry)
          @method('PATCH')
        @endisset
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label>Name<span class="text-danger fw-bold">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ isset($entry) ? $entry->name : null }}" required>
            <div class="invalid-feedback">
              Name required
            </div>
          </div>
        </div>
        <button class="btn btn-primary" entry="submit" id="submitForm">{{ (isset($entry) ? 'Update' : 'Save' ) }}&nbsp;<i class='fe fe-edit' title='{{ (isset($entry) ? 'Update' : 'Save' ) }}'></i></button>
      </form>
    </div>
  </div>
@endsection