<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Http\CanRespondJson;
use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    use CanRespondJson;
}
