<?php

namespace App\Http\Web\Controllers\Subscriber;

use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\ViewModels\UpsertSubscriberViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SubscriberController
{
    public function create(): Response
    {
        return Inertia::render('Subscriber/Form', [
            'model' => new UpsertSubscriberViewModel(),
        ]);
    }

    public function store(SubscriberData $data, Request $request): RedirectResponse
    {
        UpsertSubscriberAction::execute($data, $request->user());

        return Redirect::route('subscribers.index');
    }

    public function edit(Subscriber $subscriber): Response
    {
        return Inertia::render('Subscriber/Form', [
            'model' => new UpsertSubscriberViewModel($subscriber),
        ]);
    }

    public function update(SubscriberData $data, Request $request): RedirectResponse
    {
        UpsertSubscriberAction::execute($data, $request->user());

        return Redirect::route('subscribers.index');
    }

}