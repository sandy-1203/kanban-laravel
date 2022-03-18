<?php

namespace App\Services;

use App\Repositories\Eloquent\BoardRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $board = $this->boardRepo->findOne([['id', $id], ['user_id', auth()->user()->id]]);
        if (!$board) throw new ModelNotFoundException($this->boardRepo->getModelLabel() . " $id not found!.");
        $board->load('columns.cards');
        return $board;
    }

    public function create($data)
    {
        return $this->boardRepo->create($data);
    }

    public function dataTable($data)
    {
        return $this->boardRepo->dataTable($data);
    }

    public function delete($id)
    {
        $board = $this->boardRepo->findOrFail($id);
        $columns = $board->columns();
        $columns->cards()->forceDelete();
        $columns->forceDelete();
        $board->delete();
        return $board;
    }
}
