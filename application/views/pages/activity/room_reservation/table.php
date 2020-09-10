<div class="section-header">
    <h1 class="">Table</h1>
</div>
<div id="room_wrapper">
    <div class="card" id="room_activity">
        <div class="card-header">
            <h4></h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" onclick="orderRoom();">
                Add room activity
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tabledt">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($room as $r){
                            ?>
                            <tr>
                                <td class="align-middle"><?= $i; ?></td>
                                <td class="align-middle"><?= $r['name']; ?></td>
                                <td class="align-middle"><?= strToUpper($r['location']); ?></td>
                                <td class="align-middle"><?= strToUpper($r['title']); ?></td>
                                <td class="align-middle">
                                    <?php
                                        $date_end = ($r['date_end'] != null and !empty($r['date_end']) ? $r['date_end'] : false);
                                        if($date_end){
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $r['date_end']);
                                            echo $date->format('d M Y');
                                        }
                                    ?>
                                </td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-secondary" name="view" id="<?= $r['event_id']; ?>" onclick="actionRoom(this);">view</a>
                                    <a href="#" class="btn btn-info" name="edit" id="<?= $r['event_id']; ?>" onclick="actionRoom(this);">edit</a>
                                    <a href="#" class="btn btn-danger" name="delete" id="<?= $r['event_id']; ?>" onclick="actionRoom(this);">delete</a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

async function submitDeleteReservation(e){
    const id = $(e).find('input[name="id"]').val();
    const data = await api_ActivityRoomReservationUpdateDelete(id);
    if(data.data == true){
        $('.modal').modal('hide');
        removeForm();
    } 
}

async function submitUpdateReservation(e){
    const time_start = $(e).find('input[name="time_start"]').val();
    const time_end = $(e).find('input[name="time_end"]').val();
    const date_start = moment($(e).find('input[name="start"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + ' ' + time_start;
    const date_end = moment($(e).find('input[name="start"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + ' ' + time_end;
    let params = {
        id: $(e).find('input[name="id"]').val(),
        start: date_start ,
        end: date_end,
        title: $(e).find('input[name="title"]').val(),
        type: 'group',
        note: $(e).find('textarea[name="description"]').val() || '',
        participant: $(e).find('select[name="participant"]').val(),
        room_id: $(e).find('select[name="name"]').val(),
        branch: $(e).find('select[name="branch"]').val() || '',
    }

    const result = await api_ActivityRoomReservationUpdate(params);

    if(result.data == true){
        let modal = await new Components().simpleModalSuccess();
        $('form').empty().append(modal);
        $('a[name="activity-room_reservation-table"]').trigger('click');
    }
}

async function actionRoom(e){
    const params = {
        id: $(e).attr('id'),
        mode: $(e).attr('name')
    }

    if(params.mode === 'delete'){
        const modal = await new Components().modalConfirmDeleteReservation(params);
        return false;
    }

    const data = await api_ActivityRoomReservationTableGetRoom(params);
    if(data){
        const form = await new Components().room_reservation_form(data, params.mode);
        $('#room_wrapper').empty().append(form);
        $('select[name="participant"]').select2();
    }   
    
}

function removeForm(){
    $('a[name="activity-room_reservation-table"]').trigger('click');
}

function orderRoom(){
    $('a[name="activity-room_reservation-order"]').trigger('click');
}

$(document).ready(function(){
    $('#tabledt').dataTable();
})

</script>