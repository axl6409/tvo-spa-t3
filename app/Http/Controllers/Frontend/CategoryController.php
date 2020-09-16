<?php

namespace App\Http\Controllers\FrontEnd;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all() {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function get($id) {
        $category = Category::findOrFail($id);
        return response()->json($category, 200);
    }
}
