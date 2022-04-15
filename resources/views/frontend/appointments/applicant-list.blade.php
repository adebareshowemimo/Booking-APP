@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')

  <form action="{{ route("appointments.checkout") }}" method="get">
    <input type="hidden" name="unique_id" value="{{ $appointment->unique_id }}" required>

    <div class="container">
      <div class="containerrow p-0 pb-4">
        <div class="btn-preset text-center py-3">
          <h4 class="text-white mb-0 text-uppercase">Primary Applicant's Contact Information</h4>
        </div>

        @foreach ($appointment->applicants as $applicant)
          @if ($applicant->applicant_order > 1)
            <div class="btn-preset text-center py-3">
              <h4 class="text-white mb-0 text-uppercase">Applicant Details: {{ $applicant->applicant_order }}</h4>
            </div>
          @endif
          @include('frontend.appointments.components.applicant-list', ["applicant" => $applicant, "appointment" => $appointment])
        @endforeach

        <div class="containerrow-padding">
          <a href="{{ route("appointments.applicant-registration", ["unique_id" => $appointment->unique_id, 'applicant_order' => $appointment->applicants]) }}">
            <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
          </a>
          <button type="submit" class="btn btn-primary float-right btn-form-sbmt mt-3">Continue</button>
        </div>
      </div>
    </div>
  </form>
@endsection