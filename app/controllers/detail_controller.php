<?php
class DetailController extends AppController {
    var $uses = array('DetailRequest');
    var $helpers = array("Html", "Form");

    function index() {
        if (!empty($this->data)) {
            if (empty($this->data['DetailRequest']['ip'])) {
                $this->DetailRequest->invalidate('ip', __('IP address must not be empty', true));
            } else if (!preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $this->data['DetailRequest']['ip'])) {
                $this->DetailRequest->invalidate('ip', __('Enter a valid IP address', true));
            } else if ($this->data['DetailRequest']['from'] === $this->data['DetailRequest']['to']) {
                $this->DetailRequest->invalidate('from', __('Period must be at least one day long', true));
            } else {
                $this->DetailRequest->save($this->data);
            }
        }

        $this->paginate = array( 
            'limit' => 10,
            'order' => array('created' => 'desc')
        );
        $this->set("requests", $this->paginate('DetailRequest'));
    }

    function cancel($id = null) {
        if ($id != null && $this->DetailRequest->setStatus($id, 'canceled')) {
            $this->redirect(array('action'=>'index'));
        }
        $this->cakeError('error404', array('code'=>404));
    }

    function view($id = null) {
        if ($id && $request = $this->DetailRequest->findById($id)) {
            $this->set('request', $request);
        } else {
            $this->cakeError('error404', array('code'=>404));
        }
    }
}
?>
