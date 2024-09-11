<?php

namespace Database\Factories\Network;

use Domain\Network\Models\Company;
use Domain\Network\Models\Contact;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;
    public function definition()
    {
        return [
   
            'name' => fake()->company(),
            'logo' => fake()->imageUrl(),
            'website' => fake()->url(),
            'industry' => fake()->jobTitle(),
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->sentence(),
            'socials' => [
                'twitter' => fake()->userName(),
                'facebook' => fake()->userName(),
                'instagram' => fake()->userName(),
                'linkedin' => fake()->userName(),
            ],      
            'user_id' => User::factory(),
        
        ];
    }
}
