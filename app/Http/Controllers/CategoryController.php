<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\View\Components\Admin\Category\Hierarchy\Selection\SelectOneCategory\{SelectOneCategoryViewer, SubcategoriesLevel};
use App\View\Components\Admin\Category\Hierarchy\ClickSelection\{SubcategoriesLevel as ClickableSubcategoriesLevel};

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
            $categories = Category::whereNull('parent_category_id')->orderBy('priority', 'asc')->get();

        return view('admin.categories.manage')
            ->with(compact('categories'))
            ->with(compact('category'));
    }

    public function update_categories_priorities(Request $request) {
        $data = $request->validate([
            'categories_ids'=>'required',
            'categories_ids.*'=>'exists:categories,id',
            'categories_priorities'=>'required',
            'categories_priorities.*'=>'numeric',
        ]);

        $i = 0;
        foreach($data['categories_ids'] as $cid) {
            Category::find($cid)->update(['priority'=>$data['categories_priorities'][$i]]);
            $i++;
        }

        Session::flash('message', 'Categories priorities have been updated successfully.');
    }

    public function get_select_one_category_viewer(Request $request) {
        $viewer = (new SelectOneCategoryViewer());
        $viewer = $viewer->render(get_object_vars($viewer))->render();
        return $viewer;
    }
    
    public function get_one_level_hierarchy_subcategories(Request $request) {
        $data = $request->validate([
            'category_id'=>'required|exists:categories,id',
            'type'=>['required', Rule::in(['select-one', 'select-many', 'select-by-click'])]
        ]);
        $category = Category::find($data['category_id']);
        $subcategories = $category->subcategories;

        switch($data['type']) {
            case 'select-one':
                $level = (new SubcategoriesLevel($subcategories));
                $level = $level->render(get_object_vars($level))->render();
                return $level;
            case 'select-many':
                break;
            case 'select-by-click':
                $level = (new ClickableSubcategoriesLevel($subcategories));
                $level = $level->render(get_object_vars($level))->render();
                return $level;
        }
    }
}
