<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    public function report()
    {
        $categories = Category::all();
    
        $reportData = [];
    
        foreach ($categories as $category) {
            $statusCounts = DB::table('region_tasks')
                ->select('status', DB::raw('COUNT(*) as count'))
                ->where('category_id', $category->id)
                ->groupBy('status')
                ->get();
    
            $reportData[] = [
                'category' => $category->name,
                'statuses' => $statusCounts
            ];
        }
    
        return view('admin.report', [
            'reportData' => $reportData
        ]);
    }
    
}
