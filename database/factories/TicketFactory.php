<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    public function definition(): array
    {
        return [
            'subject' => fake()->sentence(3),
            'content' => fake()->text(),
            'user_name' => fake()->name(),
            'user_email' => fake()->email(),
            'priority' => fake()->numberBetween(1, 5),
            'status' => fake()->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
