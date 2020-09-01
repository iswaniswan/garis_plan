<?php 

class Event {

    private $date_start;
    private $date_end;
    private $celebration;
    private $type;
    private $note;

    public function setEvent($event){
        $this->date_start = $event['date_start'];
        $this->date_end = $event['date_end'];
        $this->celebration = $event['celebration'];
        $this->type = $event['type'];
        $this->note = $event['note'];
    }

    public function getEvent(){
        $event['date_start'] = $this->date_start;
        $event['date_end'] = $this->date_end;
        $event['celebration'] = $this->celebration;
        $event['type'] = $this->type;
        $event['note'] = $this->note;
        return $event;
    }

}

?>
