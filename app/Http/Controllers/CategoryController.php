<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\View\Components\Admin\Category\Hierarchy\Selection\SelectOneCategory\{SelectOneCategoryViewer, SubcategoriesLevel};

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
        /**
         * Category status is under review by default - admin should add some blog posts and maintain it 
         * before publish it as live to public in manage categories page
         */
        Category::create($data);
        Session::flash('message', 'Category created successfully. <a class="no-underline blue bold" href="' . route('category.manage') . '">click here</a> to manage it in category management page');
    }

    public function manage(Request $request) {
        $category = null;
        $categories = [];
        $data = $request->validate(['category'=>'sometimes|exists:categories,slug']);
        if(isset($data['category']))
            $category = Category::where('slug', $data['category'])->first();
        else
            $categories = Category::whereNull('parent_category_id')->get();

        return view('admin.categories.manage')
            ->with(compact('categories'))
            ->with(compact('category'));
    }

    public function get_select_one_category_hierarchy() {
        $viewer = (new SelectOneCategoryViewer());
        $viewer = $viewer->render(get_object_vars($viewer))->render();
        return $viewer;
    }
    
    public function get_select_one_category_hierarchy_level(Request $request) {
        $cid = $request->validate(['category_id'=>'required|exists:categories,id'])['category_id'];
        $category = Category::find($cid);
        $subcategories = $category->subcategories;

        $level = (new SubcategoriesLevel($subcategories));
        $level = $level->render(get_object_vars($level))->render();
        return $level;
    }
}
