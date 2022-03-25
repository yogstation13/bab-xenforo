<?php

namespace alexkar598\babxenforo\ConnectedAccount\Provider;

use XF\Entity\ConnectedAccountProvider;

class BAB extends \XF\ConnectedAccount\Provider\AbstractProvider
{

    /**
     * @inheritDoc
     */
    public function getOAuthServiceName(): string
    {
        return 'alexkar598\babxenforo:Service\BAB';
    }

    public function getProviderDataClass(): string
    {
        return 'alexkar598\babxenforo:ProviderData\BAB';
    }

    public function getDefaultOptions()
    {
        return [
            'client_id' => '',
            'client_secret' => ''
        ];
    }

    public function getOAuthConfig(ConnectedAccountProvider $provider, $redirectUri = null)
    {
        return [
            'key' => $provider->options['client_id'],
            'secret' => $provider->options['client_secret'],
            'scopes' => ['openid'],
            'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
        ];
    }


}