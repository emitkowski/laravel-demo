<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Resources\ResourceFactory;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

/**
 * Class APIController
 *
 * @package App\Http\Controllers\API\V1
 */
class APIController extends Controller
{
    /**
     * Resource Name
     *
     * @var string
     */
    protected $resource_name;

    /**
     * API Authorized User Object
     *
     * @var
     */
    protected $user;

    /**
     * API Object Model
     *
     * @var
     */
    protected $model;

    /**
     * Error Response Handler
     *
     * @var Response
     */
    protected $error_response;

    /**
     * Records per pagination page
     *
     * @var int
     */
    protected $record_per_page = 25;

    /**
     * APIController constructor.
     * @param Model $model
     * @param Response $error_response
     */
    public function __construct(Model $model, Response $error_response)
    {
        $this->model = $model;
        $this->error_response = $error_response;

        $this->user = auth()->guard('api')->user();
    }

    /**
     * Display a listing of all the resource.
     *
     */
    public function index()
    {
        return $this->resourceCollection($this->model->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->findRow($id);

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        return $this->resource($item);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param array $added_inputs
     * @return mixed
     */
    protected function storeResource(Request $request, $added_inputs = [])
    {
        $input = $request->getConvertedInput();

        $input = array_merge($input, $added_inputs);

        try {
            $item = $this->model->create($input);
        } catch(QueryException $e) {
            return $this->error_response->errorWrongArgs('Invalid Field in Create Request: ' . $e->getMessage());
        }

        return $this->resource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @param array $added_inputs
     * @return mixed
     */
    protected function updateResource(Request $request, $id, $added_inputs = [])
    {
        $item = $this->findRow($id);

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        $input = $request->getConvertedInput();

        $input = array_merge($input, $added_inputs);

        try {
            $item->update($input);
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

        if (!$item) {
            return $this->error_response->errorNotFound($this->resource_name . ' Not Found - ID# ' . $id);
        }

        $item->delete();

        return ['deleted' => true, 'id' => $id];
    }

    /**
     * Display a listing of all the resource paginated.
     *
     */
    public function paginate()
    {
        $paginator = $this->model->paginate($this->record_per_page);

        return $this->resourceCollection($paginator);
    }

    /**
     * Find Data Row by ID
     *
     * @param $id
     * @return mixed
     */
    protected function findRow($id)
    {
        return $this->model->find($id);
    }

    /**
     * Return Resource Response
     *
     * @param $item
     * @return mixed
     */
    protected function resource($item)
    {
        if (!isset($this->resource_name)) {
            return $this->error_response->errorInternalError('Resource Not Configured');
        }

        return ResourceFactory::resource($this->resource_name, $item);
    }

    /**
     * Return Resource Collection Response
     *
     * @param $collection
     * @return mixed
     */
    protected function resourceCollection($collection)
    {
        if (!isset($this->resource_name)) {
            return $this->error_response->errorInternalError('Resource Not Configured');
        }

        return ResourceFactory::resourceCollection($this->resource_name, $collection);
    }
}