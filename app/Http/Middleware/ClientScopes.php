<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\{Category,Post};
use App\Scopes\{ExcludePrivatePosts,OnlyLiveCategories,OnlyPublishedPosts};

class ClientScopes
{
    protected array $global_scopes = [
        Category::class => [
            OnlyLiveCategories::class,
        ],
        Post::class => [
            ExcludePrivatePosts::class,
            OnlyPublishedPosts::class
        ]
    ];

    public function handle(Request $request, Closure $next)
    {
        foreach ($this->global_scopes as $model => $scopes) {
            foreach ($scopes as $scope) {
                $model::addGlobalScope(new $scope);
            }
        }
        return $next($request);
    }
}
