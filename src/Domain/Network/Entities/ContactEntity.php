<?php

namespace Domain\Network\Entities;

use Carbon\Carbon;
use Domain\Network\Models\Company;
use Domain\Network\Models\Contact;
use Domain\Network\ValueObjects\EmailObject;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Attributes\Computed;

final class ContactEntity extends Data
{
   

    public function __construct(
        public readonly string $name,
        public readonly EmailObject $email,
        public readonly ?array $socials = null,
        public readonly ?string $role = null,
        public readonly ?string $pronouns = null,
        #[WithCast(DateTimeInterfaceCast::class, format: "Y-m-d H:i:s")]
        public readonly ?Carbon $birthday = null,
        public readonly null|Lazy|CompanyEntity $company = null,
        public readonly ?string $company_id = null,
        public readonly ?string $user_id,

    ) {
       
    }
    public static function fromRequest(Request $request): self
    {

        return self::from([
            ...$request->all(),
            'email' => EmailObject::from($request->email),
            'company'=> CompanyEntity::from(Company::findOrNew($request->company_id ?? null)),
        ]);
    }
    public static function fromModel(Contact $contact): self
    {
        return self::from([
            ...$contact->toArray(),
            'company' => Lazy::whenLoaded('company', $contact, fn () => CompanyEntity::from($contact->company)),
            'email' =>EmailObject::from($contact->email),
        ]);
    }

}
