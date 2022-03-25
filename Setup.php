<?php

namespace alexkar598\babxenforo;

use XF\AddOn\StepResult;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;

class Setup extends \XF\AddOn\AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUninstallTrait;

    const TABLE_CONNECTED_ACCOUNT_PROVIDER = 'xf_connected_account_provider';
    const TABLE_USER_CONNECTED_ACCOUNT = 'xf_user_connected_account';
    const PROVIDER_ID = 'BAB';
    const PROVIDER_CLASS = 'alexkar598\\babxenforo:Provider\\BAB';
    const PROVIDER_DISPLAY_ORDER = '500';

    public function installStep1()
    {
        $this
            ->db()
            ->insert(
                self::TABLE_CONNECTED_ACCOUNT_PROVIDER,
                array(
                    'provider_id' => self::PROVIDER_ID,
                    'provider_class' => self::PROVIDER_CLASS,
                    'display_order' => self::PROVIDER_DISPLAY_ORDER,
                    'options' => ''
                )
            );
    }

    public function upgrade(array $stepParams = []) {}

    public function uninstallStep1()
    {
        $this
            ->db()
            ->delete(
                self::TABLE_CONNECTED_ACCOUNT_PROVIDER,
                'provider_id = \'' . self::PROVIDER_ID . '\''
            );
    }

    public function uninstallStep2()
    {
        $this
            ->db()
            ->delete(
                self::TABLE_USER_CONNECTED_ACCOUNT,
                'provider_key = \'' . self::PROVIDER_ID . '\''
            );
    }
}