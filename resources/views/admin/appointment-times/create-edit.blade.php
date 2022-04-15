@extends('admin.layouts.app')

@section('title', (isset($entry) ? 'Edit ' : 'Create ') . $title)

@section('content')
  @include('admin.layouts.page-header')

  <!-- DataTales Example -->
  <div class="card shadow mb-4 clearfix">
    <div class="card-body">
      <form class="needs-validation" action="{{ isset($entry) ? route('admin.'. $model .'.update', ["appointmentDateId" => $parentEntry, "appointment_time" => $entry]) : route('admin.'. $model .'.store', $parentEntry) }}" method="POST">
        @csrf
        @isset($entry)
          @method('PATCH')
        @endisset
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label>Time<span class="text-danger fw-bold">*</span></label>
            <input type="time" class="form-control" name="time" placeholder="Time" value="{{ isset($entry) ? $entry->time : null }}" required>
          </div>
          <div class="col-md-4 mb-3">
            <label>Slot<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="slot" placeholder="Slot" value="{{ isset($entry) ? $entry->slot : null }}" required>
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