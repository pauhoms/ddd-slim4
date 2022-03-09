<?php

namespace Tests\User\Feature;

use Tests\Shared\FeatureTestCase;

final class GenerateAuthenticationTokenTest extends FeatureTestCase 
{
    /** @test */
    public function tokenShouldBeGenerated(): void
    {
        $request = $this->createRequest(
            'PUT',
            '/api/v1/user/generate-token', 
            [
                "username" => "pau",
                "password" => "test" 
            ]
        );
        $respons = $this->getResponseResult($request);

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertTrue(isset($respons['token']));
    }

    /** @test */
    public function user_should_not_be_exist(): void
    {
        $request = $this->createRequest(
            'PUT',
            '/api/v1/user/generate-token', 
            [
                "username" => "fasdfaspau",
                "password" => "test" 
            ]
        );
        $respons = $this->getResponseResult($request);

        $this->assertEquals(401, $request->getStatusCode());
        $this->assertTrue(isset($respons['error-message']));
    }

    /** @test */
    public function password_should_not_be_match(): void
    {
        $request = $this->createRequest(
            'PUT',
            '/api/v1/user/generate-token', 
            [
                "username" => "pau",
                "password" => "fakepassword" 
            ]
        );
        $respons = $this->getResponseResult($request);

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertTrue(isset($respons['error-message']));
    }
}
