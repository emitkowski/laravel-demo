<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Database\QueryException;

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
     * Display a listing of all the resource.
     *
     */
    public function index()
    {
        return $this->resourceCollection($this->model->with('teams')->get());
    }


    /**
     * Display a listing of all the resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->model->where('id', $id)->with('teams')->first();

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        return $this->resource($item);
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
        $item = $this->findRow($id);

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        // Set Teams
        $item->teams()->sync($request->input('team'));

        try {
            $item->update($request->except('team'));
        } catch(QueryException $e) {
            return $this->error_response->errorWrongArgs('Invalid Field in Update Request: ' . $e->getMessage());
        }

        return $this->resource($item);
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