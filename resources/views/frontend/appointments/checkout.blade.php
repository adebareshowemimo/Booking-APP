@extends('layouts.app')

@section('content')
@include('frontend.appointments.components.jumbotron')

<div class="container">
  <div class="containerrow">
    <div class="row">
      <div class="col-md-6 mb-3">
        <button type="button" class="btn btn-preset px-3 py-2 mb-3 font-weight-bold">Invoice From</button>
        <span class="d-block font-weight-bold">
          {{ $siteInformation->name }}<br>
          {!! $siteInformation->address !!}
        </span>
      </div>
      <div class="col-md-4 offset-md-2 mb-3">
        <button type="button" class="btn btn-preset px-3 py-2 mb-3 font-weight-bold">Invoice To</button>
        <span class="d-block font-weight-bold">
          {{ $appointment->applicants[0]->surname . " " . $appointment->applicants[0]->first_name . " " .
          $appointment->applicants[0]->other_names }}<br>
          {{ $appointment->email }}<br>
          {{ $appointment->primary_phone_number . ($appointment->secondary_phone_number ? ", " .
          $appointment->secondary_phone_number : "") }}<br>
          {{ $appointment->state . ", " . $appointment->city }}
        </span>
      </div>
    </div>
    <table class="table mt-4 text-center">
      <thead id="applicantsTable">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Applicant Name</th>
          <th scope="col">Age</th>
          <th scope="col">Type of Plan</th>
          <th scope="col">Basic Fee</th>
          <th scope="col">Immunization Fee</th>
          <th scope="col">Description</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($appointment->applicants as $applicant)
        <tr>
          <td scope="row">{{ $applicant->applicant_order }}</td>
          <td scope="row">{{ $applicant->surname . " " . $applicant->first_name . " " . $applicant->other_names }}
          </td>
          <td scope="row">{{ $applicant->full_age }}</td>
          <td scope="row">{{ $appointment->booking_type->name }}</td>
          <td scope="row">{{ $applicant->basic_fee ? "₦" . number_format($applicant->basic_fee, 2) : '' }}</td>
          <td scope="row">{{ $applicant->immunization_fee ? "₦" . number_format($applicant->immunization_fee, 2) : '' }}</td>
          <td scope="row">{{ $applicant->booking_type_description }}</td>
          <td scope="row">{{ $applicant->sub_total_payment ? "₦" . number_format($applicant->sub_total_payment, 2) : '' }}</td>
        </tr>
        @endforeach
        <tr>
          <td colspan="7" class="text-right font-weight-bold pr-3">SUB TOTAL</td>
          <td>{{ $subTotalPayments ? "₦" . number_format($subTotalPayments, 2) : '' }}</td>
        </tr>
        <tr>
          <td colspan="7" class="border-top-0 text-right font-weight-bold">VAT</td>
          <td>{{ $vat }}%</td>
        </tr>
        <tr>
          <td colspan="7" class="border-top-0 text-right font-weight-bold">TOTAL AMOUNT</td>
          <td>{{ $totalPayments ? "₦" . number_format($totalPayments, 2) : '' }}</td>
        </tr>
      </tbody>
    </table>

    <div class="row mt-5">
      <div class="col-md-6">
        <p><b>Note:</b><br> No appointment is confirmed, until payment is received.</p>
      </div>

      <div class="col-md-6">
        <button type="button" class="btn btn-preset mb-4 font-weight-bold">Payment Methods</button>
        <div class="alert alert-danger" role="alert" id="error_payment">
          Please select the payment method.
        </div>
        <div class="alert alert-danger" role="alert" id="error_payment">
          Please select the payment method.
        </div>
        <div class="custom-control custom-radio">
          <input type="radio" id="customRadio1" name="payment-channel" value="paystack" class="custom-control-input"
            required>
          <label class="custom-control-label font-weight-normal" for="customRadio1">Paystack (Debit/Credit Cards) International Payments</label>
          <div class="d-none">
            <form id="paystack" method="POST" action="{{ route('paystack.generate') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-12">
                  @csrf
                  <input type="hidden" name="email" value="{{ $appointment->email }}">
                  <input type="hidden" name="orderID" value="{{ $appointment->unique_id }}">
                  <input type="hidden" name="metadata" value="{{ json_encode($array = ['unique_id' => $appointment->unique_id]) }}">
                  <input type="hidden" name="amount" value="{{ $chargedAmount }}">
                  <input type="hidden" name="currency" value="NGN">
                  <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="custom-control custom-radio my-2" style="display:none">
          <input type="radio" id="customRadio2" name="payment-channel" value="quickteller"
            class="custom-control-input pt-4" required>
          <label class="custom-control-label font-weight-normal" for="customRadio2">Interswitch Webpay</label>
        </div>
        <div class="custom-control custom-radio my-2">
          <input type="radio" id="customRadio3" name="payment-channel" value="monnify" class="custom-control-input pt-4"
            required>
          <label class="custom-control-label font-weight-normal" for="customRadio3">Monnify WebPay</label>

          {{-- Monnify Submission --}}
          <form id="monnify" method="POST" action="{{ route('monnify.callback') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
            <div class="row">
              <div class="col-md-12">
                @csrf
                <input type="hidden" name="amount_paid">
                <input type="hidden" name="paid_on">
                <input type="hidden" name="payment_description">
                <input type="hidden" name="payment_status">
                <input type="hidden" name="payment_reference" required>
                <input type="hidden" name="authorized_amount" required>
                <input type="hidden" name="message" required>
                <input type="hidden" name="status" required>
                <input type="hidden" name="transaction_reference" required>
                <input type="hidden" name="unique_id" value="{{ $appointment->unique_id }}" required>
              </div>
            </div>
          </form>
        </div>
        <div class="custom-control custom-radio" style="display:none">
          <input type="radio" id="customRadio4" name="payment-channel" value="offline" class="custom-control-input"
            required>
          <label class="custom-control-label font-weight-normal" for="customRadio4">Bank Transfer (Offline)</label>
        </div>
      </div>
    </div>

    <div class="mt-4" style="clear: both;">
      <a href="{{ route("appointments.applicant-registration", ["unique_id"=> $appointment->unique_id]) }}">
        <button type="button" class="btn btn-form-sbmt btn-danger mt-3">Back</button>
      </a>
      <button id="pay" type="button" class="btn btn-primary float-right btn-form-sbmt mt-3">Pay</button>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://sdk.monnify.com/plugin/monnify.js"></script>
