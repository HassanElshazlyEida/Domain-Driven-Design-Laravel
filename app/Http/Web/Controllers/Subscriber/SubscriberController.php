<?php

namespace App\Http\Web\Controllers\Subscriber;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Redirect;
use Domain\Subscriber\Actions\DeleteSubscriberAction;
use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\ViewModels\GetSubscribersViewModel;
use Domain\Subscriber\ViewModels\UpsertSubscriberViewModel;

class SubscriberController
{
    public function index(Request $request): Response
    {
        return Inertia::render('Subscriber/List', [
            'model' => new GetSubscribersViewModel($request->get('page', 1)),
        ]);
    }

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
    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        DeleteSubscriberAction::execute($subscriber);

        return Redirect::route('subscribers.index');
    }
    

}