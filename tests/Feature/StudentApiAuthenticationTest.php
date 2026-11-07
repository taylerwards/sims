<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudentApiAuthenticationTest extends TestCase
{
    public function test_student_api_endpoints_require_authentication_and_return_json(): void
    {
        $responses = [
            $this->getJson('/api/students'),
            $this->getJson('/api/students/2'),
            $this->postJson('/api/students', []),
            $this->putJson('/api/students/2', []),
            $this->deleteJson('/api/students/2'),
        ];

        foreach ($responses as $response) {
            $response->assertUnauthorized();
            $response->assertJsonStructure(['message']);
        }
    }
}
