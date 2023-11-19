<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Enums\StatusEnum;
class TaskFactory extends Factory
{
    protected $model = Task::class;
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'description' => fake()->text(),
            'dateline' => fake()->date(),
            'status' => Arr::random(StatusEnum::cases()),
            'user_id' => User::pluck('id')->random(),
            'client_id' => Client::pluck('id')->random(),
            'project_id' => Project::pluck('id')->random()
        ];
    }
}
