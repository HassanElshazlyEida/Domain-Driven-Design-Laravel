<?php

namespace Unit\Services;

use Domain\Network\Aggregates\ContactAggregate;
use Domain\Network\Entities\CompanyEntity;
use Domain\Network\Entities\ContactEntity;
use Domain\Network\Models\Company;
use Domain\Network\Models\Contact;
use Domain\Network\Repositories\ContactRepository;
use Domain\Network\Services\ContactService;
use Illuminate\Database\DatabaseManager;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{
    protected function service(): ContactService {

        return new ContactService(
            repo: new ContactRepository(
                query: Contact::query(),
                database: resolve(DatabaseManager::class)
            )
        );
    }
    public function test_can_get_all_contacts():void {

        Contact::factory()->count(1)->create();

        $contacts = $this->service()->all();

        foreach($contacts as $contact) {
            $this->assertInstanceOf(ContactEntity::class,$contact);
        }

    }
    public function test_can_get_contact_aggregate():void {

        $contact = Contact::factory()->for(Company::factory()->create())->create();

        $contactAggregate = $this->service()->aggregate($contact->id);

        $this->assertInstanceOf(ContactAggregate::class,$contactAggregate);
        $this->assertInstanceOf(ContactEntity::class,$contactAggregate->getContact());
        $this->assertInstanceOf(CompanyEntity::class,$contactAggregate->getCompany());

    }
    

}
