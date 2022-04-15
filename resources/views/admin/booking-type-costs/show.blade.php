@extends('admin.layouts.app')

@section('title', 'Detail ' . $title)

@section('content')
  @include('admin.layouts.page-header')

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label font-weight-bold">Name</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" value="{{ $entry->name }}">
        </div>
      </div>
      <div class="form-group row">
        <div class="ml-auto float-right pageheader-btn">
          <a href="{{ route("admin.booking-type-costs.create", $entry) }}" class="btn btn-primary btn-icon text-white">
            Add Cost<i class="fe fe-plus"></i>
          </a>
        </div>
        <label class="col-sm-4 col-form-label font-weight-bold">Cost</label>
        <div class="col-sm-8">
          <table class="table table-striped table-bordered text-nowrap w-100">
            <thead>
              <tr>
                <th>Age From</th>
                <th>Age To</th>
                <th>Basic Fee</th>
                <th>Immunization Fee</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($entry->costs as $cost)
                <tr>
                  <td>{{ $cost->age_from }}</td>
                  <td>{{ $cost->age_to }}</td>
                  <td>{{ $cost->basic_fee ? "₦" . number_format($cost->basic_fee, 2) : '' }}</td>
                  <td>{{ $cost->immunization_fee ? "₦" . number_format($cost->immunization_fee, 2) : '' }}</td>
                  <td>{{ $cost->description }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <a href="{{ route('admin.' . $model . '.edit', $entry) }}">
        <button class="btn btn-warning">Edit&nbsp;<i class='fe fe-edit' title='Edit'></i></button>
      </a>
      <div class='d-inline-flex'>
        <form action="{{ route('admin.' . $model . '.destroy', $entry) }}" method="post">
          <input type='hidden' name='_method' value='DELETE'>
          <input type='hidden' name='_token' value='{{ csrf_token() }}'>
          <button type='submit' class='btn btn-danger' title='Delete {{ $title }}'>Delete&nbsp;<i class='fe fe-trash'></i></button>
        </form>
      </div>
    </div>
  </div>
@endsection