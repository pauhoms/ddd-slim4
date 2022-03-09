<?php

namespace App\Controllers\User\Create;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\Application\Create\GenerateAuthenticationToken;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use User\Domain\Exceptions\UserNotFound;
use User\Domain\Repositories\TokenRepository;
use User\Domain\Services\FindUserByName;

final class GenereteAuthenticationTokenController
{
    public function __construct(
        private TokenRepository $tokenRepository,
        private FindUserByName  $findUserByName
    )
    {}

    public function __invoke(Request $request, Response $response): Response
    {
        $body = $this->getBody($request);
        $service = new GenerateAuthenticationToken(
            $this->tokenRepository,
            $this->findUserByName
        );

        try {
            $json = [
                'token' => $service->__invoke(
                    $body['username'],
                    $body['password']
                ) 
            ];

            $response
                ->withStatus(200)
                ->getBody()->write(json_encode($json));
        } catch (PasswordDoesNotMatch $e) {
            $response->getBody()->write(json_encode([
                "error-message" => $e->getMessage()
            ]));

            $response = $response->withStatus(400);
        } catch (UserNotFound $e) {
            $response->getBody()->write(json_encode([
                "error-message" => $e->getMessage()
            ]));

            $response = $response->withStatus(401);
        }

        return $response
            ->withHeader('Content-type', 'application/json');
    }

    private function getBody(Request $request): array
    {
        $body = $request->getParsedBody();
        return $body === null ?
            json_decode($request->getBody()->getContents(), true) :
            $body;
    }
}
