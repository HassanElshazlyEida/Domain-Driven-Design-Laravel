<?php

namespace App\Http\Api\Subscriber;

use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateSubscriberController
{
    public function __invoke(SubscriberData $data, Request $request): SubscriberData
    {
        $subscriber = UpsertSubscriberAction::execute($data, $request->user());

        return $subscriber->getData();
    }
}