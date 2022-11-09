<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor
     * @param CategoryRepository $CategoryRepository
     */
    public function __construct(
        private CategoryRepository $categoryRepository,
    )
    {}


    /**
     * 初期画面表示
     *
     * @return void
     */
    public function index()
    {
        $category_list = $this->categoryRepository->get_category_list();

        return view('admin/category/index')->with('category_list', $category_list);
    }
}
