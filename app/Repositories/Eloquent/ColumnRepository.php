<?php

namespace App\Repositories\Eloquent;

use App\Helpers\Eloquent\Repository\HasDispalyOrderColumn;
use App\Models\Column;
use Illuminate\Support\Facades\DB;

class ColumnRepository extends BaseRepository
{

    const MODEL_LABEL = 'Column';

    use HasDispalyOrderColumn;

    public function __construct(
        Column $model
    ) {
        parent::__construct($model);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->user()->id;
        $data['display_order'] = DB::select("SELECT COALESCE(MAX(display_order), 0) as display_order from `columns` where board_id={$data['board_id']}")[0]->display_order + 1;
        return parent::create($data);
    }
}
