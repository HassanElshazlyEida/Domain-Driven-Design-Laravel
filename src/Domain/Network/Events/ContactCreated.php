<?php

namespace Domain\Network\Events;

use Domain\Network\Entities\ContactEntity;
use Infrastructure\Events\DomainEvent;

class ContactCreated extends DomainEvent
{
    public function __construct(
        public readonly ContactEntity $contact
    )
    {
       
    }
}
