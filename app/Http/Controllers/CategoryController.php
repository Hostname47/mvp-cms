<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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
        $category_hierarchy = [];
        $categories = [];
        $data = $request->validate(['category'=>'sometimes|exists:categories,slug']);
        if(isset($data['category'])) {
            $category = Category::where('slug', $data['category'])->first();
            if($category) {
                // category ancestors
                $temp = $category;
                while(!is_null($temp->parent_category_id)) {
                    array_unshift($category_hierarchy, $temp->ancestor);
                    $temp = $temp->ancestor;
                }
                array_push($category_hierarchy, $category);
            }
        }
        
        if(is_null($category))
            $categories = Category::whereNull('parent_category_id')->orderBy('priority', 'asc')->get();

        return view('admin.categories.manage')
            ->with(compact('categories'))
            ->with(compact('category'))
            ->with(compact('category_hierarchy'));
    }

    public function update(Request $request) {
        $category_id = $request->validate(['category_id'=>'required|exists:categories,id'])['category_id'];
        $data = $request->validate([
            'title'=>"sometimes|unique:categories,title,$category_id|min:2|max:600",
            'title_meta'=>"sometimes|unique:categories,title_meta,$category_id|min:2|max:600",
            'slug'=>"sometimes|min:2|unique:categories,slug,$category_id|max:1000",
            'description'=>'sometimes|min:2|max:4000',
            'priority'=>'sometimes|numeric',
            'parent_category_id'=>'sometimes|exists:categories,id',
        ]);

        if($category_id == $data['parent_category_id']) abort(422, 'A category could not be a parent to itself');

        $category = Category::find($category_id);
        $category->update($data);
        Session::flash('message', 'Category informations have been updated successfully.');

        return route('category.manage', ['category'=>$category->refresh()->slug]);
    }

    public function update_status(Request $request) {
        $data = $request->validate([
            'category_id'=>'required|exists:categories,id',
            'status'=>['sometimes', Rule::in(['awaiting review', 'hidden', 'live'])]
        ]);
        
        $category = Category::find($data['category_id']);
        // First update category status
        $category->update(['status'=>$data['status']]);
        // Then we fetch all its subcategories in all levels to update them as well
        $subcategories = DB::select("
            with recursive subcategories (id, parent_category_id) as (
                select id, parent_category_id
                from categories
                where parent_category_id = " . $category->id . "
                union all
                select c.id, c.parent_category_id
                from categories c
                inner join subcategories
                        on c.parent_category_id = subcategories.id
            )
            select * from subcategories;
        ");

        collect($subcategories)->each(function($subcategory) use ($data) {
            Category::find($subcategory->id)->update(['status'=>$data['status']]);
        });

        Session::flash('message', 'The category "'.$category->title.'" status has been updated successfully. (all its subcategories\' status are updated as well)');
    }

    public function set_as_root(Request $request) {
        $category_id = $request->validate(['category_id'=>'required|exists:categories,id'])['category_id'];
        $category = Category::find($category_id);
        $category->update(['parent_category_id'=>null]);
        Session::flash('message', '"'.$category->title.'" category is now a root category.');
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
