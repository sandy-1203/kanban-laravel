<?php

namespace App\Services;

use App\Repositories\Eloquent\BoardRepository;

class BoardService
{

    protected BoardRepository $boardRepo;

    public function __construct(
        BoardRepository $boardRepo
    ) {
        $this->boardRepo = $boardRepo;
    }

    public function findWithCards($id)
    {
        $board = $this->boardRepo->findOrFail($id);
        $board->load('columns.cards');
        return $board;
    }
}
