@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')

  <div class="container">
    <div class="containerrow">
      <form class="form" action="{{ route("appointments.appointment-date") }}">
        <h4>Make An Appointment</h4>

        <input type="hidden" name="unique_id" value="{{ $appointment->unique_id }}" required>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Booking Type</label>
            <select class="form-control" name="booking_type" required>
              <option value="">---Select---</option>
              @foreach ($bookingTypes as $bookingType)
                <option value="{{ $bookingType->id }}" {{ $bookingType->id === $appointment->booking_type_id ? 'selected' : '' }}>{{ $bookingType->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Number of Applicants</label>
            <input type="number" min="1" max="10" class="form-control" name="total_applicants" placeholder="---Insert (1-10)---" required value="{{ $appointment->total_applicants }}">
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-form-sbmt mt-3">Book Appointment <img src="{{ url('img/arrow-right.png') }}"></button>
      </form>
    </div>
  </div>
@endsection