<?php

namespace App\Services;

use App\Repositories\Eloquent\CardRepository;
use App\Repositories\Eloquent\ColumnRepository;

class CardService
{

    protected ColumnRepository $columnRepo;
    protected CardRepository $cardRepo;

    public function __construct(
        CardRepository $cardRepo,
        ColumnRepository $columnRepo
    ) {
        $this->cardRepo = $cardRepo;
        $this->columnRepo = $columnRepo;
    }

    public function upsert($data)
    {
        if (@$data['id']) {
            $card = $this->cardRepo->findById($data['id']);
            if ($card) {
                $this->cardRepo->upsert(['id' => $data['id']], $data);
                return $card->refresh();
            }
        }
        return $this->cardRepo->create($data);
    }

    public function move($id, $data)
    {
        $card = $this->cardRepo->findOrFail($id);
        $column = $this->columnRepo->findOrFail($data['column_id']);
        $this->cardRepo->shiftDisplayOrder($card['display_order'], [['column_id', $card['column_id']]], 1, '-', '>');
        $this->cardRepo->shiftDisplayOrder($card['display_order'], [['column_id', $column['id']]], 1, '+', '>=');
        $this->cardRepo->update([['id', $id]], ['display_order' => $data['newIndex'], 'column_id' => $column['id']]);
        return $card->refresh();
    }

    public function delete($id)
    {
        $card = $this->cardRepo->findOrFail($id);
        $this->cardRepo->shiftDisplayOrder($card['display_order'], [['column_id', $card['column_id']]], 1, '-', '>');
        $card->delete();
        return $card->refresh();
    }
}
