<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'title'=>fake()->jobTitle,
                'tags'=> 'laravel ,javascript',
                'company_name'=>fake()->company(),
                'location'=>fake()->country(),
                'email'=>fake()->companyEmail(),
                'description'=>fake()->paragraph()
        ];
    }
}
