@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')
  <div class="container">
    @if ($payment_status == "success")
      <div id="payment_response" class="containerrow p-0 pb-4 btn-preset">
        <div class=" text-center py-3">

          <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
          </svg>
          <h4 class="text-white mb-0 heading_payment">Payment Successful</h4>
        </div>

        <div class="col my-4 px-4 text-center">

          <p>Your slot was booked successfully.</br>
            For more details, check your email address. </br>
            Proceed to complete your BioData using the link below.</p>
        </div>

        <div class="containerrow-padding text-center">
          <a href="{{ route("appointments.applicant-biodata", ['unique_id' => $appointment->unique_id]) }}">
            <button type="submit" class="btn btn-primary  btn-form-sbmt mt-3 bio_button_q">Complete Data</button>
          </a>
        </div>
      </div>
    @else
    <div id="payment_response" class="containerrow p-0 pb-4 btn-preset">
      <div class=" text-center py-3">

      

        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
          <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
        <h4 class="text-white mb-0 heading_payment">Payment Failed</h4>
      </div>

      <div class="col my-4 px-4 text-center">

        <p>Sorry you have not completed the process of booking a slot.</br>
          For more details, check your email address. </br>
          Please use the link below to retry with another payment options.</p>
         
          
      </div>

      <div class="containerrow-padding text-center">
        <a href="{{ route("appointments.checkout", ['unique_id' => $appointment->unique_id]) }}">
          <button type="submit" class="btn btn-primary  btn-form-sbmt mt-3 bio_button_q">Retry Again</button>
        </a>
        <hr>
        <p>if issue persit, kndly contact us</p>
      </div>
     
    </div>
    @endif
  </div>
@endsection


