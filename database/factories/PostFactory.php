<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\States\Post\PostApprovedStatus;
use App\Models\States\Post\PostPendingStatus;
use App\Models\States\Post\PostRejectedStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->word(),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(),
            'status' => fake()->randomElement([
                PostPendingStatus::class,
                PostApprovedStatus::class,
                PostRejectedStatus::class,
            ]),
            'user_id' => \App\Models\User::query()->inRandomOrder()->first()->id,
            'category_id' => \App\Models\Category::query()->inRandomOrder()->first()->id,
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post): void {
            $attachmentId = range(1, 5);
            $randomAttachment = collect($attachmentId)->random(rand(1, 3));
            $post->attachments()->attach($randomAttachment);

        });
    }

    public function approved(): Factory
    {
        return $this->state(fn () => ['status' => PostApprovedStatus::class]);
    }

    public function rejected(): Factory
    {
        return $this->state(fn () => ['status' => PostRejectedStatus::class]);
    }

    public function pending(): Factory
    {
        return $this->state(fn () => ['status' => PostPendingStatus::class]);

    }
}
