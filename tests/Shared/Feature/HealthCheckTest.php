<?php


namespace Tests\Shared\Feature;

use Tests\Shared\FeatureTestCase;

class HealthCheckTest extends FeatureTestCase
{
    /** @test */
    public function databaseShouldBeConnected(): void
    {
        $request = $this->createRequest('GET', '/api/health-check');
        $isConnected = $this->getResponseResult($request)['mariadb'];

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertTrue($isConnected);
    }
}