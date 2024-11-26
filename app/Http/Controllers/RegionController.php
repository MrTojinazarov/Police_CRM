<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionRequest;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $models = Region::orderBy('id', 'ASC')->paginate(10);
        
        $users = User::doesntHave('regions')->get();
    
        return view('admin.region', ['models' => $models, 'users' => $users]);
    }
    


    public function store(RegionRequest $request)
    {
        $data = $request->validated();

        Region::create($data);
        
        return redirect()->route('region.page')->with('success', 'Region muvaffaqiyatli yaratildi');
    }

    public function update(Request $request, Region $region)
    {
    
        $data = $request->validated();
    
        $region->name = $request->input('name');
        $region->user_id = $request->input('user_id');
        $region->save();
    
        return redirect()->route('region.page')->with('success', 'Region updated successfully');
    }
    

    public function destroy(Region $region)
    {
        $region->delete(); 
        return redirect()->route('region.page')->with('success', 'Region muvaffaqiyatli o\'chirildi');
    }
}
