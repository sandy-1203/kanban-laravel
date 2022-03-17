<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Http\HttpStatuses;
use App\Http\Requests\Api\Column\CreateColumnRequest;
use App\Http\Requests\Api\Column\UpdateColumnRequest;
use App\Services\ColumnService;

class ColumnController extends BaseApiController
{

    private $columnService;

    public function __construct(
        ColumnService $columnService
    ) {
        $this->columnService = $columnService;
    }

    public function create(CreateColumnRequest $request)
    {
        $column = $this->columnService->create($request->all());
        return $this->respond($column, HttpStatuses::HTTP_OK, "Column successfully added!.");
    }

    public function update($id, UpdateColumnRequest $request)
    {
        $column = $this->columnService->update($id, $request->all());
        return $this->respond($column, HttpStatuses::HTTP_OK, "Column successfully updated!.");
    }

    public function delete($id)
    {
        $column = $this->columnService->delete($id);
        return $this->respond($column, HttpStatuses::HTTP_OK, "Column successfully deleted!.");
    }
}
