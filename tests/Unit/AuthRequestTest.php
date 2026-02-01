<?php

namespace Tests\Unit;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthRequestTest extends TestCase
{
    public function test_auth_request_validation_passes_with_correct_data()
    {
        $data = [
            'email' => 'user@example.com',
            'password' => 'user000',
        ];

        $validator = $this->validate($data);
        $this->assertTrue($validator->passes());

    }

    public function test_auth_request_validation_fails_with_invalid_email(): void
    {
        $data = [
            'email' => 'not-an-email',
            'password' => 'user000',
        ];

        $validator = $this->validate($data);
        $this->assertFalse($validator->passes(), 'Validation should fail with invalid email.');
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    private function validate(array $data)
    {
        $request = new AuthRequest();
        return Validator::make($data, $request->rules());
    }
}
