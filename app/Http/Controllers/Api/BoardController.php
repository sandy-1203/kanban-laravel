<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Http\HttpStatuses;
use App\Http\Requests\Api\Board\CreateBoardRequest;
use App\Services\BoardService;
use Illuminate\Http\Request;

class BoardController extends BaseApiController
{

    private $boardService;

    public function __construct(
        BoardService $boardService
    ) {
        $this->boardService = $boardService;
    }

    public function find($id)
    {
        $board = $this->boardService->findWithCards($id);
        return $this->respond($board);
    }

    public function create(CreateBoardRequest $request)
    {
        $board = $this->boardService->create($request->validated());
        return $this->respond($board);
    }

    public function delete($id)
    {
        $board = $this->boardService->delete($id);
        return $this->respond($board);
    }

    public function dataTable(Request $request)
    {
        $data = $this->boardService->dataTable($request->all());
        return $this->respond($data);
    }
}
