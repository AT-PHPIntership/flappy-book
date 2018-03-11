<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Model\User;
use League\Fractal\Manager;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    /**
     * UserController construct
     *
     * @param Manager         $fractal     fractal
     * @param UserTransformer $transformer transformer
     *
     * @return void
     */
    public function __construct(Manager $fractal, UserTransformer $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    /**
     * API get info user
     *
     * @param int $id id of user
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user = $this->transformerResource($user, ['book_borrowing', 'borrowed', 'donated']);
        return $this->responseSuccess($user);
    }
}
