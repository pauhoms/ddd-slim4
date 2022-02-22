<?php

namespace Tests\User\Feature;

use Tests\Shared\FeatureTestCase;

final class GenerateAuthenticationTokenTest extends FeatureTestCase 
{
    /** @test */
    public function tokenShouldBeGenerated(): void
    {
        $request = $this->createRequest(
            'POST',
            '/api/v1/user/generate-token', 
            [
                "username" => "pauhoms",
                "password" => "paupassword" 
            ]
        );
        $respons = $this->getResponseResult($request);

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertTrue(isset($respons['token']));
    }
}
