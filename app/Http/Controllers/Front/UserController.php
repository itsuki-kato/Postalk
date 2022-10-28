<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Services\SampleService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * UserController constructor
     * @param UserRepository $userRepository
     * @param SampleService $sampleService
     */
    public function __construct(
        private UserRepository $userRepository,
        private SampleService $sampleService
    )
    {}

    public function login(Request $request)
    {
        $User = $this->userRepository->sample();
        $string = $this->sampleService->sample();

        // return $User->user_name;
        return $string;
    }
}
