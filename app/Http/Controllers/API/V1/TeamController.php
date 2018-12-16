<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use EllipseSynergie\ApiResponse\Contracts\Response;

/**
 * Class TeamController
 *
 * @package App\Http\Controllers\API\V1
 */
class TeamController extends APIController
{
    /**
     * Resource Name
     *
     * @var string
     */
    protected $resource_name = 'Team';

    /**
     * TeamController constructor.
     *
     * @param Team $model
     * @param Response $error_response
     */
    public function __construct(Team $model, Response $error_response)
    {
        parent::__construct($model, $error_response);
    }

    /**
     * Display a listing of all the resource.
     *
     */
    public function index()
    {
        return $this->resourceCollection($this->model->with('players')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamRequest $request
     * @return mixed
     */
    public function store(TeamRequest $request)
    {
        return parent::storeResource($request);
    }

    /**
     * Update the specified resource in storage
     *
     * @param TeamRequest $request
     * @param $id
     * @return mixed
     */
    public function update(TeamRequest $request, $id)
    {
        return parent::updateResource($request, $id);
    }

    /**
     *  Delete resource.
     *
     * @param  int $id
     * @return array
     */
    public function destroy($id)
    {
        $item = $this->findRow($id);

        $item->players()->detach();

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        $item->delete();

        return ['deleted' => true, 'id' => $id];
    }
}