<div class="section-header">
    <h1 class="">Activity</h1>
</div>
<div id="room_wrapper">
    <div class="card" id="room_activity">
        <div class="card-header">
            <h4>Room reservation
                <span class="badge badge-info ml-3"><?= count($room); ?></span>
            </h4>
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
                                    <a href="#" class="btn-action btn btn-secondary" name="view" id="<?= $r['event_id']; ?>" >view</a>
                                    <a href="#" class="btn-action btn btn-info" name="edit" id="<?= $r['event_id']; ?>" >edit</a>
                                    <a href="#" class="btn-action btn btn-danger" name="delete" id="<?= $r['event_id']; ?>" >delete</a>
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

<script type="text/javascript" src="assets/js/components/room_reservation/base.js"></script>

<script type="module" defer>
    import { FormRoom } from "/assets/js/components/room_reservation/formRoom.js"
    import { Api } from "/assets/js/modules/api.js"
    
    $(document).ready(function(){
        $('#tabledt').dataTable();

        $('body').on('click', '.btn-action', function(){
            let btn = $(this);
            let params = {
                id: btn.attr('id'),
                mode: btn.attr('name')
            }

            actionRoom(params)
        })
    })


    async function actionRoom(params){

        if(params.mode === 'delete'){
            const modal = await new Components().modalConfirmDeleteReservation(params);
            return false;
        }

        const data = await new Api().activityRoomReservationTableGetRoom(params);
        if(data){
            const form = await new FormRoom(data, params.mode).render();
            $('#room_wrapper').empty().append(form);
            $('select[name="participant"]').select2();
        }   
        
    }

</script>