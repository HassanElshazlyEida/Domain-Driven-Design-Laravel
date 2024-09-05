<?php

namespace Domain\Subscriber\DataTransferObjects;

use Domain\Subscriber\Models\Tag;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class TagData extends Data
{
    public function __construct(
        public readonly ?int   $id,
        public readonly string $title,
    )
    {
    }
}