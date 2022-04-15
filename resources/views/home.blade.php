@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="containerrow">
        <h3 class="text-center my-4">eQonsult<br>Terms and Conditions</h3>
        {!! $content->terms_contents !!}
      {{--
      <p>
        Our eQonsult services are now available for only out-patient clients. To begin your booking, tick “I agree” below
        and fill out the appointment request form or contact the office to book with one of our Customer Service Officer.
      </p>
      <p>
        <b>Requirements:</b>
      </p>

      <ul class="list-group">
        <li class="list-group-item">Smart phone or laptop with good internet connection</li>
        <li class="list-group-item">WhatsApp installed for voice/video calls</li>
        <li class="list-group-item">Evidence of payment for all transactions</li>
      </ul>
      <p class="mt-3">
        <b>Method</b>: The doctor will initiate the call via WhatsApp at the appointed time.
      </p>
      <p class="mt-3">
        <b>Time</b>: The allocated duration for each consultation is about 20 minutes. This may vary as required during
        consultation.
      </p>
      <p class="mt-3">
        <b>Conditions</b>:
      </p>
      <ul class="list-group">
        <li class="list-group-item">This service is for non-emergency medical cases.
          Consultations will be recorded for quality assurance, keeping all information confidential.
          Per request, medications can be dispatched after consultation within 24-48 hours.
          This service is for consultation only and may require a visit to the clinic for further investigations (as
          required).</li>
        <li class="list-group-item">The eQonsult fee is valid for 14 days if follow up is needed.
          Payments are to be made before the appointment is confirmed.
          All payments made are non-refundable.
          If you miss your consultation time, it can be <b>re-scheduled</b>.</li>
      </ul>
      <p class="mt-3">
        For further enquiries, please do not hesitate to contact us on <b>+2349048964641 +2348099742000,
        +2348113975433(alternate),</b> or <b><a href="mailto:customercare@qlifefamilyclinic.com">customercare@qlifefamilyclinic.com</a></b>
      </p>

      <p class="mt-3">
        <b>Disclaimer Regarding eQonsult Health Services</b><br>
        Our e-consultation service is by no means intended to substitute or relegate patients physical examination. We
        strongly advice our patients to visit their physicians, particularly where the constraints of e-consultation may
        affect proper examination. Accordingly, Q-Life to the maximum extent permitted by applicable law, is not liable for
        any indirect, incidental, special, compensatory, or consequential damages, whether incurred directly or indirectly,
        resulting from the use of its e-consultation services.
      </p>
      <p class="mt-3">
        To continue with your booking, please tick “I agree” and proceed to the next page
      </p> --}}

      <form class="form" method="POST" class="my-5" action="{{ route("appointments.generate") }}">
        @csrf
        <div class="mx-auto">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1" required>
            <label class="custom-control-label font-weight-normal" for="customCheck1">I agree to the terms and conditions</label>
          </div>
          <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary btn-form-sbmt mt-3">Book Appointment <img src="{{ url('img/arrow-right.png') }}"></button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
