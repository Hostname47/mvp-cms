<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title'=>'Technology', 'title_meta'=>'Technology', 'slug'=>'technology', 'description'=>'tech description', 'priority'=>1, 'parent_category_id'=>null],
            ['title'=>'Sports', 'title_meta'=>'Sports', 'slug'=>'sports', 'description'=>'sports description', 'priority'=>2, 'parent_category_id'=>null],
            ['title'=>'Gaming', 'title_meta'=>'Gaming', 'slug'=>'gaming', 'description'=>'gaming description', 'priority'=>3, 'parent_category_id'=>null],
            ['title'=>'Fashion', 'title_meta'=>'Fashion', 'slug'=>'fashion', 'description'=>'fashion description', 'priority'=>4, 'parent_category_id'=>null],
            ['title'=>'Fitness', 'title_meta'=>'Fitness', 'slug'=>'fitness', 'description'=>'fitness description', 'priority'=>5, 'parent_category_id'=>null],
            ['title'=>'Pet', 'title_meta'=>'Pet', 'slug'=>'pet', 'description'=>'pet description', 'priority'=>6, 'parent_category_id'=>null],
            ['title'=>'Business', 'title_meta'=>'Business', 'slug'=>'business', 'description'=>'business description', 'priority'=>7, 'parent_category_id'=>null],
            ['title'=>'DIY', 'title_meta'=>'DIY', 'slug'=>'diy', 'description'=>'diy description', 'priority'=>8, 'parent_category_id'=>null],
            ['title'=>'Lifestyle', 'title_meta'=>'Lifestyle', 'slug'=>'lifestyle', 'description'=>'lifestyle description', 'priority'=>9, 'parent_category_id'=>null],
            ['title'=>'Music', 'title_meta'=>'Music', 'slug'=>'music', 'description'=>'music description', 'priority'=>10, 'parent_category_id'=>null],
            ['title'=>'Front-end development', 'title_meta'=>'Front-end development', 'slug'=>'front-end-development', 'description'=>'front-end description', 'priority'=>11, 'parent_category_id'=>1],
            ['title'=>'Back-end development', 'title_meta'=>'Back-end development', 'slug'=>'back-end-development', 'description'=>'back-end description', 'priority'=>12, 'parent_category_id'=>1],
        ];
        
        DB::table('categories')->insert($data); // Query Builder approach
    }
}
