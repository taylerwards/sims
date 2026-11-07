<?php

namespace Tests\Feature;

use Tests\TestCase;

class EnrollmentShowRouteTest extends TestCase
{
    public function test_enrollment_details_route_accepts_get_and_requires_authentication(): void
    {
        $response = $this->get('/enrollments/2');

        $response->assertRedirect(route('login'));
    }
}
