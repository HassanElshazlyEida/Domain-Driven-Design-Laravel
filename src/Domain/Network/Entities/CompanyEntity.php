<?php

namespace Domain\Network\Entities;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Domain\Network\Models\Company;

class CompanyEntity extends Data
{

    public function __construct(
        public readonly ?string $id = null,
        public readonly string $name,
        public readonly ?string $logo = null,
        public readonly ?string $website = null,
        public readonly ?string $industry = null,
        public readonly ?string $email = null,
        public readonly ?string $description = null,
        public readonly ?array $socials = null,
        public readonly int $user_id,
    )
    {
        
    }

    public static function fromModel(Company $company): self
    {
        return self::from([
            ...$company->toArray(),
        ]);
    }
    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
        ]);
    }
}
