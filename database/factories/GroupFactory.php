<?php

namespace Database\Factories;

use App\Enums\Group\SectionEnum;
use App\Enums\Group\TypeEnum;
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
            'title' => $this->faker->words(2, true),
            'section' => $this->faker->randomElement(array_column(SectionEnum::cases(), 'value')), // Sabit değer
            'type' => $this->faker->randomElement(array_column(TypeEnum::cases(), 'value')), // Rastgele type değeri
            'order' => $this->faker->numberBetween(1, 10),
            'is_system' => false,
        ];
    }
}
