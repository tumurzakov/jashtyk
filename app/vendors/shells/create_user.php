<?php 
class CreateUserShell extends Shell {
    var $uses = array('User', 'Group');

    function main() {
        App::import('Component','Auth');
        $this->Auth = new AuthComponent(null);

        $this->out('Create User:');
        $this->hr();

        while (empty($username)) {
            $username = $this->in('Username:');
            if (empty($username)) $this->out('Username must not be empty!');
        }

        while (empty($pwd)) {
            $pwd = $this->in('Password:');
            if (empty($pwd)) {
                $this->out('Password must not be empty!');
                $pwd = NULL;
            }
        }

        while (empty($group)) {
            $this->out('Existing groups:');
            $list = $this->Group->find('all');
            foreach($list as $entry) {
                $this->out(" " . $entry['Group']['id'] . "\t" . $entry['Group']['name']);
            }

            $groupId = $this->in('Enter group id:');

            $group = $this->Group->findById($groupId);
            if (!$group) {
                $this->out("Group not found, create it first");
                $group = NULL;
            }
        }

        $this->User->create();
        if ($this->User->save(array(
            'username' => $username, 
            'password' => $this->Auth->password($pwd),
            'group_id' => $group['Group']['id']
            ))) {
            $this->out('User created successfully!');
        } else {
            $this->out('ERROR while creating the User!!!');
        }
    }
}
?>
