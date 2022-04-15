@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')

  <div class="container">
    <div class="containerrow">
      <form class="form" action="{{ route("appointments.store-applicant") }}" method="post">
        @csrf
        <h4>Applicant Registration</h4>

        <input type="hidden" name="unique_id" value="{{ $appointment->unique_id }}" required>

        <input type="hidden" name="is_editing" value="{{ request()->get('is_editing') }}">

        <input type="hidden" name="applicant_order" value="{{ $applicantOrder }}" required>

        <button type="button" class="btn btn-preset px-3 py-2">{{ intval($applicantOrder) === 1 ? "Primary Applicant" : "Applicant " . $applicantOrder }}</button>

        <p class="font-weight-bold my-3">Name (Surname, First name, other name) - as it appears on the international passport</p>

        <div class="form-row">
          <div class="form-group col-md-6">

            <label for="surname">Surname*
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Surname"></i>
              </div>
            </label>
            <div class="input-group">

              <input type="text" class="form-control" name="surname" required value="{{ optional($applicant)->surname }}"></span>
            </div>
          </div>
          <div class="form-group col-md-6">

            <label for="first_name">First Name*
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="First Name"></i>
              </div>
            </label>

            <div class="input-group">

              <input type="text" class="form-control" name="first_name" required value="{{ optional($applicant)->first_name }}"></span>
            </div>
          </div>
          <div class="form-group col-md-6">

            <label for="other_names">Other Names*
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Other Names"></i>
              </div>
            </label>

            <div class="input-group">

              <input type="text" class="form-control" name="other_names" value="{{ optional($applicant)->other_names }}"></span>
            </div>
          </div>
          <div class="form-group d-none d-md-block col-md-6">
          </div>
          <div class="form-group col-md-6">
            <label for="birthDate">Birth Date*
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Date of Birth"></i>
              </div>
            </label>
            <div class="input-group date">
              <div class="input-group">

                <input required name="birth_date" type="text" id="birthDate" class="form-control d-none">
                <button type="button" class="btn btn-default" id="birthDate2">
                  <i class="fa fa-calendar"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">

            <label for="birthDate">Gender*
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Gender"></i>
              </div>
            </label>
            <div class="input-group">

              <select class="form-control" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ optional($applicant)->gender == "Male" ? "selected" : "" }}>Male</option>
                <option value="Female" {{ optional($applicant)->gender == "Female" ? "selected" : "" }}>Female</option>
                <option value="Other" {{ optional($applicant)->gender == "Other" ? "selected" : "" }}>Other</option>
              </select>
            </div>
          </div>
          @if (intval($applicantOrder) === 1)
            <div class="form-group col-md-12">

              <label for="Email">Email*
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Email"></i>
                </div>
              </label>
              <div class="input-group">

                <input type="text" class="form-control" name="email" required value="{{ $appointment->email }}"></span>
              </div>
            </div>
            <div class="form-group col-md-6">

              <label for="primary_phone_number">Phone Number*
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Phone Number"></i>
                </div>
              </label>
              <div class="input-group">
                <input type="text" class="form-control" name="primary_phone_number" required value="{{ $appointment->primary_phone_number }}"></span>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="secondary_phone_number">Phone Number (Optional)
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Phone Number (Optional)"></i>
                </div>
              </label>
              <div class="input-group">
                <input type="text" class="form-control" name="secondary_phone_number" value="{{ $appointment->secondary_phone_number }}"></span>
              </div>
            </div>
            <div class="form-group col-md-6">

              <label for="state">State*
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="State"></i>
                </div>
              </label>
              <div class="input-group">

                <select class="form-control" name="state" required>
                  <option value="">Select State</option>
                  @foreach ($states as $state)
                    <option value="{{ $state }}" {{ $appointment->state == $state ? "selected" : "" }}>{{ $state }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">

              <label for="city">City*
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="city"></i>
                </div>
              </label>
              <div class="input-group">
                <input type="text" placeholder="City*" class="form-control" name="city" required value="{{ $appointment->city }}"></span>
              </div>
            </div>
          @endif
        </div>
        <div class="form-row mt-3">
        </div>

        @if (intval($applicantOrder) === 1)
          <a href="{{ route("appointments.appointment-date", ["unique_id" => $appointment->unique_id]) }}">
            <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
          </a>
        @else
          <a href="{{ route("appointments.applicant-registration", ["unique_id" => $appointment->unique_id, "applicant_order" => intval($applicantOrder) - 1]) }}">
            <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
          </a>
        @endif
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://unpkg.com/jquery-dropdown-datepicker"></script>
  <script>
    $(document).ready(function () {
      var applicantBirthDate = '{{ optional($applicant)->birth_date ? $applicant->birth_date->format("Y-m-d") : null }}';

      $('#birthDate').dropdownDatepicker({
        defaultDate: applicantBirthDate,
        defaultDateFormat:'yyyy-mm-dd',
        wrapperClass: 'row col',
        dropdownClass:'form-control col-4',
        allowFuture: false,
        maxYear: {{ date('Y') }},
        required: true,
        submitFormat:'yyyy-mm-dd',
        onChange: function(day, month, year){
          if (day && month && year) {
            $('#birthDate2').val(year + "-" + month + "-" + day);
            $('#birthDate2').datepicker('setDate', year + "-" + month + "-" + day);
          }
        }
      });

      $("#openDatePicker").on('click', function() {
        $('#birthDate2').datepicker('show');
      });

      var datepicker = $('#birthDate2').datepicker({
        format: "yyyy-mm-dd",
        endDate: moment().format("YYYY-MM-DD")
      })
      .on("changeDate", function(e) {
        $('#birthDate').dropdownDatepicker('destroy');
        const newDate = moment(e.date).format("YYYY-MM-DD");
        $('#birthDate').dropdownDatepicker({
          defaultDate: newDate,
          defaultDateFormat:'yyyy-mm-dd',
          wrapperClass: 'row col',
          dropdownClass:'form-control col-4',
          allowFuture: false,
          maxYear: {{ date('Y') }},
          required: true,
          submitFormat:'yyyy-mm-dd',
          onChange: function(day, month, year){
            if (day && month && year) {
              $('#birthDate2').val(year + "-" + month + "-" + day);
              $('#birthDate2').datepicker('setDate', year + "-" + month + "-" + day);
            }
          }
        });
      });

      if (applicantBirthDate !== '') {
        $('#birthDate2').datepicker('setDate', applicantBirthDate);
      }
    });
  </script>
@endsection