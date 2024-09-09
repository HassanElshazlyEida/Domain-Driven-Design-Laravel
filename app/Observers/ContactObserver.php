<?php

namespace App\Observers;

use Domain\Network\Events\ContactCreated;
use Domain\Network\Models\Contact;
use Illuminate\Events\Dispatcher;

class ContactObserver
{
    public function __construct(
        private Dispatcher $events 
    )
    {
        
    }
    public function created(Contact $contact): void
    {
        $this->events->dispatch(new ContactCreated($contact->getData()));
    }
}
