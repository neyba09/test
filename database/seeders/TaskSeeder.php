<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(5)->create();

        $tasks = [
            [
                'title' => 'Купить молоко',
                'description' => 'В магазине у дома',
                'status' => 'pending',
                'due_date' => '2024-12-31',
                'created_at' => '2024-01-01 10:00:00',
                'updated_at' => '2024-01-01 10:00:00',
            ],
            [
                'title' => 'Сделать домашку',
                'description' => 'По математике',
                'status' => 'in_progress',
                'due_date' => '2024-12-15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Записаться к врачу',
                'description' => 'Терапевт, 3 января',
                'status' => 'pending',
                'due_date' => '2024-01-03',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Позвонить бабушке',
                'description' => '',
                'status' => 'completed',
                'due_date' => '2024-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Купить подарок',
                'description' => 'Для друга на день рождения',
                'status' => 'in_progress',
                'due_date' => '2024-02-14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Заправить машину',
                'description' => 'Бензин АИ-95',
                'status' => 'pending',
                'due_date' => '2024-01-05',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Отправить отчет',
                'description' => 'По проекту для руководителя',
                'status' => 'pending',
                'due_date' => '2024-01-07',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Погулять с собакой',
                'description' => '',
                'status' => 'completed',
                'due_date' => '2024-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Прочитать книгу',
                'description' => '«Мастер и Маргарита»',
                'status' => 'in_progress',
                'due_date' => '2024-01-20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Сходить в спортзал',
                'description' => '',
                'status' => 'pending',
                'due_date' => '2024-01-02',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($tasks as $task) {
            Task::create(array_merge($task, ['user_id' => $users->random()->id]));
        }
    }
}
