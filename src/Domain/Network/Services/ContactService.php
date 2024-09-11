<?php

namespace Domain\Network\Services;

use Domain\Network\Aggregates\ContactAggregate;
use Domain\Network\Entities\CompanyEntity;
use Domain\Network\Entities\ContactEntity;
use Domain\Network\Repositories\ContactRepository;
use Illuminate\Support\Collection ;

final class ContactService
{
    public function __construct(
        private ContactRepository $repo,
    ) {
    }

    /**
     * 
     * @return Collection<ContactEntity>
     */
    public function all(): Collection
    {
        return $this->repo->all()->map(function ($contact) {
            return $contact->getData();
        });
    }

    public function aggregate(string $id): ContactAggregate
    {
        $contact = $this->repo->find(
            id: $id,
            with : ['company']
        );
    
        return new ContactAggregate(
           contact:  $contact->getData(),
           company: $contact->company->getData(),
        );
    }

}
