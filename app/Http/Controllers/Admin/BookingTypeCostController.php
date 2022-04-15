<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingTypeCost as Entry;
use App\Models\BookingType as ParentEntry;
use DataTables;
use Auth;

class BookingTypeCostController extends Controller
{
  private $status = 'danger';
  private $statusCode = 400;
  private $message = null;
  private $data = null;
  private $parentModel = 'booking-types';
  private $model = 'booking-type-costs';
  private $title = 'Booking Type Cost';

  public function datatables()
  {
    return DataTables::of(Entry::query())->toJson();
  }

  public function index()
  {
    return view('admin.' . $this->model . '.index')
      ->with('model', $this->model)
      ->with('title', $this->title)
      ->with('state', 'List');
  }

  public function create($parentId)
  {
    $parentEntry = ParentEntry::findOrFail($parentId);

    return view('admin.' . $this->model . '.create-edit')
      ->with('model', $this->model)
      ->with('title', $this->title)
      ->with('parentEntry', $parentEntry)
      ->with('state', 'Create');
  }

  public function store($parentId, Request $request)
  {
    $parentEntry = ParentEntry::findOrFail($parentId);

    $request->validate([
      'age_week_start' => 'required|integer',
      'age_month_start' => 'required|integer',
      'age_year_start' => 'required|integer',
      'age_week_end' => 'required|integer',
      'age_month_end' => 'required|integer',
      'age_year_end' => 'required|integer',
      'basic_fee' => 'required',
      'immunization_fee' => 'required',
      'description' => 'required',
    ]);

    $entry = Entry::where('age_week_start', $request->age_week_start)
      ->where('age_month_start', $request->age_month_start)
      ->where('age_year_start', $request->age_year_start)
      ->where('age_week_end', $request->age_week_end)
      ->where('age_month_end', $request->age_month_end)
      ->where('age_year_end', $request->age_year_end)
      ->where('booking_type_id', $parentId)
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = new Entry();
      $entry->booking_type_id = $parentEntry->id;
      $entry->age_week_start = $request->age_week_start;
      $entry->age_month_start = $request->age_month_start;
      $entry->age_year_start = $request->age_year_start;
      $entry->age_week_end = $request->age_week_end;
      $entry->age_month_end = $request->age_month_end;
      $entry->age_year_end = $request->age_year_end;
      $entry->basic_fee = $request->basic_fee;
      $entry->immunization_fee = $request->immunization_fee;
      $entry->description = $request->description;
      $entry->user_id = Auth::user()->id;
      $insert = $entry->save();
      if ($insert) {
        return redirect()->route('admin.' . $this->parentModel . '.show', $parentEntry)->with('message', 'Data successfully created');
      } else {
        return redirect()->back()->withErrors(['msg' => 'Create data failed, please try again']);
      }
    }
  }

  public function show($id)
  {
    $entry = Entry::findOrFail($id);

    return view('admin.' . $this->model . '.show')
      ->with('entry', $entry)
      ->with('model', $this->model)
      ->with('title', $this->title)
      ->with('state', 'Detail');
  }

  public function edit($parentId, $id)
  {
    $parentEntry = ParentEntry::findOrFail($parentId);
    $entry = Entry::findOrFail($id);

    return view('admin.' . $this->model . '.create-edit')
      ->with('entry', $entry)
      ->with('model', $this->model)
      ->with('title', $this->title)
      ->with('parentEntry', $parentEntry)
      ->with('state', 'Edit');
  }

  public function update($parentId, $cost, Request $request)
  {
    $parentEntry = ParentEntry::findOrFail($parentId);
    $request->validate([
      'age_week_start' => 'required|integer',
      'age_month_start' => 'required|integer',
      'age_year_start' => 'required|integer',
      'age_week_end' => 'required|integer',
      'age_month_end' => 'required|integer',
      'age_year_end' => 'required|integer',
      'basic_fee' => 'required',
      'immunization_fee' => 'required',
      'description' => 'required',
    ]);

    $entry = Entry::where('id', '<>', $cost)
      ->where('age_week_start', $request->age_week_start)
      ->where('age_month_start', $request->age_month_start)
      ->where('age_year_start', $request->age_year_start)
      ->where('age_week_end', $request->age_week_end)
      ->where('age_month_end', $request->age_month_end)
      ->where('age_year_end', $request->age_year_end)
      ->where('booking_type_id', $parentId)
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = Entry::findOrFail($cost);
      $entry->age_week_start = $request->age_week_start;
      $entry->age_month_start = $request->age_month_start;
      $entry->age_year_start = $request->age_year_start;
      $entry->age_week_end = $request->age_week_end;
      $entry->age_month_end = $request->age_month_end;
      $entry->age_year_end = $request->age_year_end;
      $entry->basic_fee = $request->basic_fee;
      $entry->immunization_fee = $request->immunization_fee;
      $entry->description = $request->description;
      $entry->user_id = Auth::user()->id;
      $update = $entry->save();
      if ($update) {
        return redirect()->route('admin.' . $this->parentModel . '.show', $parentEntry)->with('message', 'Data successfully updated');
      } else {
        return redirect()->back()->withErrors(['msg' => 'Update data failed, please try again']);
      }
    }
  }

  public function destroy($parentId, $id)
  {
    $parentEntry = ParentEntry::findOrFail($parentId);

    $entry = Entry::where('booking_type_id', $parentId)
      ->where('id', $id)
      ->firstOrFail();

    if ($entry) {
      $delete = $entry->delete();
      if ($delete) {
        return redirect()->route('admin.' . $this->parentModel . '.show', $parentEntry)->with('message', 'Data successfully deleted');
      } else {
        return redirect()->back()->withErrors(['msg' => 'Delete data failed, please try again']);
      }
    } else {
      return redirect()->back()->withErrors(['msg' => 'Delete data failed, data not found']);
    }
  }
}
