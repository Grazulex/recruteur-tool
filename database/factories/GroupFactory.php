<?php

namespace Database\Factories;

use App\Enums\GroupType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name"=> $this->faker->name,
            "description"=> $this->faker->text,
            "group_type" => $this->faker->randomElement(GroupType::cases()),
            "user_id"=> User::factory(),
        ];
    }
}
