<?php

namespace App\Http\Controllers;

use App\Models\RegionTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    public function index()
    {

        $models = RegionTask::whereHas('regions', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['regions', 'tasks'])->get();

        return view('main.myTask', ['models' => $models]);
    }

    public function updateStatus(Request $request, RegionTask $regionTask)
    {
        $currentStatus = $request->status;

        if ($currentStatus == 1) {
            $regionTask->update(['status' => 2]);
        } elseif ($currentStatus == 2) {
            $regionTask->update(['status' => 3]);
        }
    
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    
}
