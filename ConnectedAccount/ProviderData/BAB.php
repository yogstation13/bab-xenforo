<?php

namespace alexkar598\babxenforo\ConnectedAccount\ProviderData;

class BAB extends \XF\ConnectedAccount\ProviderData\AbstractProviderData
{

    public function getDefaultEndpoint(): string
    {
        return '/auth/userinfo';
    }

    public function getProviderKey()
    {
        return $this->requestFromEndpoint('sub');
    }

    public function getUsername()
    {
        return $this->requestFromEndpoint('ckey');
    }

    public function getProfileLink()
    {
        return "https://www.byond.com/members/" . $this->getUsername();
    }
}