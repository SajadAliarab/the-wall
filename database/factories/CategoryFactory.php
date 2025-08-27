<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now(),
            'parent_id' => null,
        ];
    }

    public function withParent(): CategoryFactory
    {
        return $this->state(
            fn (array $attributes) => [
                'parent_id' => \App\Models\Category::query()->inRandomOrder()->first()->id,
            ]
        );
    }

    public function root(): CategoryFactory
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => null,
        ]);

    }
}
