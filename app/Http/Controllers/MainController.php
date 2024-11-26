<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use App\Models\RegionTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        return view('main.main');
    }

    public function admin()
    {
        return view('admin.index');
    }

    public function report(Request $request)
    {
        $categories = Category::all();

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $reportData = [];

        foreach ($categories as $category) {
            $query = DB::table('region_tasks')
                ->select('status', DB::raw('COUNT(*) as count'))
                ->where('category_id', $category->id);

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $statusCounts = $query->groupBy('status')->get();

            $reportData[] = [
                'category' => $category->name,
                'statuses' => $statusCounts
            ];
        }

        return view('admin.report', [
            'reportData' => $reportData,
        ]);
    }


    public function control(Request $request)
    {
        $categories = Category::all();
        $regions = Region::all();
    
        $region_id = $request->query('region_id');
        $category_id = $request->query('category_id');
        $filter = $request->query('filter'); 
    
        $today = Carbon::today();
        $twoDaysLeft = $today->copy()->addDays(2);
        $oneDayLeft = $today->copy()->addDay(1);
    
        $query = RegionTask::query();
    
        if ($region_id) {
            $query->where('region_id', $region_id);
        }
    
        if ($category_id) {
            $query->where('category_id', $category_id);
        }
    
        switch ($filter) {
            case 'two_days_left':
                $query->whereDate('deadline', '=', $twoDaysLeft);
                break;
            case 'one_day_left':
                $query->whereDate('deadline', '=', $oneDayLeft);
                break;
            case 'overdue':
                $query->whereDate('deadline', '<', $today);
                break;
            case 'today':
                $query->whereDate('deadline', '=', $today);
                break;
            case 'all':
                break;
            default:
                break;
        }
    
        $tasks = $query->get();
    
        $data = [];
        foreach ($regions as $region) {
            foreach ($categories as $category) {
                $regionCategoryQuery = RegionTask::query();
    
                $regionCategoryQuery->where('region_id', $region->id)
                                    ->where('category_id', $category->id);
    
                switch ($filter) {
                    case 'two_days_left':
                        $regionCategoryQuery->whereDate('deadline', '=', $twoDaysLeft);
                        break;
                    case 'one_day_left':
                        $regionCategoryQuery->whereDate('deadline', '=', $oneDayLeft);
                        break;
                    case 'overdue':
                        $regionCategoryQuery->whereDate('deadline', '<', $today);
                        break;
                    case 'today':
                        $regionCategoryQuery->whereDate('deadline', '=', $today);
                        break;
                    case 'all':
                        break;
                    default:
                        break;
                }
    
                $data[$region->id][$category->id] = $regionCategoryQuery->count();
            }
        }
    
        $allCount = RegionTask::count();
        $twoDaysLeftCount = RegionTask::whereDate('deadline', '=', $twoDaysLeft)->count();
        $oneDayLeftCount = RegionTask::whereDate('deadline', '=', $oneDayLeft)->count();
        $overdueCount = RegionTask::whereDate('deadline', '<', $today)->count();
        $todayCount = RegionTask::whereDate('deadline', '=', $today)->count();
    
        return view('admin.control', [
            'categories' => $categories,
            'regions' => $regions,
            'tasks' => $tasks,  
            'data' => $data,
            'allCount' => $allCount,
            'twoDaysLeftCount' => $twoDaysLeftCount,
            'oneDayLeftCount' => $oneDayLeftCount,
            'overdueCount' => $overdueCount,
            'todayCount' => $todayCount,
        ]);
    }
    

    public function mainReport()
    {
        $categories = Category::all();
        $regions = Region::all();
    
        $data = [];
        
        foreach ($categories as $category) {
            $categoryTotal = RegionTask::where('category_id', $category->id)
                ->selectRaw('
                    SUM(status = 1) as sent,
                    SUM(status = 2) as opened,
                    SUM(status = 3) as answered,
                    SUM(status = 4) as approved,
                    SUM(status = 5) as rejected
                ')
                ->first();
    
            foreach ($regions as $region) {
                $statusCounts = RegionTask::where('category_id', $category->id)
                    ->where('region_id', $region->id)
                    ->selectRaw('
                        SUM(status = 1) as sent,
                        SUM(status = 2) as opened,
                        SUM(status = 3) as answered,
                        SUM(status = 4) as approved,
                        SUM(status = 5) as rejected
                    ')
                    ->first();
    
                $data[$category->name][$region->name] = [
                    'sent' => $statusCounts->sent ?? 0,
                    'opened' => $statusCounts->opened ?? 0,
                    'answered' => $statusCounts->answered ?? 0,
                    'approved' => $statusCounts->approved ?? 0,
                    'rejected' => $statusCounts->rejected ?? 0,
                ];
            }
    
            $data[$category->name]['total'] = [
                'sent' => $categoryTotal->sent ?? 0,
                'opened' => $categoryTotal->opened ?? 0,
                'answered' => $categoryTotal->answered ?? 0,
                'approved' => $categoryTotal->approved ?? 0,
                'rejected' => $categoryTotal->rejected ?? 0,
            ];
        }
    
        return view('admin.mainReport', compact('categories', 'regions', 'data'));
    }
    
}
