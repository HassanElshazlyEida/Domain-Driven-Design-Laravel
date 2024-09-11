<?php

namespace Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use Spatie\LaravelData\Lazy;
use Domain\Shared\Models\User;
use Domain\Network\Models\Company;
use Domain\Network\Models\Contact;
use Illuminate\Database\DatabaseManager;
use Domain\Network\Entities\CompanyEntity;
use Domain\Network\Entities\ContactEntity;
use Domain\Network\Services\ContactService;
use Domain\Network\ValueObjects\EmailObject;
use Domain\Network\Aggregates\ContactAggregate;
use Domain\Network\Repositories\ContactRepository;

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
    public function test_can_create_contact():void {

        $this->assertEquals(0,Contact::query()->count());

        $company =Company::factory()->create();
        $contact = Contact::factory()->for($company)->create();

        $contactEntity = new ContactEntity(
            name: $contact->name,
            socials: $contact->socials,
            role: $contact->role,
            pronouns: $contact->pronouns,
            birthday: $contact->birthday,
            user_id: $contact->user_id,
            email: EmailObject::from($contact->email),
            company: $company->getData(),
            company_id: $company->id,
        );

        $createdContact = $this->service()->create($contactEntity);

        $this->assertInstanceOf(ContactEntity::class,$createdContact);
        $this->assertEquals($contactEntity->name,$createdContact->name);
        $this->assertEquals($contactEntity->email,$createdContact->email);
        $this->assertInstanceOf(CompanyEntity::class,$contactEntity->company);
        $this->assertInstanceOf(Lazy::class,$createdContact->company);
        $this->assertInstanceOf(CompanyEntity::class,$createdContact->company->resolve());
        
    }
    // update test function
    public function test_can_update_contact(): void {
        $contact = Contact::factory()->create();
        $company = Company::factory()->create();
        $user = User::factory()->create();
        $contactEntity = new ContactEntity(
            name: 'John Doe',
            email: EmailObject::from('test@test.com'),
            socials: ['twitter' => 'test'],
            role: 'developer',
            pronouns: 'he/him',
            birthday: Carbon::now()->subYears(30),
            company: $company->getData(),
            company_id: $company->id,
            user_id: $user->id,
            
        );
        $this->service()->update($contact->id, $contactEntity);
        $contact = Contact::find($contact->id);
        $this->assertEquals($contact->name,'John Doe');
        $this->assertEquals($contact->role, 'developer');

    }
    // delete test function
    public function test_can_delete_contact(): void {

        $this->assertEquals(0,Contact::query()->count());
        $contact = Contact::factory()->create();
        $this->assertEquals(1,Contact::query()->count());
        $this->service()->delete($contact->id);
        $this->assertEquals(0,Contact::query()->count());
        
    }
    

}
