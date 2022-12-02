<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryCollection;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @return CategoryCollection
     */
    public function index(): CategoryCollection
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
