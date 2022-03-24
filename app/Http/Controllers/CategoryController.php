<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\View\Components\Admin\Category\Viewers\CategoryParentSelection;
use App\View\Components\Admin\Category\SubcategoriesLevel;

class CategoryController extends Controller
{
    public function create(Request $request) {
        return view('admin.categories.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required|unique:categories|min:2|max:600',
            'title_meta'=>'required|unique:categories|min:2|max:600',
            'slug'=>'required|min:2|unique:categories|max:1000',
            'description'=>'required|min:2|max:4000',
            'parent_category_id'=>'sometimes|exists:categories,id'
        ]);

        Category::create($data);

        Session::flash('message', 'Category created successfully.');
    }

    public function get_category_parent_selection_viewer() {
        $viewer = (new CategoryParentSelection());
        $viewer = $viewer->render(get_object_vars($viewer))->render();
        return $viewer;
    }
    
    public function get_subcategories_level(Request $request) {
        $cid = $request->validate(['category_id'=>'required|exists:categories,id'])['category_id'];
        $category = Category::find($cid);
        $subcategories = $category->subcategories;

        $level = (new SubcategoriesLevel($subcategories));
        $level = $level->render(get_object_vars($level))->render();
        return $level;
    }
}