<script>
  $(document).ready(function () {
    function payWithMonnify() {
      MonnifySDK.initialize({
        amount: "{{ $totalPayments }}",
        currency: "NGN",
        reference: "{{ $appointment->unique_id }}",
        customerName: "John Doe",
        customerEmail: "{{ $appointment->email }}",
        apiKey: "MK_TEST_ECN8036UDF",
        contractCode: "5859128845",
        paymentDescription: "Test Pay",
        isTestMode: true,
        paymentMethods: ["CARD", "ACCOUNT_TRANSFER"],
        onComplete: function(response) {
          if (response) {
            if (response.status == "SUCCESS") {
              $("#monnify").find('input[name=amount_paid]').val(response.amountPaid);
              $("#monnify").find('input[name=authorized_amount]').val(response.authorizedAmount);
              $("#monnify").find('input[name=message]').val(response.message);
              $("#monnify").find('input[name=paid_on]').val(response.paidOn);
              $("#monnify").find('input[name=payment_description]').val(response.paymentDescription);
              $("#monnify").find('input[name=payment_reference]').val(response.paymentReference);
              $("#monnify").find('input[name=payment_status]').val(response.paymentStatus);
              $("#monnify").find('input[name=status]').val(response.status);
              $("#monnify").find('input[name=transaction_reference]').val(response.transactionReference);
              $("#monnify").submit();
            } else if (response.status == "FAILED") {
              $("#monnify").find('input[name=authorized_amount]').val(response.authorizedAmount);
              $("#monnify").find('input[name=message]').val(response.message);
              $("#monnify").find('input[name=payment_reference]').val(response.paymentReference);
              $("#monnify").find('input[name=status]').val(response.status);
              $("#monnify").find('input[name=transaction_reference]').val(response.transactionReference);
              $("#monnify").submit();
            } else {
              alert("Something wrong with the request, please try again");
            }
          }
        },
        onClose: function(data){
          //Implement what should happen when the modal is closed here
          console.log(data);
        }
      });
    }

    $("#pay").on('click', function () {
      let paymentOption = $("input[type='radio'][name='payment-channel']:checked").val();

      switch(paymentOption) {
        case 'paystack':
          // code block
          $("#paystack").submit();
          // form_paystack.submit();
          break;
        case 'quickteller':
          // code block
          alert('You are using ' + paymentOption);
          break;
          case 'monnify':
          // code block
          payWithMonnify();
          break;

          case 'offline':
          // code block
          alert('You are using ' + paymentOption);
          break;

        default:
          // code block
          $("#error_payment").show();
      }
    });
  });
</script>
@endsection

@section('css')
<style>
  #applicantsTable tr th {
    background-color: #050446 !important;
    color: white;
  }
  #error_payment {
    display: none;
  }
</style>
@endsection