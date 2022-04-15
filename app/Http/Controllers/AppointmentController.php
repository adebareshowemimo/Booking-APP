<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Applicant;
use App\Models\BookingType;
use App\Models\SiteInformation;
use App\Models\AppointmentDate;
use App\Models\AppointmentTime;
use App\Models\PaymentLog;
use App\Models\ApplicantBiodata;
use App\Mail\Appointment\Create as MailAppointmentCreate;
use App\Mail\Appointment\Checkout as MailAppointmentCheckout;
use App\Mail\Appointment\PaymentResponse as MailPaymentResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;
use Paystack;

class AppointmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function generateAppointment()
    {
        $uniqueID = Str::uuid()->toString();
        $appointment = Appointment::create([
            'unique_id' => $uniqueID
        ]);
        return redirect()->route('appointments.booking-type', ['unique_id' => $uniqueID]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function selectBookingType(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }

            if ($appointment->payment_status == 'success') {
                return redirect()->route('appointments.payment-response', ["unique_id" => $request->unique_id, "payment_status" => $appointment->payment_status]);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $bookingTypes = BookingType::get();

        return view('frontend.appointments.booking-type')
            ->with('appointment', $appointment)
            ->with('bookingTypes', $bookingTypes);
    }

    public function selectAppointmentDate(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }

            if ($appointment->payment_status == 'success') {
                return redirect()->route('appointments.payment-response', ["unique_id" => $request->unique_id, "payment_status" => $appointment->payment_status]);
            }

            if ($request->booking_type || $request->total_applicant) {
                if ($request->booking_type) {
                    $appointment->booking_type_id = $request->booking_type;
                }

                if ($request->total_applicants) {
                    $appointment->total_applicants = $request->total_applicants;
                }

                $appointment->save();
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        return view('frontend.appointments.appointment-date')
            ->with('appointment', $appointment);
    }

    public function saveAppointmentDate(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $validator = Validator::make($request->all(), [
            'booking_date_time' => 'required|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $this->message = $validator->errors()->first()]);
        } else {
            $appointment->booking_date_time = $request->booking_date_time;
            $appointment->save();

            return redirect()->route('appointments.applicant-registration', ["unique_id" => $request->unique_id, 'applicant_order' => 1]);
        }
    }

    public function applicantRegistration(Request $request)
    {
        $applicantOrder = $request->applicant_order ?? 1;
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $applicant = Applicant::where('appointment_id', $appointment->id)
            ->where('applicant_order', $applicantOrder)
            ->first();

        $appointment = Appointment::where('id', $appointment->id)
            ->first();

        $states = ["Abuja", "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nassarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara", "Others"];

        return view('frontend.appointments.applicant-registration')
            ->with('states', $states)
            ->with('appointment', $appointment)
            ->with('applicant', $applicant)
            ->with('applicantOrder', $applicantOrder);
    }

    public function storeApplicant(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $validator = Validator::make($request->all(), [
            'surname' => 'required|string',
            'first_name' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|string:Male,Female,Other',
            'email' => 'required_if:applicant_order,1|string|email',
            'primary_phone_number' => 'required_if:applicant_order,1|string',
            'state' => 'required_if:applicant_order,1|string',
            'city' => 'required_if:applicant_order,1|string',
            'applicant_order' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $this->message = $validator->errors()->first()]);
        } else {
            $applicant = Applicant::where('appointment_id', $appointment->id)
                ->where('applicant_order', $request->applicant_order)
                ->first();

            if (!$applicant) {
                $applicant = new Applicant();
            }

            $applicant->applicant_order = $request->applicant_order;
            $applicant->appointment_id = $appointment->id;
            $applicant->surname = $request->surname;
            $applicant->first_name = $request->first_name;
            $applicant->other_names = $request->other_names;
            $applicant->birth_date = $request->birth_date;
            $applicant->gender = $request->gender;
            $applicant->save();

            if (intval($request->applicant_order) === 1) {
                $appointment->email = $request->email;
                $appointment->primary_phone_number = $request->primary_phone_number;
                $appointment->secondary_phone_number = $request->secondary_phone_number;
                $appointment->state = $request->state;
                $appointment->city = $request->city;
                $appointment->save();

                $appointment->url = route('appointments.applicant-registration', ["unique_id" => $request->unique_id, "applicant_order" => intval($request->applicant_order) + 1]);

                // Mail::to($appointment->email)->send(new MailAppointmentCreate($appointment));
            }

            if ($request->is_editing) {
                return redirect()->route('appointments.applicant-list', ["unique_id" => $request->unique_id]);
            } else if ($appointment->total_applicants > intval($request->applicant_order)) {
                // Has next applicant
                return redirect()->route('appointments.applicant-registration', ["unique_id" => $request->unique_id, "applicant_order" => intval($request->applicant_order) + 1]);
            } else {
                // Complete for all, move the list page
                return redirect()->route('appointments.applicant-list', ["unique_id" => $request->unique_id]);
            }
        }
    }

    public function familyMemberRegistration(Request $request)
    {
        return view('frontend.appointments.family-member-registration');
    }

    public function applicantList(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::with('applicants')
                ->where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }

            if ($appointment->payment_status == 'success') {
                return redirect()->route('appointments.payment-response', ["unique_id" => $request->unique_id, "payment_status" => $appointment->payment_status]);
            }

            if (count($appointment->applicants) === 0) {
                return redirect()->back()->withErrors(['msg' => 'Applicants still empty']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        return view('frontend.appointments.applicant-list')
            ->with('appointment', $appointment);
    }

    public function checkout(Request $request)
    {
        $siteInformation = SiteInformation::query()->first();
        if (!$siteInformation) {
            return redirect()->route('home')->withErrors(['msg' => 'Site information is not set']);
        }

        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::with('applicants')
                ->where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }

            if ($appointment->payment_status == 'success') {
                return redirect()->route('appointments.payment-response', ["unique_id" => $request->unique_id, "payment_status" => $appointment->payment_status]);
            }

            if (count($appointment->applicants) === 0) {
                return redirect()->back()->withErrors(['msg' => 'Applicants still empty']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $subTotalPayments = 0;

        foreach ($appointment->applicants as $applicantKey => $applicant) {
            foreach ($appointment->booking_type->costs as $cost) {
                $applicantAgeInYear = $applicant->age->y;
                $applicantAgeInMonth = $applicant->age->m;
                $applicantAgeInWeek = round($applicant->age->d / 7);

                $age = "";
                if ($applicantAgeInYear > 0) {
                    $age = $applicantAgeInYear . " year(s)";
                } else if ($applicantAgeInMonth > 0) {
                    $age = $applicantAgeInMonth . " month(s)";
                } else {
                    $age = $applicantAgeInWeek . " week(s)";
                }

                $appointment->applicants[$applicantKey]->full_age = $age;

                $isCost = false;
                if ($applicantAgeInYear == $cost->age_year_start && $applicantAgeInYear == $cost->age_year_end) {
                    // If year equals, continue check month
                    if ($applicantAgeInMonth == $cost->age_month_start && $applicantAgeInMonth == $cost->age_month_end) {
                        // If month equals, continue check week
                        if ($applicantAgeInWeek >= $cost->age_month_start && $applicantAgeInMonth <= $cost->age_month_end) {
                            // If week more than start and less than end, directly set
                            $isCost = true;
                        }
                    } else if ($applicantAgeInMonth >= $cost->age_month_start && $applicantAgeInMonth <= $cost->age_month_end) {
                        // If month not equals, but in range, directly set
                        $isCost = true;
                    }
                } else if ($applicantAgeInYear >= $cost->age_year_start && $applicantAgeInYear <= $cost->age_year_end) {
                    // If year not equals, but in range, directly set
                    $isCost = true;
                }

                if ($isCost === true) {
                    $subTotalPayments += $cost->basic_fee + $cost->immunization_fee;
                    $appointment->applicants[$applicantKey]->basic_fee = $cost->basic_fee;
                    $appointment->applicants[$applicantKey]->immunization_fee = $cost->immunization_fee;
                    $appointment->applicants[$applicantKey]->booking_type_description = $cost->description;
                    $appointment->applicants[$applicantKey]->sub_total_payment = $subTotalPayments;
                    break;
                }
            }
        }

        $vat = ($subTotalPayments * 0) / 100;

        $totalPayments = $vat + $subTotalPayments;

        $chargedAmount = $totalPayments * 100;

        return view('frontend.appointments.checkout')
            ->with('appointment', $appointment)
            ->with('siteInformation', $siteInformation)
            ->with('subTotalPayments', $subTotalPayments)
            ->with('totalPayments', $totalPayments)
            ->with('vat', $vat)
            ->with('chargedAmount', $chargedAmount);
    }

    public function getDate(Request $request)
    {
        $data = AppointmentDate::whereBetween('date', [$request->start, $request->end])
            ->where('date', '>=', Carbon::now()->addDays(5)->toDateTimeString())
            ->where('status', 1)
            ->whereHas('times', function($query) {
                $query->where('status', 1);
            })
            ->with('times', function($query) {
                $query->where('status', 1);
            })
            ->withCount(['times as total_slot' => function($query) {
                $query->select(DB::raw('SUM(slot)'));
            }])
            ->get();

        foreach ($data as $key => $date) {
            // Get occupied times
            $occupiedTime = 0;
            foreach ($date->times as $timeKey => $time) {
                $occupiedTime += Appointment::where('booking_date_time', $date->date . " " . $time->time)
                    ->count('total_applicants');
            }

            $data[$key]->occupied = $occupiedTime;
            $data[$key]->display = 'background';
            $availableSlot = $data[$key]->total_slot - $occupiedTime;
            $data[$key]->title = $availableSlot . ' slot';

            if ($availableSlot <= 5) {
                $data[$key]->backgroundColor = 'red';
            } else {
                $data[$key]->backgroundColor = 'green';
            }
        }

        return response()->json($data);
    }

    public function getSlot(Request $request)
    {
        $status = 'failed';
        $data = [];
        $message = 'No slots found';

        if ($request->date) {
            $data = AppointmentTime::whereHas('date', function($query) use ($request) {
                $query->where('date', $request->date);
            })
                ->with('date')
                ->get();


            foreach ($data as $key => $time) {
                $data[$key]->available_slot = $time->slot;
                $occupiedTime = Appointment::where('booking_date_time', $time->date->date . " " . $time->time)
                    ->count('total_applicants') ?? 0;

                $data[$key]->occupied = $occupiedTime;
                $data[$key]->available_slot -= $occupiedTime;
            }

            $status = 'success';
            $message = 'Slots retrieved';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function paystackGenerate(Request $request)
    {
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function paystackCallback(Request $request)
    {
        try {
            $paymentDetails = Paystack::getPaymentData();
            $response = $paymentDetails['data'];
            $uniqueID = $response['metadata']['unique_id'];

            $appointment = null;
            if ($uniqueID) {
                $appointment = Appointment::where('unique_id', $uniqueID)
                    ->first();

                if (!$appointment) {
                    return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
                }
            } else {
                return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
            }

            $validator = Validator::make($response, [
                'amount' => 'required',
                'status' => 'required',
                'reference' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors(['msg' => $this->message = $validator->errors()->first()]);
            } else {
                $paymentLog = new PaymentLog();
                $status = strtolower($response['status']);
                $paymentLog->appointment_id = $appointment->id;
                $paymentLog->payment_gateway = "Paystack";
                $paymentLog->status = $status;
                $paymentLog->amount = $response['amount'];
                $paymentLog->transaction_reference = $response['reference'];

                $appointment->payment_gateway = "Paystack";
                $appointment->payment_status = $status;
                $appointment->payment_amount = $response['amount'];
                $appointment->payment_date = Carbon::now();
                $appointment->save();

                if ($status == "success") {
                    $paymentLog->payload = json_encode($response);
                }

                Mail::to($appointment->email)->send(new MailPaymentResponse($appointment));

                $save = $paymentLog->save();
                if ($save) {
                    return redirect()->route('appointments.payment-response', ["unique_id" => $uniqueID, "payment_status" => $status]);
                } else {
                    return redirect()->back()->withErrors(['msg' => "Fail to store payment log, please try again"]);
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('home')->withErrors(['msg' => $th->getMessage()]);
        }
    }

    public function monnifyCallback(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $validator = Validator::make($request->all(), [
            'authorized_amount' => 'required',
            'message' => 'required',
            'status' => 'required',
            'transaction_reference' => 'required',
            'payment_reference' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $this->message = $validator->errors()->first()]);
        } else {
            $paymentLog = new PaymentLog();
            $status = strtolower($request->status);
            $paymentLog->appointment_id = $appointment->id;
            $paymentLog->payment_gateway = "Monnify";
            $paymentLog->status = $status;
            $paymentLog->amount = $request->authorized_amount;
            $paymentLog->transaction_reference = $request->transaction_reference;
            $paymentLog->payment_reference = $request->payment_reference;

            $appointment->payment_gateway = "Monnify";
            $appointment->payment_status = $status;
            $appointment->payment_amount = $request->authorized_amount;
            $appointment->payment_date = Carbon::now();
            $appointment->save();

            if ($status == "success") {
                $paymentLog->payload = json_encode([
                    'amount_paid' => $request->amount_paid,
                    'paid_on' => $request->paid_on,
                    'payment_description' => $request->payment_description,
                    'payment_status' => $request->payment_status
                ]);
            }

            $save = $paymentLog->save();

            Mail::to($appointment->email)->send(new MailPaymentResponse($appointment));

            if ($save) {
                return redirect()->route('appointments.payment-response', ["unique_id" => $request->unique_id, 'payment_status' => $status]);
            } else {
                return redirect()->back()->withErrors(['msg' => "Fail to store payment log, please try again"]);
            }
        }
    }

    public function paymentResponse(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::with('applicants')
                ->where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }

            if (count($appointment->applicants) === 0) {
                return redirect()->back()->withErrors(['msg' => 'Applicants still empty']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        return view('frontend.appointments.payment-response')
            ->with('payment_status', $request->payment_status)
            ->with('appointment', $appointment);
    }

    public function appointmentSuccessful(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::with('applicants')
                ->where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }

            if (count($appointment->applicants) === 0) {
                return redirect()->back()->withErrors(['msg' => 'Applicants still empty']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        return view('frontend.appointments.appointment-successful')
            ->with('appointment', $appointment);
    }

    public function applicantBiodata(Request $request)
    {
        $applicantOrder = $request->applicant_order ?? 1;
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $applicant = Applicant::with('biodata')
            ->where('appointment_id', $appointment->id)
            ->where('applicant_order', $applicantOrder)
            ->first();

        $appointment = Appointment::where('id', $appointment->id)
            ->first();

        $states = ["Abuja", "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nassarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara", "Others"];

        return view('frontend.appointments.applicant-biodata')
            ->with('states', $states)
            ->with('appointment', $appointment)
            ->with('applicant', $applicant)
            ->with('applicantOrder', $applicantOrder);
    }

    public function storeApplicantBiodata(Request $request)
    {
        $appointment = null;
        if ($request->unique_id) {
            $appointment = Appointment::where('unique_id', $request->unique_id)
                ->first();

            if (!$appointment) {
                return redirect()->route('home')->withErrors(['msg' => 'Invalid unique ID']);
            }
        } else {
            return redirect()->route('home')->withErrors(['msg' => 'Unique ID unset, please retry']);
        }

        $validator = Validator::make($request->all(), [
            'same_as_primary' => 'required',
            'surname' => 'required|string',
            'first_name' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|string:Male,Female,Other',
            'email' => 'nullable|required_if:same_as_primary,0|string|email',
            'primary_phone_number' => 'nullable|required_if:same_as_primary,0|string',
            'state' => 'nullable|required_if:same_as_primary,0|string',
            'city' => 'nullable|required_if:same_as_primary,0|string',
            'passport_number' => 'required|string',
            'passport_expiration_date' => 'required|date',
            'home_address_nigeria' => 'required|string',
            'home_address' => 'required|string',
            'us_intended_address' => 'required|string',
            'case_number' => 'required|string',
            'applicant_order' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $this->message = $validator->errors()->first()]);
        } else {
            $applicant = Applicant::where('appointment_id', $appointment->id)
                ->where('applicant_order', $request->applicant_order)
                ->first();

            $biodata = ApplicantBiodata::where('applicant_id', $applicant->id)
                ->first();

            if (!$biodata) {
                $biodata = new ApplicantBiodata();
            }

            if (intval($request->same_as_primary) === 1) {
                $biodata->email = $appointment->email;
                $biodata->primary_phone_number = $appointment->primary_phone_number;
                $biodata->secondary_phone_number = $appointment->secondary_phone_number;
                $biodata->state = $appointment->state;
                $biodata->city = $appointment->city;
                $biodata->same_as_primary = 1;
            } else {
                $biodata->email = $request->email;
                $biodata->primary_phone_number = $request->primary_phone_number;
                $biodata->secondary_phone_number = $request->secondary_phone_number;
                $biodata->state = $request->state;
                $biodata->city = $request->city;
            }

            $applicant->surname = $request->surname;
            $applicant->first_name = $request->first_name;
            $applicant->other_names = $request->other_names;
            $applicant->birth_date = $request->birth_date;
            $applicant->gender = $request->gender;
            $applicant->save();

            $biodata->applicant_id = $applicant->id;
            $biodata->passport_number = $request->passport_number;
            $biodata->passport_expiration_date = $request->passport_expiration_date;
            $biodata->home_address_nigeria = $request->home_address_nigeria;
            $biodata->us_intended_address = $request->us_intended_address;
            $biodata->home_address = $request->home_address;
            $biodata->case_number = $request->case_number;
            $biodata->save();

            if ($appointment->total_applicants > intval($request->applicant_order)) {
                // Has next applicant
                return redirect()->route('appointments.applicant-biodata', ["unique_id" => $request->unique_id, "applicant_order" => intval($request->applicant_order) + 1]);
            } else {
                // Complete for all, move the appointment successful page
                return redirect()->route('appointments.appointment-successful', ["unique_id" => $request->unique_id]);
            }
        }
    }
}
