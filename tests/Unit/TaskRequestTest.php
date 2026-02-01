<?php

namespace Tests\Unit;

use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class TaskRequestTest extends TestCase
{
    /**
     * Тест валидации для корректных данных.
     *
     * @return void
     */
    public function test_task_request_validation_passes_with_valid_data()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test description for task',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ];

        $request = new TaskRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /**
     * Тест валидации с пустым полем "title".
     *
     * @return void
     */
    public function test_task_request_validation_fails_with_empty_title()
    {
        $data = [
            'title' => '',
            'description' => 'Test description for task',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ];

        $request = new TaskRequest();

        $rules = $request->rules();
        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
    }

    /**
     * Тест валидации для поля "status".
     *
     * @return void
     */
    public function test_task_request_validation_fails_with_invalid_status()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test description for task',
            'status' => 'invalid_status',
            'due_date' => '2024-12-31',
        ];

        $request = new TaskRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    /**
     * Тест валидации для некорректного формата даты "due_date".
     *
     * @return void
     */
    public function test_task_request_validation_fails_with_invalid_due_date_format()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test description for task',
            'status' => 'pending',
            'due_date' => '31-12-2024',
        ];

        $request = new TaskRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('due_date', $validator->errors()->toArray());
    }

    /**
     * Тест валидации с правильным форматом "due_date".
     *
     * @return void
     */
    public function test_task_request_validation_passes_with_valid_due_date_format()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test description for task',
            'status' => 'completed',
            'due_date' => '2024-12-31',
        ];

        $request = new TaskRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }
}
