@extends('admin.layouts.app')

@section('title', 'Detail ' . $title)

@section('content')
  @include('admin.layouts.page-header')

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Date</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" value="{{ $entry->date }}">
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Status</label>
            <div class="col-sm-8">
              <button class='btn btn-{{ intval($entry->status) == 1 ? 'success' : 'danger' }}'>{{ intval($entry->status) == 1 ? 'Active' : 'Inactive' }}</button>
            </div>
          </div>
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
      <hr>
      <div class="form-group row">
        <div class="ml-auto float-right pageheader-btn">
          <a href="{{ route("admin.appointment-times.create", $entry) }}" class="btn btn-primary btn-icon text-white">
            Add Time<i class="fe fe-plus"></i>
          </a>
        </div>
        <label class="col-sm-4 col-form-label font-weight-bold">Times</label>
        <div class="col-sm-8">
          <table class="table table-striped table-bordered text-nowrap w-100">
            <thead>
              <tr>
                <th>ID</th>
                <th>Time</th>
                <th>Slot</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($entry->times as $time)
                <tr>
                  <td>{{ $time->id }}</td>
                  <td>{{ $time->time }}</td>
                  <td>{{ $time->slot }}</td>
                  <td>
                    <button class='btn btn-{{ intval($time->status) == 1 ? 'success' : 'danger' }}'>{{ intval($time->status) == 1 ? 'Active' : 'Inactive' }}</button>
                  </td>
                  <td>
                    <a href="{{ route('admin.appointment-times.edit', ["appointmentDateId" => $entry, "appointment_time" => $time]) }}">
                      <button class="btn btn-warning">Edit&nbsp;<i class='fe fe-edit' title='Edit'></i></button>
                    </a>
                    <div class='d-inline-flex'>
                      <form action="{{ route('admin.appointment-times.destroy', ["appointmentDateId" => $entry, "appointment_time" => $time]) }}" method="post">
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                        <button type='submit' class='btn btn-danger' title='Delete {{ $title }}'>Delete&nbsp;<i class='fe fe-trash'></i></button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection