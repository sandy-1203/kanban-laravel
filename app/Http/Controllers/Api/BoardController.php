<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Http\HttpStatuses;
use App\Services\BoardService;

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
}
