<?php

namespace Database\Factories\Product;

use App\Enums\Group\TypeEnum;
use App\Models\Group;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('PS-#######'),
            'name' => $this->faker->words(3, true),
            'unit_id' => Unit::inRandomOrder()->first()->id ?? 1,
            'purchase_vat_rate' => $this->faker->numberBetween(0, 18),
            'purchase_price' => $this->faker->randomFloat(2, 50, 1000),
            'sell_vat_rate' => $this->faker->numberBetween(0, 18),
            'sell_price' => $this->faker->randomFloat(2, 75, 1500),
            'quantity' => $this->faker->numberBetween(1, 100),
            'special_group1_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG1)->first()->id ?? null,
            'special_group2_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG2)->first()->id ?? null,
            'special_group3_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG3)->first()->id ?? null,
            'special_group4_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG4)->first()->id ?? null,
            'special_group5_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG5)->first()->id ?? null,
            'type' => $this->faker->randomElement(['1', '2']),
            'created_by' => User::inRandomOrder()->first()->id ?? 1,
            'updated_by' => User::inRandomOrder()->first()->id ?? 1,
            'deleted_by' => null,
        ];
    }
}
