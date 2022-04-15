@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')

  <div class="container">
    <div class="containerrow">
      <form class="form" action="{{ route("appointments.applicant-list") }}">
        <h4>Applicant Registration</h4>

        <button type="button" class="btn btn-preset px-3 py-2">Applicant 2</button>

        <p class="font-weight-bold my-3">Name (Surname, First name, other name) - as it appears on the international passport</p>

        <div class="form-row">
          <div class="form-group col-md-6">
            <input type="text" placeholder="Surname*" class="form-control" name="surname" required></span>
          </div>
          <div class="form-group col-md-6">
            <input type="text" placeholder="First Name*" class="form-control" name="first_name" required></span>
          </div>
          <div class="form-group col-md-6">
            <input type="text" placeholder="Other Names*" class="form-control" name="other_names"></span>
          </div>
          <div class="form-group col-md-6">
          </div>
          <div class="form-group col-md-6">
            <div class="input-group date">
              <input type="text" placeholder="Date of Birth*" class="form-control" name="birth_date" id="birthDate" required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>
          </div>
          <div class="form-group col-md-6">
            <select class="form-control" name="gender" required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
        </div>
        <div class="form-row mt-3">
        </div>
        <a href="{{ route("appointments.applicant-registration", ["unique_id" => $appointment->unique_id]) }}">
          <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
        </a>
        <button type="submit" class="btn btn-primary float-right btn-form-sbmt mt-3">Continue</button>
      </form>
    </div>
  </div>
@endsection

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function () {
      $('#birthDate').datepicker({
        format: "DD dd, MM yyyy"
      });
    });
  </script>
@endsection