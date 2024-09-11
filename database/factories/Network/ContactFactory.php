<?php

namespace Database\Factories\Network;

use Domain\Network\Models\Company;
use Domain\Network\Models\Contact;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'socials' => [
                'twitter' => fake()->userName(),
                'facebook' => fake()->userName(),
                'instagram' => fake()->userName(),
                'linkedin' => fake()->userName(),
            ],
            'role' => fake()->jobTitle(),
            'pronouns' => fake()->randomElement(['he/him', 'she/her', 'they/them']),
            'birthday' => fake()->dateTimeThisCentury(),
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
        ];
    }
}
