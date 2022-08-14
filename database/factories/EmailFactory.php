<?php

namespace Database\Factories;

use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->word(),
            'name' => $this->faker->name(),
            'domain' => $this->faker->word(),
        ];
    }
}
