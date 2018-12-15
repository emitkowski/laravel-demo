<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\UserRequest;
use App\Models\User;
use EllipseSynergie\ApiResponse\Contracts\Response;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\API\V1
 */
class UserController extends APIController
{
    /**
     * Resource Name
     *
     * @var string
     */
    protected $resource_name = 'User';

    /**
     * UserController constructor.
     *
     * @param User $model
     * @param Response $error_response
     */
    public function __construct(User $model, Response $error_response)
    {
        parent::__construct($model, $error_response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return mixed
     */
    public function store(UserRequest $request)
    {
        return parent::storeResource($request);
    }

    /**
     * Update the specified resource in storage
     *
     * @param UserRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UserRequest $request, $id)
    {
        return parent::updateResource($request, $id);
    }
}