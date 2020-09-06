<?php 

class EventPassive {

    public $event;

    public $id;
    public $user_id;
    public $event_id;
    public $is_join;
    public $is_cancel;
    public $updated_date;

    public function setEvent($event){
        $this->id = (empty($event['id']) || $event['id'] == null ? '' : $event['id'] ) ;
        $this->user_id = $event['user_id'];
        $this->event_id = $event['event_id'];
        $this->is_join = (empty($event['is_join']) || $event['is_join'] == null ? 0 : $event['is_join'] );
        $this->is_cancel = (empty($event['is_cancel']) || $event['is_cancel'] == null ? 0 : $event['is_cancel']);
        $this->updated_date = (empty($event['updated_date']) || $event['updated_date'] == null ? '' : $event['updated_date'] ) ;
    }

    public function getEvent(){        
        $event['id'] = $this->id;
        $event['user_id'] = $this->user_id;
        $event['event_id'] = $this->event_id;
        $event['is_join'] = $this->is_join;
        $event['is_cancel'] = $this->is_cancel;
        $event['updated_date'] = $this->updated_date;

        return $event;
    }

}

?>
