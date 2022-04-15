<div class="col-md-8 mx-auto">
  <div class="container">
    <div class="form-row mt-4 mb-2">
      <div class="form-group col-md-6 mb-3">
        <label class="font-weight-bold d-block">SURNAME</label>
        <span>{{ optional($applicant)->surname }}</span>
      </div>
      <div class="form-group col-md-6 mb-3">
        <label class="font-weight-bold d-block">FIRST NAME</label>
        <span>{{ optional($applicant)->first_name }}</span>
      </div>
      <div class="form-group col-md-6 mb-3">
        <label class="font-weight-bold d-block">OTHER NAMES</label>
        <span>{{ optional($applicant)->other_names ?? "-" }}</span>
      </div>
      <div class="form-group col-md-6 mb-3">
        <label class="font-weight-bold d-block">DATE OF BIRTH</label>
        <span>{{ optional($applicant)->birth_date->format('M d Y') }}</span>
      </div>
      <div class="form-group col-md-6 mb-3">
        <label class="font-weight-bold d-block">GENDER</label>
        <span>{{ optional($applicant)->gender }}</span>
      </div>
      @if (optional($applicant)->application_order == 1)
        <div class="form-group col-md-6 mb-3">
          <label class="font-weight-bold d-block">EMAIL</label>
          <span>{{ optional($appointment)->email }}</span>
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="font-weight-bold d-block">PRIMARY PHONE NUMBER</label>
          <span>{{ optional($appointment)->primary_phone_number }}</span>
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="font-weight-bold d-block">SECONDARY PHONE NUMBER</label>
          <span>{{ optional($appointment)->secondary_phone_number }}</span>
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="font-weight-bold d-block">STATE</label>
          <span>{{ optional($appointment)->state }}</span>
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="font-weight-bold d-block">CITY</label>
          <span>{{ optional($appointment)->city }}</span>
        </div>
      @endif
    </div>

    <div class="text-center">
      <a class="btn btn-warning mb-4" href="{{ route("appointments.applicant-registration", ["unique_id" => $appointment->unique_id, "applicant_order" => $applicant->applicant_order, "is_editing" => true])}}">Edit</a>
    </div>
  </div>
</div>