<?php

namespace App\Controller\Component;

use App\Controller\AppController;
use App\Lib\CurrentUser;

/*
use App\Model\Table\VtigerGroupsTable;
use App\Model\Table\VtigerLoginhistoryTable;
use App\Model\Table\VtigerUsersTable;
*/

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use Cake\Utility\Security;

use Google\Authenticator\GoogleAuthenticator;

class TwoFactorAuthComponent extends Component
{
    public $data = [];

    /** @inheritdoc */
    public function initialize(array $config)
    {
        $controller = $this->_registry->getController();
        $this->_session = $controller->request->session();
        parent::initialize($config);
    }

    public function generateSecret()
    {
        $g = new GoogleAuthenticator();
        $secret = $g->generateSecret();
        $this->data['secret'] = $secret;

        return $secret;
    }
}