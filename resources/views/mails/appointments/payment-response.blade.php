@if ($appointment->payment_status == 'success')
  <p>Payment Successful</p>

  <p>Your slot was booked successfully.</br>
    For more details, check your email address. </br>
    Proceed to complete your BioData using the link below.</p>

  <a href="{{ route("appointments.applicant-biodata", ['unique_id' => $appointment->unique_id]) }}">
    <button type="submit" class="btn btn-primary  btn-form-sbmt mt-3 bio_button_q">Complete Biodata</button>
  </a>
@else
  <p>Payment Failed</p>

  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti placeat veritatis eos perspiciatis neque omnis illo maxime quidem voluptatum. Voluptatibus laboriosam rem earum recusandae velit! Itaque nihil magnam molestiae odio!</p>

  <a href="{{ route("appointments.checkout", ['unique_id' => $appointment->unique_id]) }}">
    <button type="submit" class="btn btn-primary btn-form-sbmt mt-3 bio_button_q">Retry Payment</button>
  </a>
@endif