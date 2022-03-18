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

    public function listCards($userId, $data)
    {
        return $this->model->where('user_id', $userId)->when(!@$data['status'], function ($query) use ($data) {
            $query->withTrashed();
        })->when(isset($data['status']) && @$data['status'] == 0, function ($query) use ($data) {
            $query->onlyTrashed();
        })->when(@$data['date'], function ($query) use ($data) {
            $query->where('created_at', '>=', $data['date']);
        })->get()->makeHidden(['column_id', 'updated_at', 'user_id', 'display_order']);
    }
}
