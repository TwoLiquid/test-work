<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Support\Transformers\Api\V1\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @param User $user
     * @param UserRepository $userRepo
     * @return \Illuminate\Http\JsonResponse
     */
    public function users(
        Request $request,
        User $user,
        UserRepository $userRepo
    )
    {
        $params = $request->all();

        $users = $userRepo->getWithFilters(
            $user,
            $params
        );

        return $this->respondWithSuccess(
            $this->transformCollection($users, new UserTransformer)
        );
    }
}
