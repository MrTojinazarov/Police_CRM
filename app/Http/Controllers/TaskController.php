<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use App\Models\RegionTask;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $models = Task::orderBy('id', 'ASC')->paginate(10);
        $categories = Category::all();
        $regions = Region::all();
        $regionTasks = RegionTask::all();

        return view('admin.task', ['models' => $models, 'categories' => $categories, 'regions' => $regions, 'regiontasks' => $regionTasks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'performer' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,docx|max:20480',
            'deadline' => 'required|date',
            'region_id' => 'required',
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
        
            $file_name = time().'-'.uniqid().'.' . $file->getClientOriginalExtension();
        
            $destinationPath = public_path('uploads/' . $folder);

            $file->move($destinationPath, $file_name);
        
            $filePath = 'uploads/' . $folder . '/' . $file_name;
            $validated['file_url'] = $filePath;
        } 

        $task = Task::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'performer' => $request->performer,
            'file' => $filePath,
            'deadline' => $request->deadline,
        ]);
        $task->regiontasks()->attach($request->region_id);

        return redirect()->back()->with('success', 'Task successfully created!');
    }


    public function update(Request $request, Task $task)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255', 
            'description' => 'required|string|max:1000', 
            'performer' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,docx|max:20480',
            'region_id' => 'required|array', 
            'region_id.*' => 'exists:regions,id',
        ]);

        $filePath = $task->file;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            if (in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif'])) {
                $folder = 'images';
            } elseif (in_array($file->extension(), ['mp4', 'mov', 'avi'])) {
                $folder = 'videos';
            } else {
                $folder = 'files';
            }
    
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $destinationPath = public_path('uploads/' . $folder);
            $file->move($destinationPath, $fileName);
    
            $filePath = 'uploads/' . $folder . '/' . $fileName;
        }
    
        $task->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'performer' => $request->performer,
            'file' => $filePath, 
            'deadline' => $request->deadline,
        ]);
    
        $task->regions()->sync($request->region_id);
    
        return redirect()->route('task.page')->with('success', 'Task updated successfully!');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.page')->with('success', 'Task muvaffaqiyatli o\'chirildi');
    }
}
