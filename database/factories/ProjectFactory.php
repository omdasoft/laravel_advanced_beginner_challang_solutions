<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use App\Enums\StatusEnum;
class ProjectFactory extends Factory
{
    protected $model = Project::class;
   
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'dateline' => fake()->date(),
            'status' => Arr::random(StatusEnum::cases()),
            'user_id' => User::pluck('id')->random(),
            'client_id' => Client::pluck('id')->random()
        ];
    }
}
