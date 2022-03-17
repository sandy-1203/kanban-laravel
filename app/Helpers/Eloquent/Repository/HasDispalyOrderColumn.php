<?php

namespace App\Helpers\Eloquent\Repository;

use Illuminate\Support\Facades\DB;

trait HasDispalyOrderColumn
{
    protected $model;

    public function shiftDisplayOrder($displayOrder, $where = [], $place = 1, $shiftOperator = '+', $operator = '>=')
    {
        $this->findAndOrSort($where)->where('display_order', $operator, (int) $displayOrder)->update([
            'display_order' => DB::raw("`display_order` $shiftOperator $place")
        ]);
    }
}
