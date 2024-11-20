<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $models = Category::orderBy('id', 'ASC')->paginate(10);
        return view('admin.category', ['models' => $models]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($data);
        
        return redirect()->route('category.page')->with('success', 'User muvaffaqiyatli yaratildi');
    }

    public function update(Request $request, Category $category)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $category->name = $request->input('name');

        $category->save();
    
        return redirect()->route('category.page')->with('success', 'User updated successfully');
    }
    

    public function destroy(Category $category)
    {
        $category->delete(); 
        return redirect()->route('category.page')->with('success', 'User muvaffaqiyatli o\'chirildi');
    }
}
