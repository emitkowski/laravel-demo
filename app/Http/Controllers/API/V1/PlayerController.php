<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use EllipseSynergie\ApiResponse\Contracts\Response;

/**
 * Class PlayerController
 *
 * @package App\Http\Controllers\API\V1
 */
class PlayerController extends APIController
{
    /**
     * Resource Name
     *
     * @var string
     */
    protected $resource_name = 'Player';

    /**
     * PlayerController constructor.
     *
     * @param Player $model
     * @param Response $error_response
     */
    public function __construct(Player $model, Response $error_response)
    {
        parent::__construct($model, $error_response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlayerRequest $request
     * @return mixed
     */
    public function store(PlayerRequest $request)
    {
        return parent::storeResource($request);
    }

    /**
     * Update the specified resource in storage
     *
     * @param PlayerRequest $request
     * @param $id
     * @return mixed
     */
    public function update(PlayerRequest $request, $id)
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

        $item->teams()->detach();

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        $item->delete();

        return ['deleted' => true, 'id' => $id];
    }
}