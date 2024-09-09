<?php

namespace Domain\Network\Entities;

use Spatie\LaravelData\Data;

class CompanyEntity extends Data
{

    public function __construct(
        private string $name,
        private ?string $logo,
        private ?string $website,
        private ?string $industry,
        private ?string $email,
        private ?string $description,
        private ?array $socials,
        private int $user_id,
    )
    {
        
    }
}
