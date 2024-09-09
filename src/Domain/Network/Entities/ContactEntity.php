<?php

namespace Domain\Network\Entities;

use Carbon\Carbon;
use Domain\Network\ValueObjects\EmailObject;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

final class ContactEntity extends Data
{

    public function __construct(
        private string $name,
        private EmailObject $email,
        private ?array $socials,
        private ?string $role,
        private ?string $pronouns,
        #[WithCast('birthday', DateTimeInterfaceCast::class)]
        private ?string $birthday,
        private CompanyEntity $company,

        // private Company $company,
        // private User $user
    ) {
    }

}
