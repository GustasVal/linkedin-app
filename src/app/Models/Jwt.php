<?php


namespace App\Models;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class Jwt
{
    public function generateJwt(string $sessionId): string
    {
        $time = time();

        $signer = new Sha256();

        $token = (new Builder())->issuedBy(env('APP_URL'))
            ->issuedAt($time)
            ->canOnlyBeUsedAfter($time + 10)
            ->expiresAt($time + 3600)
            ->withClaim('sessionId', $sessionId)
            ->getToken($signer, new Key('testing'));

        return (string)$token;
    }

    public function retrieveSessionId(string $jwt): string
    {
        $token = (new Parser())->parse((string) $jwt);

        return $token->getClaim('sessionId');
    }
}
