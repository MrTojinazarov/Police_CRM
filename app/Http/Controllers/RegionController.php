<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $models = Region::orderBy('id', 'ASC')->paginate(10);
        $users = User::all();
        return view('admin.region', ['models' => $models, 'users' => $users]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        Region::create($data);
        
        return redirect()->route('region.page')->with('success', 'Region muvaffaqiyatli yaratildi');
    }

    public function update(Request $request, Region $region)
    {
    
        $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
        ]);
    
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
