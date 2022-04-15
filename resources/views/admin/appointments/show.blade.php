@extends('admin.layouts.app')

@section('title', 'Detail ' . $title)

@section('content')
  @include('admin.layouts.page-header')

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Unique ID</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->unique_id }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Booking Date</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->booking_date_time }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Email</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->email }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Primary Phone</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->primary_phone_number }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Secondary Phone</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->secondary_phone_number }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">State</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->state }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">City</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->city }}">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Applicants</label>
        <div class="col-sm-8">
          <table class="table table-striped table-bordered text-nowrap w-100">
            <thead>
              <tr>
                <th>Order</th>
                <th>Full Name</th>
                <th>Other Name</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($entry->applicants as $applicant)
                <tr>
                  <td>{{ $applicant->applicant_order }}</td>
                  <td>{{ $applicant->first_name . " " . $applicant->surname }}</td>
                  <td>{{ $applicant->other_names }}</td>
                  <td>{{ $applicant->birth_date }}</td>
                  <td>{{ $applicant->gender }}</td>
                  <td>
                    <a href="{{ route('admin.applicants.show', $applicant->id) }}">
                      <button class="btn btn-warning">Detail&nbsp;<i class='fe fe-info' title='Detail'></i></button>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection