@extends('admin.layouts.app')

@section('title', 'Detail ' . $title)

@section('content')
  @include('admin.layouts.page-header')
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Order</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->applicant_order }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Surname</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->surname }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">First Name</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->first_name }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Other Names</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->other_names }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Birth Date</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->birth_date }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Gender</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->gender }}">
            </div>
          </div>
        </div>
      </div>
      <hr>
      <h4 class="font-weight-bold">Contact</h4>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Email</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->email }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Primary Phone</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->primary_phone_number }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Secondary Phone</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->secondary_phone_number }}">
            </div>
          </div>
        </div>
      </div>
      <hr>
      <h4 class="font-weight-bold">Biodata</h4>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Same As Primary</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->same_as_primary === 1 ? "Yes" : "No" }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Passport Number</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->passport_number }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Passport Expiration Date</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->passport_number }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Home Address in Nigeria</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->home_address_nigeria }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">US Intended Address</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->home_address_nigeria }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">US Intended Address</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->us_intended_address }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Home Address</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->home_address }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">State</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->state }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">City</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->biodata->city }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection