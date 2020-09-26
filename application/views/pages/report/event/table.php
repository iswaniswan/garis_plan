<style>
.printable {
    display: none;
}
.printable-no: {
    display: block;
}
@media print {
    .printable {
        display: block;
    }
    .printable-no {
        display: none;
    }
}
</style>
<div class="section-header">
    <h1 class="">Report</h1>
</div>
<div id="event_wrapper" class="printable-no">
            <div class="card" id="event_report">
                <div class="card-header">
                    <h4>Event
                        <span class="badge badge-info ml-3"><?= count($event); ?></span>
                    </h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-success" onclick="printMe('#event_report');">
                            <span class="fas fa-print" style="margin:unset;"></span>
                        </a>
                        <a href="#" class="btn btn-success" onclick="download();">
                            <span class="fas fa-download" style="margin:unset;"></span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tabledt">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($event as $r){
                                    ?>
                                    <tr>
                                        <td class="align-middle"><?= $i; ?></td>
                                        <td class="align-middle"><?= $r['title']; ?></td>
                                        <td class="align-middle">
                                            <?php 
                                            $start = DateTime::createFromFormat('Y-m-d H:i:s', $r['date_start']);
                                            echo $start->format('d M Y');
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            $end = DateTime::createFromFormat('Y-m-d H:i:s', $r['date_end']);
                                            echo $end->format('d M Y');
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php 
                                                $badge = ( $r['type'] == 'global' ? 'badge-danger' : ($r['type'] == 'private' ? 'badge-info' : ($r['type'] == 'group' ? 'badge-success' : 'badge-warning' )) );
                                                ?>
                                                <span class="badge <?= $badge; ?>"><?= $r['type']; ?></span>
                                                <?php
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <a href="#" class="btn btn-secondary" name="view" id="<?= $r['id']; ?>" onclick="actionEvent(this);">view</a>
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
<div class="printable"></div>

<script type="text/javascript">

function removeForm(){
    $('a[name="activity-event-table"]').trigger('click');
}

async function actionEvent(e){
    const params = {
        id: $(e).attr('id'),
        mode: $(e).attr('name')
    }

    if(params.mode === 'delete'){
        const modal = await new Components().modalConfirmDeleteEvent(params);
        return false;
    }

    const data = await api_ActivityEventTableGetEvent(params);
    if(data){
        const form = await new Components().event_form(data, params.mode);
        $('#event_wrapper').empty().append(form);
        $('select[name="participant"]').select2();
    }  
    
}

async function submitDeleteEvent(e){
    const id = $(e).find('input[name="id"]').val();
    const data = await api_ActivityEventUpdateDelete(id);
    if(data.data == true){
        $('.modal').modal('hide');
        removeForm();
    } 
}

async function submitUpdateEvent(e){
    const date_start = moment($(e).find('input[name="start"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + " 00:00:00";
    const date_end = moment($(e).find('input[name="end"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + " 00:00:00";
    let type ;
    $(e).find('input[name="option"]').each(function(){
        if($(this).is(':checked')){
            type = $(this).val();
        }
    })

    let params = {
        id: $(e).find('input[name="id"]').val(),
        start: date_start ,
        end: date_end,
        title: $(e).find('input[name="title"]').val(),
        type: type.toLowerCase(),
        note: $(e).find('textarea[name="description"]').val() || '',
        participant: $(e).find('select[name="participant"]').val(),
        room_id: $(e).find('select[name="name"]').val() || null,
        branch: $(e).find('select[name="branch"]').val() || '',
    }
    console.log("submitUpdateEvent -> params", params)

    const result = await api_ActivityEventUpdate(params);

    if(result.data == true){
        let modal = await new Components().simpleModalSuccess();
        $('form').empty().append(modal);
        $('a[name="activity-event-table"]').trigger('click');
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
        removeForm();
    }
}

function orderEvent(){
    $('a[name="activity-event-order"]').trigger('click');
}

function printMe(el){
    const src = $(el);
    const box = $('.printable').empty();
    src.clone().appendTo(box);
    print();
}

$(document).ready(function(){
    $('#tabledt').dataTable();
})

</script>