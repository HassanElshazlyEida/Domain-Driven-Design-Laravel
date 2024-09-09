<?php

namespace Domain\Network\Aggregates;

use Domain\Network\Entities\CompanyEntity;
use Domain\Network\Entities\ContactEntity;

final readonly class ContactAggregate
{
    public function __construct(
        private ContactEntity $contact,
        private CompanyEntity $company
    )
    {
        
    }

    public function getContact(): ContactEntity
    {
        return $this->contact;
    }

    public function getCompany(): CompanyEntity
    {
        return $this->company;
    }
}
