<?php

namespace Database\Factories\Customer;

use App\Enums\Group\TypeEnum;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('C-#####'),
            'title' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone1' => $this->faker->phoneNumber,
            'phone2' => $this->faker->optional()->phoneNumber,
            'city' => $this->faker->city,
            'district' => $this->faker->word,
            'address1' => $this->faker->address,
            'address2' => $this->faker->optional()->address,
            'tax_number' => $this->faker->numerify('###-###-###'),
            'tax_office' => $this->faker->company,
            'special_group1_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG1)->first()->id ?? null,
            'special_group2_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG2)->first()->id ?? null,
            'special_group3_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG3)->first()->id ?? null,
            'special_group4_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG4)->first()->id ?? null,
            'special_group5_id' => Group::inRandomOrder()->where('type', TypeEnum::PRODUCT_SG5)->first()->id ?? null,
            'type' => $this->faker->randomElement(['1', '2', '3']), // Belirli değerlerden birini seç
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => null,
        ];
    }
}
