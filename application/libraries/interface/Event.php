<?php 

class Event {

    public $event;
    public $id;
    public $date_start;
    public $date_end;
    public $title;
    public $type;
    public $note;
    public $participant;
    public $room_id;
    public $branch;
    public $updated_date;
    public $updated_by;
    public $is_deleted;

    public function setEvent($event){
        $this->id = (empty($event['id']) || $event['id'] == null ? '' : $event['id'] ) ;
        $this->date_start = $event['date_start'];
        $this->date_end = $event['date_end'];
        $this->title = $event['title'];
        $this->type = $event['type'];
        $this->note = $event['note'];
        $this->participant = $event['participant'];
        $this->room_id = (empty($event['room_id']) || $event['room_id'] == null ? '' : $event['room_id']);
        $this->branch = (empty($event['branch']) || $event['branch'] == null ? '' : $event['branch']);
        $this->updated_date = (empty($event['updated_date']) || $event['updated_date'] == null ? '' : $event['updated_date'] ) ;
        $this->updated_by = $event['updated_by'];
        $this->is_deleted = (empty($event['is_deleted']) || $event['is_deleted'] == null ? 0 : $event['is_deleted'] ) ;
    }

    public function getEvent(){        
        $event['id'] = $this->id;
        $event['date_start'] = $this->date_start;
        $event['date_end'] = $this->date_end;
        $event['title'] = $this->title;
        $event['type'] = $this->type;
        $event['note'] = $this->note;
        $event['participant'] = $this->participant;
        $event['room_id'] = $this->room_id;
        $event['branch'] = $this->branch;
        $event['updated_date'] = $this->updated_date;
        $event['updated_by'] = $this->updated_by;
        $event['is_deleted'] = $this->is_deleted;

        return $event;
    }

}

?>
