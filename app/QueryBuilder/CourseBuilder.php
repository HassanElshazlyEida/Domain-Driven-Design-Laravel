<?php

namespace App\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

class CourseBuilder extends Builder
{
    public function wherePhone(string $phone): self
    {
        return $this->where('phone', 'like', '%' . $phone . '%');
    }

    public function whereTitle(string $title): self
    {
        return $this->where('title', 'like', '%' . $title . '%');
    }

    public function wherePhoneAndTitle(?string $phone, ?string $title): self
    {
        return $this->when($phone, function ($query, $phone) {
            return $query->wherePhone($phone);
        })->when($title, function ($query, $title) {
            return $query->whereTitle($title);
        });
    }
}
