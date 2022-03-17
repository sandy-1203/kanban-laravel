<?php

namespace App\Repositories\Eloquent;

use App\Helpers\Eloquent\Repository\HasDispalyOrderColumn;
use App\Models\Card;
use Illuminate\Support\Facades\DB;

class CardRepository extends BaseRepository
{

    const MODEL_LABEL = 'Card';

    use HasDispalyOrderColumn;

    public function __construct(
        Card $model
    ) {
        parent::__construct($model);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->user()->id;
        $data['display_order'] = DB::select("SELECT COALESCE(MAX(display_order), 0) as display_order from `cards` where column_id={$data['column_id']}")[0]->display_order + 1;
        return parent::create($data);
    }
}
