<?php

namespace App\Repositories\Eloquent;

use App\Helpers\DataTable\HasDataTable;
use App\Models\Board;

class BoardRepository extends BaseRepository
{

    use HasDataTable;

    const MODEL_LABEL = 'Board';

    public function __construct(
        Board $model
    ) {
        parent::__construct($model);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->user()->id;
        return parent::create($data);
    }

    public function dataTable($data)
    {
        return $this->useDataTable($data, null, function ($query) {
            $query->with('user')->where('user_id', auth()->user()->id);
        });
    }
}
