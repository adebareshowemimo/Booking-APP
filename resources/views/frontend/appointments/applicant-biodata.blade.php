@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')

  <div class="container">
    <div class="containerrow">
      <form class="form" action="{{ route("appointments.store-applicant-biodata") }}" method="post">
        @csrf
        <h4>Complete Biodata Form</h4>

        <input type="hidden" name="unique_id" value="{{ $appointment->unique_id }}" required>

        <input type="hidden" name="is_editing" value="{{ request()->get('is_editing') }}">

        <input type="hidden" name="applicant_order" value="{{ $applicantOrder }}" required>

        <button type="button" class="btn btn-preset px-3 py-2">{{ intval($applicantOrder) === 1 ? "Primary Applicant" : "Applicant " . $applicantOrder }}</button>

        <div class="form-row mt-5">
          <div class="form-group col-md-6">
            <p class="mb-0">Surname*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Surname"></i>
              </div>
              <input type="text" placeholder="Surname*" class="form-control" name="surname" required value="{{ optional($applicant)->surname }}"></span>
            </div>
          </div>
          <div class="form-group col-md-6">
            <p class="mb-0">First Name*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="First Name"></i>
              </div>
              <input type="text" placeholder="First Name*" class="form-control" name="first_name" required value="{{ optional($applicant)->first_name }}"></span>
            </div>
          </div>
          <div class="form-group col-md-6">
            <p class="mb-0">Other Names*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Other Names"></i>
              </div>
              <input type="text" placeholder="Other Names" class="form-control" name="other_names" value="{{ optional($applicant)->other_names }}"></span>
            </div>
          </div>
          <div class="form-group d-none d-md-block col-md-6">
          </div>
          <div class="form-group col-md-6">
            <p class="mb-0">Birth Date*</p>
            <div class="input-group date">
              <div class="input-group">
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Date of Birth"></i>
                </div>
                <input required name="birth_date" type="text" id="birthDate" class="form-control d-none">
                <button type="button" class="btn btn-default" id="birthDate2">
                  <i class="fa fa-calendar"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <p class="mb-0">Gender*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Gender"></i>
              </div>
              <select class="form-control" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ optional($applicant)->gender == "Male" ? "selected" : "" }}>Male</option>
                <option value="Female" {{ optional($applicant)->gender == "Female" ? "selected" : "" }}>Female</option>
                <option value="Other" {{ optional($applicant)->gender == "Other" ? "selected" : "" }}>Other</option>
              </select>
            </div>
          </div>

          <div class="col-md-12 {{ optional($applicant)->applicant_order === 1 ? 'd-none' : '' }}">
            <hr class="my-4 pb-3">
            <p class="font-weight-bold my-3">Contact Information</p>
            <div class="custom-control custom-radio">
              <input type="radio" id="sameAsPrimary1" name="same_as_primary" value="1" class="custom-control-input"
                required>
              <label class="custom-control-label font-weight-normal option-label" for="sameAsPrimary1">Same contact information as Primary Applicant</label>
            </div>
            <div class="custom-control custom-radio my-2">
              <input type="radio" id="sameAsPrimary2" name="same_as_primary" value="0"
                class="custom-control-input pt-4" required>
              <label class="custom-control-label font-weight-normal option-label" for="sameAsPrimary2">Different contact information</label>
            </div>
            <div class="form-row mt-3" id="contactInformation">
              <div class="form-group col-md-12">
                <p class="mb-0">Email*</p>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Email"></i>
                  </div>
                  <input type="text" class="form-control" name="email" value="{{ optional($applicant->biodata)->email }}"></span>
                </div>
              </div>
              <div class="form-group col-md-6">
                <p class="mb-0">Phone Number*</p>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Phone Number"></i>
                  </div>
                  <input type="text" class="form-control" name="primary_phone_number" value="{{ optional($applicant->biodata)->primary_phone_number }}"></span>
                </div>
              </div>
              <div class="form-group col-md-6">
                <p class="mb-0">Phone Number (Optional)</p>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Phone Number (Optional)"></i>
                  </div>
                  <input type="text" class="form-control" name="secondary_phone_number" value="{{ optional($applicant->biodata)->secondary_phone_number }}"></span>
                </div>
              </div>
              <div class="form-group col-md-6">
                <p class="mb-0">State*</p>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="State"></i>
                  </div>
                  <select class="form-control" name="state">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                      <option value="{{ $state }}" {{ optional($applicant->biodata)->state == $state ? "selected" : "" }}>{{ $state }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group col-md-6">
                <p class="mb-0">City*</p>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="City"></i>
                  </div>
                  <input type="text" class="form-control" name="city" value="{{ optional($applicant->biodata)->city }}"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <hr class="my-4 pb-3">
            <p class="font-weight-bold my-3">Additional Information</p>
          </div>

          <div class="form-group col-md-6">
            <p class="mb-0">Passport Number*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Passport Number"></i>
              </div>
              <input type="text" class="form-control" name="passport_number" required value="{{ optional($applicant->biodata)->passport_number }}"></span>
            </div>
          </div>
          <div class="form-group col-md-6">
            <p class="mb-0">Passport Expiration Date*</p>
            <div class="input-group date">
              <div class="input-group">
                <div class="input-group-prepend">
                  <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Passport Expiration Date"></i>
                </div>
                <input required name="passport_expiration_date" type="text" id="passportDate" class="form-control d-none">
                <button type="button" class="btn btn-default" id="passportDate2">
                  <i class="fa fa-calendar"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-group col-md-12">
            <p class="mb-0">Home Address in Nigeria*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Home Address in Nigeria"></i>
              </div>
              <textarea class="form-control" name="home_address_nigeria" required>{!! optional($applicant->biodata)->home_address_nigeria !!}</textarea>
            </div>
          </div>
          <div class="form-group col-md-12">
            <p class="mb-0">Home Address*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Home Address"></i>
              </div>
              <textarea class="form-control" name="home_address" required>{{ optional($applicant->biodata)->home_address }}</textarea>
            </div>
          </div>
          <div class="form-group col-md-12">
            <p class="mb-0">US Intended Address*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="US Intended Address"></i>
              </div>
              <textarea class="form-control" name="us_intended_address" required>{{ optional($applicant->biodata)->us_intended_address }}</textarea>
            </div>
          </div>
          <div class="form-group col-md-6">
            <p class="mb-0">Case Number*</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <i class="px-2 my-auto fa fa-info-circle" data-toggle="tooltip" title="Case Number"></i>
              </div>
              <input type="text" class="form-control" name="case_number" required value="{{ optional($applicant->biodata)->case_number }}"></span>
            </div>
          </div>
        </div>
        <div class="form-row mt-3">
        </div>

        @if (intval($applicantOrder) === 1)
          <a href="{{ route("appointments.appointment-date", ["unique_id" => $appointment->unique_id]) }}">
            <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
          </a>
        @else
          <a href="{{ route("appointments.applicant-biodata", ["unique_id" => $appointment->unique_id, "applicant_order" => intval($applicantOrder) - 1]) }}">
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
  <style>
    .option-label {
      font-size: 1rem !important;
    }
  </style>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://unpkg.com/jquery-dropdown-datepicker"></script>
  <script>
    $(document).ready(function () {
      var applicantBirthDate = '{{ optional($applicant)->birth_date ? $applicant->birth_date->format("Y-m-d") : null }}';
      var passportExpirationDate = '{{ optional($applicant->biodata)->passport_expiration_date ? $applicant->biodata->passport_expiration_date->format("Y-m-d") : null }}';
      var sameAsPrimary = '{{ optional($applicant->biodata)->same_as_primary !== null ? $applicant->biodata->same_as_primary : null }}';

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

      // PASSPORT

      $('#passportDate').dropdownDatepicker({
        defaultDate: passportExpirationDate != '' ? passportExpirationDate : null,
        defaultDateFormat:'yyyy-mm-dd',
        wrapperClass: 'row col',
        dropdownClass:'form-control col-4',
        required: true,
        submitFormat:'yyyy-mm-dd',
        onChange: function(day, month, year){
          if (day && month && year) {
            $('#passportDate2').val(year + "-" + month + "-" + day);
            $('#passportDate2').datepicker('setDate', year + "-" + month + "-" + day);
          }
        }
      });

      $("#openPassportDate").on('click', function() {
        $('#passportDate2').datepicker('show');
      });

      var datepicker = $('#passportDate2').datepicker({
        format: "yyyy-mm-dd",
        endDate: moment().format("YYYY-MM-DD")
      })
      .on("changeDate", function(e) {
        $('#passportDate').dropdownDatepicker('destroy');
        const newDate = moment(e.date).format("YYYY-MM-DD");
        $('#passportDate').dropdownDatepicker({
          defaultDate: newDate,
          defaultDateFormat:'yyyy-mm-dd',
          wrapperClass: 'row col',
          dropdownClass:'form-control col-4',
          required: true,
          submitFormat:'yyyy-mm-dd',
          onChange: function(day, month, year){
            if (day && month && year) {
              $('#passportDate2').val(year + "-" + month + "-" + day);
              $('#passportDate2').datepicker('setDate', year + "-" + month + "-" + day);
            }
          }
        });
      });

      if (passportExpirationDate !== '') {
        $('#passportDate2').datepicker('setDate', passportExpirationDate);
      }

      // Contact Information
      $("input[name=same_as_primary]").on('change', function() {
        const selectedValue = parseInt($(this).val());
        if (selectedValue === 1) {
          $("#contactInformation").hide()
          $("input[name=email]").prop('required', false)
          $("input[name=primary_phone_number]").prop('required', false)
          $("select[name=state]").prop('required', false)
          $("input[name=city]").prop('required', false)
        } else {
          $("#contactInformation").show()
          $("input[name=email]").prop('required', true)
          $("input[name=primary_phone_number]").prop('required', true)
          $("select[name=state]").prop('required', true)
          $("input[name=city]").prop('required', true)
        }
      });

      if (sameAsPrimary && parseInt(sameAsPrimary) === 0) {
        $("#sameAsPrimary2").click();
      } else {
        $("#sameAsPrimary1").click();
      }
    });
  </script>
@endsection