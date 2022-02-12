<?php

namespace OCA\CustomProperties\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;
use OCP\IGroupManager;
use OCP\IConfig;
use OCP\IUserSession;
class PersonalSettings implements ISettings
{
    /** @var IConfig */
	private $config;

    /** @var IGroupManager */
	private $groupManager;

    /** @var IUserSession */
	private $userSession;
    public function __construct(IGroupManager $groupManager,IConfig $config, IUserSession $userSession){
		
        $this->userSession = $userSession;
		$this->config = $config;
		$this->groupManager = $groupManager;        
        
    }
    public function getForm()
    {
        if ($this->userSession->getUser() !== null ){

            $uid = $this->userSession->getUser()->getUID();

            if($this->groupManager->isInGroup($uid,$this->config->getSystemValue('DMSAdminGroup', 'VIM-AEC-WMT-US-ADMIN'))){
                return new TemplateResponse('customproperties', 'settings/personal');
            }

        }

        return new TemplateResponse('customproperties', 'settings/empty');
    }

    /**
     * @return string the section ID
     */
    public function getSection()
    {
        return 'sharing';
    }

    /**
     * @return int whether the form should be rather on the top or bottom of
     * the admin section. The forms are arranged in ascending order of the
     * priority values. It is required to return a value between 0 and 100.
     */
    public function getPriority()
    {
        return 90;
    }
}
