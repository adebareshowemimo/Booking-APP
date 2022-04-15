<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentDate as Entry;
use DataTables;
use Auth;

class AppointmentDateController extends Controller
{
  private $status = 'danger';
  private $statusCode = 400;
  private $message = null;
  private $data = null;
  private $model = 'appointment-dates';
  private $title = 'Appointment Date';

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

  public function create()
  {
    return view('admin.' . $this->model . '.create-edit')
      ->with('model', $this->model)
      ->with('title', $this->title)
      ->with('state', 'Create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'date' => 'required',
      'status' => 'required',
    ]);

    $entry = Entry::where('date', $request->date)
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = new Entry();
      $entry->date = $request->date;
      $entry->status = $request->status;
      $entry->user_id = Auth::user()->id;
      $insert = $entry->save();
      if ($insert) {
        return redirect()->route('admin.' . $this->model . '.index')->with('message', 'Data successfully created');
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

  public function edit($id)
  {
    $entry = Entry::findOrFail($id);

    return view('admin.' . $this->model . '.create-edit')
      ->with('entry', $entry)
      ->with('model', $this->model)
      ->with('title', $this->title)
      ->with('state', 'Edit');
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'date' => 'required',
      'status' => 'required',
    ]);

    $entry = Entry::where('id', '<>', $id)
      ->where(function($query) use ($request) {
        $query->where('date', $request->date);
      })
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = Entry::findOrFail($id);
      $entry->date = $request->date;
      $entry->status = $request->status;
      $entry->user_id = Auth::user()->id;
      $update = $entry->save();
      if ($update) {
        return redirect()->route('admin.' . $this->model . '.index')->with('message', 'Data successfully updated');
      } else {
        return redirect()->back()->withErrors(['msg' => 'Update data failed, please try again']);
      }
    }
  }

  public function destroy($id)
  {
    $entry = Entry::findOrFail($id);

    if ($entry) {
      $delete = $entry->delete();
      if ($delete) {
        return redirect()->route('admin.' . $this->model . '.index')->with('message', 'Data successfully deleted');
      } else {
        return redirect()->back()->withErrors(['msg' => 'Delete data failed, please try again']);
      }
    } else {
      return redirect()->back()->withErrors(['msg' => 'Delete data failed, data not found']);
    }
  }
}
