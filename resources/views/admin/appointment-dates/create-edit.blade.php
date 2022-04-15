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
            <label>Date<span class="text-danger fw-bold">*</span></label>
            <input type="date" class="form-control" name="date" placeholder="Date" value="{{ isset($entry) ? $entry->date : null }}" required>
          </div>
          <div class="col-md-4 mb-3">
            <label>Status<span class="text-danger fw-bold">*</span></label>
            <select name="status" value="" class="form-control">
              <option value="1" {{ isset($entry) && intval($entry->status) == 1 ? "selected" : "" }}>Active</option>
              <option value="0" {{ isset($entry) && intval($entry->status) == 0 ? "selected" : "" }}>Inactive</option>
            </select>
          </div>
        </div>
        <button class="btn btn-primary" entry="submit" id="submitForm">{{ (isset($entry) ? 'Update' : 'Save' ) }}&nbsp;<i class='fe fe-edit' title='{{ (isset($entry) ? 'Update' : 'Save' ) }}'></i></button>
      </form>
    </div>
  </div>
@endsection