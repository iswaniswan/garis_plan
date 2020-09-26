<div class="section-header">
    <h1 class="">Activity</h1>
</div>
<div id="event_wrapper">
    <div class="row">
        <div class="col-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Event
                        <span class="badge badge-info ml-3"><?= count($event); ?></span>
                    </h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" onclick="orderEvent();">
                        Add new event
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
                                                $room = ( $r['room_id'] > 0 ? 'badge-primary' : '' );    
                                            ?>
                                                <span class="badge <?= $badge; ?>"><?= $r['type']; ?></span>
                                            <?php 
                                                if($room) { ?> <span class="badge <?= $room ?>">room</span> <?php }
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <a href="#" class="btn btn-secondary btn-action" name="view" id="<?= $r['id']; ?>" >view</a>
                                            <?php
                                                if($r['type'] != 'global') {
                                                    ?>
                                                        <a href="#" class="btn btn-info btn-action" name="edit" id="<?= $r['id']; ?>" >edit</a>
                                                        <a href="#" class="btn btn-danger btn-action" name="delete" id="<?= $r['id']; ?>" >delete</a>
                                                    <?php
                                                }
                                            ?>
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
    </div>
</div>

<script type="text/javascript" src="assets/js/components/event/base.js"></script>

<script type="module" defer>
import { FormRoom } from "/assets/js/components/room_reservation/formRoom.js"
import { FormEvent } from "/assets/js/components/event/formEvent.js"
import { Api } from "/assets/js/modules/api.js";
    
    $(document).ready(function(){
        $('#tabledt').dataTable();

        $('body').on('click', '.btn-action', function(){
            let btn = $(this);
            let params = {
                id: btn.attr('id'),
                mode: btn.attr('name')
            }

            actionEvent(params)
        })
    })

    async function actionEvent(params){
        if(params.mode === 'delete'){
            const modal = await new Components().modalConfirmDeleteEvent(params);
            return false;
        }

        const data = await new Api().activityEventTableGetEvent(params);        
        if(data){            
            const form = (data.id != null || data.id != undefined 
                ? await new FormRoom(data, params.mode).render()
                : await new FormEvent(data, params.mode).render()
            );
            $('#event_wrapper').empty().append(form);
            $('select[name="participant"]').select2();
        }        
    }

</script>