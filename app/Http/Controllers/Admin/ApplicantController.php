<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant as Entry;
use DataTables;
use Auth;

class ApplicantController extends Controller
{
  private $status = 'danger';
  private $statusCode = 400;
  private $message = null;
  private $data = null;
  private $model = 'applicants';
  private $title = 'Applicant';

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
      'name' => 'required',
    ]);

    $entry = Entry::whereName($request->name)
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = new Entry();
      $entry->name = $request->name;
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
      'name' => 'required',
    ]);

    $entry = Entry::where('id', '<>', $id)
      ->where(function($query) use ($request) {
        $query->where('name', $request->name);
      })
      ->first();

    if ($entry) {
      return redirect()->back()->withErrors(['msg' => 'Duplicate data found']);
    } else {
      $entry = Entry::findOrFail($id);
      $entry->name = $request->name;
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
