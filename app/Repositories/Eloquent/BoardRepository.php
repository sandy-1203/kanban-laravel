<?php

namespace App\Repositories\Eloquent;

use App\Models\Board;

class BoardRepository extends BaseRepository
{

    const MODEL_LABEL = 'Board';

    public function __construct(
        Board $model
    ) {
        parent::__construct($model);
    }
}
