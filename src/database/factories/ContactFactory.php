<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker=\Faker\Factory::create('ja_JP');

        return [
            'category_id' => rand(1,5),
            'last_name' => $this->faker->firstName,
            'first_name' => $this->faker->lastName,
            'gender' => rand(1,3),
            'email' => $this->faker->unique()->safeEmail,
            'tel' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'building' => $this->faker->optional()->buildingNumber,
            'detail' => $this->faker->realText(50),
        ];
    }
}
