<?php
class AppController extends Controller {
    var $uses = array('Group', 'Config');
    var $helpers = array('Html', 'Javascript', 'Form', 'Session');
    var $components = array('Acl', 'Auth', 'Session', 'RequestHandler');
    var $publicControllers = array('pages');


    function beforeFilter(){
        #json
        $this->RequestHandler->setContent('json', 'text/x-json');

        if (isset($_REQUEST['debug_chart'])) {
            $this->RequestHandler->setContent('png', 'text/html');
        } else {
            $this->RequestHandler->setContent('png', 'image/png');
        }

        #auth
        if (isset($this->Auth)) {
            $this->Auth->userScope = array('User.disabled' => 0);
            $this->Auth->loginAction = '/users/login';
            $this->Auth->logoutAction = '/users/logout';
            $this->Auth->loginRedirect = '/';
            $this->Auth->authorize = 'actions';

            #cron
            if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
                $this->Auth->allow();
            }

            if (in_array(low($this->params['controller']), $this->publicControllers)) {
                $this->Auth->allow();
            }

            $this->set('AuthUser', $user = $this->Auth->user());
            if ($user) {
                $this->set('AuthGroup', $this->Group->findById($user['User']['group_id']));
            } else {
                if ($this->params['controller'] != 'users' && 
                    $this->params['action'] != 'login' &&
                    $this->params['action'] != 'logout') {
                    $this->redirect(array('controller'=>'users', 'action'=>'login'));
                }
            }
        }

        $this->set('currency', $this->Config->get('currency'));
    }

    function afterFilter() {
        $location = array('controller'=>$this->params['controller'], 'action'=>$this->params['action']);
        $location = array_merge($location, $this->params['pass']);
        $this->Session->write('last_location', $location);
    }
}
?>
