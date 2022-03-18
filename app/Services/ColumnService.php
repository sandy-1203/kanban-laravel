<?php

namespace App\Services;

use App\Repositories\Eloquent\BoardRepository;
use App\Repositories\Eloquent\ColumnRepository;

class ColumnService
{

    protected ColumnRepository $columnRepo;
    protected BoardRepository $boardRepo;

    public function __construct(
        ColumnRepository $columnRepo,
        BoardRepository $boardRepo
    ) {
        $this->boardRepo = $boardRepo;
        $this->columnRepo = $columnRepo;
    }

    public function create($data)
    {
        $this->boardRepo->findOrFail($data['board_id']);
        return $this->columnRepo->create($data);
    }

    public function update($id, $data)
    {
        $column = $this->columnRepo->findOrFail($id);
        $this->columnRepo->update([['id', $id]], $data);
        return $column->refresh();
    }

    public function delete($id)
    {
        $column = $this->columnRepo->findOrFail($id);
        $column->delete();
        $column->cards()->delete();
        return $column->refresh();
    }
}
