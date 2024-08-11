<?php

namespace alexkar598\babxenforo\ConnectedAccount\Service;

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Http\Uri\UriInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Token\TokenInterface;
use OAuth\OAuth2\Token\StdOAuth2Token;

class BAB extends \OAuth\OAuth2\Service\AbstractService
{

    const SCOPE_OPENID        = 'openid';

    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient,
        TokenStorageInterface $storage,
        $scopes = array(),
        UriInterface $baseApiUri = null
    ) {
        parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri, true);

        if (null === $baseApiUri) {
            $this->baseApiUri = new Uri('https://bab.alexkar598.dev/');
        }
    }

    protected function parseAccessTokenResponse($responseBody)
    {
        $data = json_decode($responseBody, true);

        if (!is_array($data)) {
            throw new TokenResponseException('Unable to parse response.');
        } elseif (isset($data['error'])) {
            throw new TokenResponseException('Error in retrieving token: "' . "(" . $data['error'] . ")" . $data['error_description'] . '"');
        }

        $token = new StdOAuth2Token();
        $token->setAccessToken($data['access_token']);

        unset($data['access_token']);

        $token->setExtraParams($data);

        return $token;
    }

    public function getAuthorizationEndpoint(): Uri
    {
        return new Uri('https://bab.alexkar598.dev/auth/authorize');
    }

    public function getAccessTokenEndpoint(): Uri
    {
        return new Uri('https://bab.alexkar598.dev/auth/token');
    }

    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }
}