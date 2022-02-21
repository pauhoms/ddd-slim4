<?php


namespace Tests\User;


class HealthCheckTest extends UserFeatureTestCase
{
    /** @test */
    public function databaseShouldBeConnected(): void
    {
        $request = $this->createRequest('GET', '/api/authentication/health-check');
        $isConnected = $this->getResponseResult($request)['mariadb'];

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertTrue($isConnected);
    }
}