@extends('admin.layouts.app')

@section('title', (isset($entry) ? 'Edit ' : 'Create ') . $title)

@section('content')
  @include('admin.layouts.page-header')

  <!-- DataTales Example -->
  <div class="card shadow mb-4 clearfix">
    <div class="card-body">
      <form class="needs-validation" action="{{ isset($entry) ? route('admin.'. $model .'.update', ["bookingTypeId" => $parentEntry, "cost" => $entry]) : route('admin.'. $model .'.store', $parentEntry) }}" method="POST">
        @csrf
        @isset($entry)
          @method('PATCH')
        @endisset
        <div class="form-row">
          {{-- Start --}}
          <div class="col-md-2 mb-3">
            <label>Age Week Start<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="age_week_start" placeholder="Week" value="{{ isset($entry) ? $entry->age_week_start : 0 }}" required>
          </div>
          <div class="col-md-2 mb-3">
            <label>Age Month Start<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="age_month_start" placeholder="Month" value="{{ isset($entry) ? $entry->age_month_start : 0 }}" required>
          </div>
          <div class="col-md-2 mb-3">
            <label>Age Year Start<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="age_year_start" placeholder="Year" value="{{ isset($entry) ? $entry->age_year_start : 0 }}" required>
          </div>

          {{-- End --}}
          <div class="col-md-2 mb-3">
            <label>Age Week End<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="age_week_end" placeholder="Week" value="{{ isset($entry) ? $entry->age_week_end : 0 }}" required>
          </div>
          <div class="col-md-2 mb-3">
            <label>Age Month End<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="age_month_end" placeholder="Month" value="{{ isset($entry) ? $entry->age_month_end : 0 }}" required>
          </div>
          <div class="col-md-2 mb-3">
            <label>Age Year End<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="age_year_end" placeholder="Year" value="{{ isset($entry) ? $entry->age_year_end : 0 }}" required>
          </div>

          <div class="col-md-12 mb-3">
            <label>Description<span class="text-danger font-weight-bold">*</span></label>
            <textarea class="form-control" name="description" rows="3" required placeholder="Description">{{ isset($entry) ? $entry->description : null }}</textarea>
          </div>
          <div class="col-md-4 mb-3">
            <label>Basic Fee<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="basic_fee" placeholder="Basic Fee" value="{{ isset($entry) ? $entry->basic_fee : null }}" required>
          </div>
          <div class="col-md-4 mb-3">
            <label>Immunization Fee<span class="text-danger fw-bold">*</span></label>
            <input type="number" class="form-control" name="immunization_fee" placeholder="Immunization Fee" value="{{ isset($entry) ? $entry->immunization_fee : null }}" required>
          </div>
        </div>
        <button class="btn btn-primary" entry="submit" id="submitForm">{{ (isset($entry) ? 'Update' : 'Save' ) }}&nbsp;<i class='fe fe-edit' title='{{ (isset($entry) ? 'Update' : 'Save' ) }}'></i></button>
      </form>
    </div>
  </div>
@endsection