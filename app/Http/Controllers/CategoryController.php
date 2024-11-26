<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $models = Category::orderBy('id', 'ASC')->paginate(10);
        return view('admin.category', ['models' => $models]);
    }


    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        Category::create($data);
        
        return redirect()->route('category.page')->with('success', 'Category muvaffaqiyatli yaratildi');
    }

    public function update(Request $request, Category $category)
    {
    
        $data = $request->validated();
    
        $category->name = $request->input('name');

        $category->save();
    
        return redirect()->route('category.page')->with('success', 'Category updated successfully');
    }
    

    public function destroy(Category $category)
    {
        $category->delete(); 
        return redirect()->route('category.page')->with('success', 'Category muvaffaqiyatli o\'chirildi');
    }
}
