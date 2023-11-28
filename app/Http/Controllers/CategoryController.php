<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(
        public CategoryService $categoryService
    )
    {
    }

    public function createCategory()
    {
        $response = $this->categoryService->syncTicketTypesToCategories();

        return response()->json([
            'data' => $response
        ],201);
    }

    public function getCategories()
    {
        $response = $this->categoryService->getCategories();

        return response()->json([
            'data' => $response
        ],200);
    }
}
