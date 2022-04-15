@extends('admin.layouts.app')

@section('content')

@include('admin.layouts.page-header')

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
          { title: 'ID', data: 'id', name: 'id' },
          { title: 'Date', data: 'date', name: 'date' },
          { title: 'Status', data: 'status', name: 'status',
            render: function (data, type, row) {
              var output = `<button class='btn btn-${data === 1 ? 'success' : 'danger'}'>${data === 1 ? 'Active' : 'Inactive'}</button>`;
              return output;
            }
          },
          { title: 'Created At', data: 'created_at', name: 'created_at' },
          { title: 'Updated At', data: 'updated_at', name: 'updated_at' },
          { title: 'Action', data: null, orderable: false, searchable: false,
            render: function (data, type, row) {
              var output = '';
              output += "<a href='./{{$model}}/" + row['id'] + "'><button class='btn btn-info'>Detail&nbsp;<i class='fe fe-info' title='Detail'></i></button></a>";
              output += "<a href='./{{$model}}/" + row['id'] + "/edit'><button class='btn btn-warning ml-1'>Edit&nbsp;<i class='fe fe-edit' title='Edit'></i></button></a>";
              return output;
            }
          }
        ]
      });
    });
  </script>
@endsection