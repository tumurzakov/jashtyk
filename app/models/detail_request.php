<?php
class DetailRequest extends AppModel {
    var $validate = array(
        'ip'=>array(
            'rule'=>'/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', 
            'message'=>'Enter a valid IP address'),
        );

    function setStatus($id, $status, $params = null) {
        $request = $this->read(null, $id);
        if ($request) {
            $fields = array('status'=>$status);
            if ($status == 'processing') $fields['started'] = strftime('%Y-%m-%d %H:%M:%S');
            if ($status == 'completed') $fields['completed'] = strftime('%Y-%m-%d %H:%M:%S');
            if ($params != null) $fields = array_merge($fields, $params);
            $this->set($fields);
            $this->save();
            return true;
        }
        return false;
    }

    function getCountByStatus($status) {
        return $this->find('count', array('conditions'=>array('status'=>$status)));
    }

    function getFirstAccepted() {
        $list = $this->find('all', array(
            'conditions'=>array('status'=>'accepted'), 
            'order'=>'created',
            'limit'=>1));
        if ($list) {
            return $list[0];
        }
        return;
    }

    function checkIfCanceled($id) {
        $request = $this->findById($id);
        if ($request) return $request['DetailRequest']['status'] == 'canceling';
        throw new Exception('DetailRequest not found');
    }
}
?>
