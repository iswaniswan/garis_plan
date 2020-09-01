<?php 

class Meeting {

    protected $CI;

    public $MEETING;
    public $id;
    public $date_start;
    public $date_end;
    public $title;
    public $type;
    public $note;
    public $participant;
    public $updated_date;
    public $updated_by;
    public $is_deleted;

    public function __construct(){
        $this->CI =& get_instance();
    }

    public function setMeeting($meeting){
        $this->id = (empty($meeting['id']) || $meeting['id'] == null ? '' : $meeting['id'] ) ;
        $this->date_start = $meeting['date_start'];
        $this->date_end = $meeting['date_end'];
        $this->title = $meeting['title'];
        $this->type = $meeting['type'];
        $this->note = $meeting['note'];
        $this->participant = $meeting['participant'];
        $this->updated_date = (empty($meeting['updated_date']) || $meeting['updated_date'] == null ? '' : $meeting['updated_date'] ) ;
        $this->updated_by = $meeting['updated_by'];
        $this->is_deleted = (empty($meeting['is_deleted']) || $meeting['is_deleted'] == null ? 0 : $meeting['is_deleted'] ) ;
    }

    public function getMeeting(){        
        $meeting['id'] = $this->id;
        $meeting['date_start'] = $this->date_start;
        $meeting['date_end'] = $this->date_end;
        $meeting['title'] = $this->title;
        $meeting['type'] = $this->type;
        $meeting['note'] = $this->note;
        $meeting['participant'] = $this->participant;
        $meeting['updated_date'] = $this->updated_date;
        $meeting['updated_by'] = $this->updated_by;
        $meeting['is_deleted'] = $this->is_deleted;

        return $meeting;
    }

}

?>
