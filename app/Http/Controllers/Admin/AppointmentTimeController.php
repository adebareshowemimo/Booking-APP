<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentTime as Entry;
use App\Models\AppointmentDate as ParentEntry;
use DataTables;
use Auth;

class AppointmentTimeController extends Controller
{
  private $status = 'danger';
  private $statusCode = 400;
  private $message = null;
  private $data = null;
  private $model = 'appointment-times';
  private $title = 'Appointment Time';
  private $parentModel = 'appointment-dates';

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
      'time' => 'required',
      'slot' => 'required',
      'status' => 'required',
    ]);

    $entry = Entry::where('time', $request->time)
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = new Entry();
      $entry->appointment_date_id = $parentEntry->id;
      $entry->time = $request->time;
      $entry->slot = $request->slot;
      $entry->status = $request->status;
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

  public function update(Request $request, $parentId, $id)
  {
    $parentEntry = ParentEntry::findOrFail($parentId);

    $request->validate([
      'time' => 'required',
      'slot' => 'required',
      'status' => 'required',
    ]);

    $entry = Entry::where('id', '<>', $id)
      ->where(function($query) use ($request) {
        $query->where('time', $request->time);
      })
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = Entry::findOrFail($id);
      $entry->time = $request->time;
      $entry->slot = $request->slot;
      $entry->status = $request->status;
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
    $entry = Entry::findOrFail($id);

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
