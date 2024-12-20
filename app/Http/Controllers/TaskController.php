<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
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
        
        $regionTask_id = $request->query('regionTask_id');
        $query = RegionTask::query();
    
        if (isset($regionTask_id)) {
            $query->where('id', $regionTask_id);
        }
    
        if ($start_date && $end_date) {
            $query->whereBetween('deadline', [$start_date, $end_date]);
        } else {
            switch ($filter) {
                case 'two_days_left':
                    $query->whereDate('deadline', '=', $today->copy()->addDays(2));
                    break;
    
                case 'one_day_left':
                    $query->whereDate('deadline', '=', $today->copy()->addDay(1));
                    break;
    
                case 'today':
                    $query->whereDate('deadline', '=', $today);
                    break;
    
                case 'overdue':
                    $query->whereDate('deadline', '<', $today)
                          ->whereNotIn('status', [3, 4]);
                    break;
    
                default:
                    break;
            }
        }
    
        $models = $query->orderBy('id', 'ASC')->paginate(10);
    
        $allCount = RegionTask::count();
        $twoDaysLeftCount = RegionTask::whereDate('deadline', $today->copy()->addDays(2))->count();
        $oneDayLeftCount = RegionTask::whereDate('deadline', $today->copy()->addDay(1))->count();
        $overdueCount = RegionTask::whereDate('deadline', '<', $today)
                                  ->whereNotIn('status', [3, 4])
                                  ->count();
        $rejectedCount = RegionTask::where('status', 5)->count();
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
    

    public function store(TaskRequest $request)
    {
        $data = $request->validated();

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

    public function update(TaskRequest $request, RegionTask $regionTask)
    {
        $data = $request->validated();

        $filePath = $regionTask->tasks->file;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
    
            $folder = match (true) {
                in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif']) => 'images',
                in_array($file->extension(), ['mp4', 'mov', 'avi']) => 'videos',
                default => 'files',
            };
    
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . $folder);
            $file->move($destinationPath, $fileName);
    
            $filePath = 'uploads/' . $folder . '/' . $fileName;
        }
    
        $regionTask->tasks->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'performer' => $request->performer,
            'file' => $filePath,
        ]);
    
        $regionTask->update([
            'region_id' => $request->region_id,
            'deadline' => $request->deadline,
        ]);
    
        return redirect()->route('task.page')->with('success', 'Task updated successfully!');
    }
    
    public function destroy(RegionTask $regionTask)
    {
        $regionTask->delete();
        return redirect()->route('task.page')->with('success', 'Task muvaffaqiyatli o\'chirildi');
    }
}
