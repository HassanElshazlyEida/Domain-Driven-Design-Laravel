<?php

namespace Domain\Network\Entities;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Domain\Network\Models\Company;

class CompanyEntity extends Data
{

    public function __construct(
        public readonly string $name,
        public readonly ?string $logo,
        public readonly ?string $website,
        public readonly ?string $industry,
        public readonly ?string $email,
        public readonly ?string $description,
        public readonly ?array $socials,
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
