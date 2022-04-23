<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\SearchException;

class Search {
    /**
     * $builder now will hold the query builder of passed model with all its scopes. 
     * eg: eloquent_search(Thread::query(), 'foo boo', ...) will hold Thread builder with all
     * its scopes to allowing us to return the results filtered
     */
    public static function search($builder, $search_query, $columns, $operators) {
        $keywords = array_filter(explode(' ', $search_query));

        if($search_query == "")
            return $builder;

        if(count($operators) != count($columns))
            throw new SearchException('number of operators should be the same as number of columns');

        /**
         * First search for the whole search_query
         */
        $builder = $builder->where(function($bld) use ($columns, $operators, $search_query) {
            for($i = 0; $i < count($columns); $i++) {
                if(strtolower($operators[$i])=='like') 
                    $search_query = "%$search_query%";
                
                $bld = $bld->orWhere($columns[$i], $operators[$i], $search_query);
            }
        });

        /**
         * If search query has multiple keywords, then we have to search for posts for every keyword; 
         * It means it is already processed by the previous check.
         */
        if(count($keywords) > 1) {
            $builder = $builder->orWhere(function($bld) use($columns, $operators, $keywords) {
                for($i=0; $i < count($columns); $i++) {
                    foreach($keywords as $keyword) {
                        if(strtolower($operators[$i]) == 'like')
                            $keyword = "%$keyword%";
                        $bld = $bld->orWhere($columns[$i], $operators[$i], $keyword);
                    }
                }
            });
        }

        return $builder;
        // return $builder->orderByRaw("CASE WHEN $priority_column LIKE ? then 1 else 0 end DESC", [$search_query]);
    }
}