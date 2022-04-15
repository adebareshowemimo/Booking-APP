@extends('admin.layouts.app')

@section('content')

@include('admin.layouts.page-header', ["allowCreate" => false])

<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable" class="table table-striped table-bordered text-nowrap w-100"></table>
        </div>
      </div>
      <!-- TABLE WRAPPER -->
    </div>
    <!-- SECTION WRAPPER -->
  </div>
</div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        ajax: {
          url: '{{ route("admin." . $model . ".datatables") }}',
          type: "POST",
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        },
        dom: 'Blfrtip',
        buttons: [
          {
            text: 'Refresh&nbsp;<i class="glyphicon glyphicon-refresh"></i>',
            action: function (e, data, node, config) {
              this.ajax.reload();
            }
          }
        ],
        columns: [
          { title: 'Unique ID', data: 'unique_id', name: 'unique_id' },
          { title: 'Booking Type', data: 'booking_type_id', name: 'unique_id' },
          { title: 'Booking Date Time', data: 'booking_date_time', name: 'booking_date_time' },
          { title: 'Payment Status', data: 'payment_status', name: 'payment_status' },
          { title: 'Payment Amount', data: 'payment_amount', name: 'payment_amount' },
          { title: 'Payment Date', data: 'payment_date', name: 'payment_date' },
          { title: 'Action', data: null, orderable: false, searchable: false,
            render: function (data, type, row) {
              var output = '';
              output += "<a href='./{{$model}}/" + row['id'] + "'><button class='btn btn-info'>Detail&nbsp;<i class='fe fe-info' title='Detail'></i></button></a>";
              return output;
            }
          }
        ]
      });
    });
  </script>
@endsection