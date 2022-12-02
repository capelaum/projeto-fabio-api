<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return new CategoryCollection(Category::all());
    }
}
