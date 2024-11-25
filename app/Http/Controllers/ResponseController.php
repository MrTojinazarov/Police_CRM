<?php

namespace App\Http\Controllers;

use App\Models\RegionTask;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function index()
    {
        $models = Response::orderBy('id', 'ASC')->paginate(10);
        return view('admin.response', ['models'=>$models]);
    }

    public function checkResponse(Request $request, Response $response)
{

    if ($request->action === 'approve') {
        $response->status = 4;

    } elseif ($request->action === 'reject') {
        $response->status = 5;
    }

    $response->note = $request->note;
    $response->save();

    RegionTask::where('region_id', $response->region_id)
    ->update(['status' => $response->status]);

    return redirect()->back()->with('success', 'Task status updated successfully.');
}

}
