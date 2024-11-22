<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use App\Models\RegionTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $today = Carbon::today();
        $filter = $request->query('filter', 'all');

        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $categories = Category::all();
        $regions = Region::all();
        $regiontasks = RegionTask::all();

        if ($start_date && $end_date) {
            $models = Task::whereHas('regiontasks', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('deadline', [$start_date, $end_date]);
            })->paginate(10);
        } else {
            switch ($filter) {
                case 'two_days_left':
                    $models = Task::whereHas('regiontasks', function ($query) use ($today) {
                        $query->whereDate('deadline', '=', $today->copy()->addDay(2));
                    })->paginate(10);
                    break;

                case 'one_day_left':
                    $models = Task::whereHas('regiontasks', function ($query) use ($today) {
                        $query->whereDate('deadline', '=', $today->copy()->addDay(1));
                    })->paginate(10);
                    break;

                case 'overdue':
                    $models = Task::whereHas('regiontasks', function ($query) use ($today) {
                        $query->whereDate('deadline', '<', $today);
                    })->paginate(10);
                    break;

                case 'rejected':
                    $models = Task::whereHas('regiontasks', function ($query) {
                        $query->where('status', 'rejected');
                    })->paginate(10);
                    break;

                case 'today':
                    $models = Task::whereHas('regiontasks', function ($query) use ($today) {
                        $query->whereDate('deadline', '=', $today);
                    })->paginate(10);
                    break;

                default:
                    $models = Task::whereHas('regiontasks', function ($query) {
                    })->orderBy('id', 'ASC')->paginate(10);
                    break;
            }
        }


        $allCount = RegionTask::all()->count();
        $twoDaysLeftCount = RegionTask::whereDate('deadline', $today->copy()->addDays(2))->count();
        $oneDayLeftCount = RegionTask::whereDate('deadline', $today->copy()->addDay(1))->count();
        $overdueCount = RegionTask::whereDate('deadline', '<', $today)->count();
        $rejectedCount = RegionTask::where('status', 'rejected')->count();
        $todayCount = RegionTask::whereDate('deadline', $today)->count();

        return view('admin.task', [
            'models' => $models,
            'allCount' => $allCount,
            'twoDaysLeftCount' => $twoDaysLeftCount,
            'oneDayLeftCount' => $oneDayLeftCount,
            'overdueCount' => $overdueCount,
            'rejectedCount' => $rejectedCount,
            'todayCount' => $todayCount,
            'categories' => $categories,
            'areas' => $regions,
            'regiontasks' => $regiontasks,
        ]);
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
            'region_ids' => 'required|array|exists:regions,id',
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
        $task = Task::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'performer' => $request->performer,
            'file' => $filePath,
            'deadline' => $request->deadline,
        ]);

        $regionTasks = collect($request->region_ids)->map(function ($region_id) use ($request, $task) {
            return [
                'region_id' => $region_id,
                'task_id' => $task->id,
                'category_id' => $request->category_id,
                'deadline' => $request->deadline,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        RegionTask::insert($regionTasks->toArray());

        return redirect()->back()->with('success', 'Task successfully created!');
    }


    public function update(Request $request, Task $task)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'performer' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,docx|max:20480',
            'deadline' => 'required|date',
            'region_ids' => 'required|array',
            'region_ids.*' => 'exists:regions,id',
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
        ]);

        $regionTasks = collect($request->region_ids)->map(function ($region_id) use ($request, $task) {
            return [
                'region_id' => $region_id,
                'task_id' => $task->id,
                'category_id' => $request->category_id,
                'deadline' => $request->deadline,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        RegionTask::where('task_id', $task->id)->delete();

        RegionTask::insert($regionTasks->toArray());

        return redirect()->route('task.page')->with('success', 'Task updated successfully!');
    }

    public function destroy(RegionTask $task)
    {
        $task->delete();
        return redirect()->route('task.page')->with('success', 'Task muvaffaqiyatli o\'chirildi');
    }
}
