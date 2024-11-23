<?php

namespace App\Http\Controllers;

use App\Models\RegionTask;
use App\Models\Response;
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

    public function taskOpen(Request $request, RegionTask $regionTask)
    {
        $regionTask->update(['status' => 2]);
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function response(Request $request, RegionTask $regionTask)
    {
        $request->validate([
            'note' => 'required|string',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,docx|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif'])) {
                $folder = 'images';
            } elseif (in_array($file->extension(), ['mp4', 'mov', 'avi'])) {
                $folder = 'videos';
            } else {
                $folder = 'files';
            }

            $file_name = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/' . $folder);

            $file->move($destinationPath, $file_name);

            $filePath = 'uploads/' . $folder . '/' . $file_name;
            $validated['file_url'] = $filePath;
        }

        $response = Response::create([
            'task_id' => $regionTask->tasks->id,
            'region_id' => $regionTask->regions->id,
            'title' => $regionTask->tasks->title,
            'file' => $filePath,
            'note' => $request->note,
            'status' => 3
        ]);

        $regionTask->update(['status' => 3]);

        return redirect()->route('myTask.page');
    }
}
