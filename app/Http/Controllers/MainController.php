<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use App\Models\RegionTask;
use Illuminate\Database\Eloquent\Model;
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
    
    public function control()
    {
        $categories = Category::all(); // Barcha kategoriyalarni olish
        $regions = Region::all(); // Barcha regionlarni olish
    
        $data = []; // Natijani saqlash uchun massiv
    
        foreach ($regions as $region) {
            foreach ($categories as $category) {
                $taskCount = DB::table('region_tasks')
                    ->where('region_id', $region->id)
                    ->where('category_id', $category->id)
                    ->count(); // Region va kategoriya bo'yicha tasklarni sanash
    
                $data[$region->id][$category->id] = $taskCount;
            }
        }
    
        return view('admin.control', [
            'categories' => $categories,
            'regions' => $regions,
            'data' => $data, // Hisoblangan natijalarni view'ga yuborish
        ]);
    }
    
}
