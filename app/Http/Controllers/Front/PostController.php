<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    /**
     * PostController constructor
     * @param PostRepository
     */
    public function __construct(
        private PostRepository $postRepository
    )
    {}

    public function index(Request $request)
    {
        
        return [];
    }

    public function create(Request $request)
    {
        $form_data = $request->all();

        return [];
    }
}
