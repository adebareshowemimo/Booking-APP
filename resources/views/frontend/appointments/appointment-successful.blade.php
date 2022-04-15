@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')
  <div class="container">
    <div class="containerrow p-0 pb-4">
      <div class="btn-preset text-center py-3">
        <h4 class="text-white mb-0 text-uppercase">Appointment Successful</h4>
      </div>

      <div class="col my-4 px-4">
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti placeat veritatis eos perspiciatis neque omnis illo maxime quidem voluptatum. Voluptatibus laboriosam rem earum recusandae velit! Itaque nihil magnam molestiae odio!</p>
      </div>

      <div class="containerrow-padding">
        <a href="{{ route("home") }}">
          <button type="submit" class="btn btn-primary float-right btn-form-sbmt mt-3">Back Home</button>
        </a>
      </div>
    </div>
  </div>
@endsection