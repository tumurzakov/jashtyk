<?php 
class CreateGroupShell extends Shell {
    var $uses = array('Group');

    function main() {
        App::import('Component','Acl');
        App::import('Component','Auth');
        $this->Auth = new AuthComponent(null);
        $this->Acl = new AclComponent(null);

        $this->out('Create Group:');

        $this->out('Existing groups:');
        $list = $this->Group->find('all');
        foreach($list as $entry) {
            $this->out(" " . $entry['Group']['id'] . "\t" . $entry['Group']['name']);
        }
        $this->hr();

        while (empty($name)) {
            $name = $this->in('Groupname:');
            if (empty($name)) $this->out('Groupname must not be empty!');
        }

        // we got all the data, let's create the user        
        $this->Group->create();
        if ($this->Group->save(array('name' => $name))) {
            $this->out('Admin Group created successfully!');
        } else {
            $this->out('ERROR while creating the Admin Group!!!');
        }

        $isAdmin = $this->in("Allow this group to be an admin group [y/n]");
        if ($isAdmin == "y") {
            $group = $this->Group->read();
            $this->Acl->allow($group, 'controllers');
        }
    }
}
?>
