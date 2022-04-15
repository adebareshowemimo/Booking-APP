@extends('layouts.app')

@section('content')
  @include('frontend.appointments.components.jumbotron')

  <div class="container">
    <div class="containerrow">
      <form class="form" method="post" action="{{ route("appointments.save-appointment-date") }}">
        @csrf
        <h4>Choose Appointment Date</h4>
        <input type="hidden" name="unique_id" value="{{ $appointment->unique_id }}" required>
        <label for="inputState">Preferred Appointment Date</label>
        <div class="form-row">
          <div class="form-group col-md-6">
            <div id="calendar"></div>
          </div>
          <div class="form-group col-md-6">
            <button type="button" class="btn btn-preset w-100">Find The Next Available Appointment Date</button>
            <div id="availableTime" class="my-4">
              <label for="inputState" class="d-block mb-3">Choose Preferred Time</label>
              <div id="timeList"></div>
            </div>
          </div>
        </div>
        <a href="{{ route("appointments.booking-type", ["unique_id" => $appointment->unique_id]) }}">
          <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
        </a>
        <button type="submit" class="btn btn-primary float-right btn-form-sbmt mt-3">Continue</button>
      </form>
    </div>
  </div>
@endsection

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha512-KXkS7cFeWpYwcoXxyfOumLyRGXMp7BTMTjwrgjMg0+hls4thG2JGzRgQtRfnAuKTn2KWTDZX4UdPg+xTs8k80Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .fc-highlight {
      background: green !important;
    }
  </style>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function () {
      $('#calendar').fullCalendar({
        disableDragging: true,
        events: {
          url: "{{ route('appointments.dates') }}",
          cache: false,
          data: {
            total_applicants: '{{ optional($appointment)->total_applicants }}'
          },
        },
        eventClick: function(info) {
          $('#calendar').fullCalendar('select', info.date);
          changeDate(info.date);
        },
        eventRender: function(event, element) {
          element.css("font-size", "1.1em");
          element.css("padding", "5px");
          element.css("text-algin", "center");
        },
        dayClick: function(date, jsEvent, view) {
          if (date.isBefore(moment().add(+4, 'days')))
            return false;
          changeDate(date.format());
        },
        selectable: true,
        hiddenDays: [0],
        selectAllow: function(info) {
          if (info.start.isBefore(moment().add(+4, 'days')))
            return false;
          return true;
        }
      });

      $("#availableTime").hide();

      var appointmentDate = $('#appointmentDate').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        // format: {
        //   toDisplay: function (date, format, language) {
        //     return moment(date).format("MMMM Do YYYY");
        //   },
        //   toValue: function (date, format, language) {
        //     return moment(date).format("YYYY-MM-DD");
        //   }
        // },
        startDate: '+4d',
        daysOfWeekDisabled: [0]
      });

      function changeDate(date) {
        var html = "";
        $("#availableTime").show();
        $("#timeList").html(html);
        $.ajax({
          url: `{{ route('appointments.slots') }}`,
          cache: false,
          method: "GET",
          data: {
            date: date,
          },
          success: function(response) {
            if (response.status == "success" && response.data.length > 0) {

              var total_applicants = {{ optional($appointment)->total_applicants }};
              response.data.forEach((schedule, index) => {
                var slotsLeft = parseInt(schedule.available_slot);
                if (slotsLeft > 0) {
                  html += `<div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline${index}" name="booking_date_time" class="custom-control-input" required value="${moment(schedule.schedule).format("YYYY-MM-DD HH:mm:ss")}" ${total_applicants > schedule.available_slot ? 'disabled' : ''}>
                    <label class="custom-control-label font-weight-normal" for="customRadioInline${index}">${moment(schedule.schedule).format("hh:mm A")}&nbsp;<span class="badge badge-pill badge-${slotsLeft <= 5 ? 'danger' : 'success'}">${slotsLeft} slot</span></label>
                  </div>`;
                }
              });
            } else {
              html += "<p>No available slot at this date, please select another date</p>";
            }
            $("#timeList").html(html);
          },
          error: function(e){
            html += "<p>No available slot at this date, please select another date</p>";
            $("#timeList").html(html);
          }
        });
      }
    });
  </script>
@endsection