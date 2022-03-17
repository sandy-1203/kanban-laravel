<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Http\HttpStatuses;
use App\Http\Requests\Api\Card\MoveCardRequest;
use App\Http\Requests\Api\Card\UpsertCardRequest;
use App\Services\CardService;

class CardController extends BaseApiController
{

    private CardService $cardService;

    public function __construct(
        CardService $cardService
    ) {
        $this->cardService = $cardService;
    }

    public function upsert(UpsertCardRequest $request)
    {
        $card = $this->cardService->upsert($request->all());
        return $this->respond($card, HttpStatuses::HTTP_OK, "Card successfully added!.");
    }

    public function move($id, MoveCardRequest $request)
    {
        $card = $this->cardService->move($id, $request->all());
        return $this->respond($card, HttpStatuses::HTTP_OK, "Card successfully moved!.");
    }

    public function delete($id)
    {
        $card = $this->cardService->delete($id);
        return $this->respond($card, HttpStatuses::HTTP_OK, "Card successfully deleted!.");
    }
}
