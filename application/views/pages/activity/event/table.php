<div class="section-header">
    <h1 class="">Event</h1>
</div>
<div class="row">
    <div class="col-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Event</h4>
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
                                            ?>
                                            <span class="badge <?= $badge; ?>"><?= $r['type']; ?></span>
                                            <?php
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <a href="#" class="btn btn-secondary" name="view" id="<?= $r['id']; ?>" onclick="actionRoom(this);">detail</a>
                                        <a href="#" class="btn btn-info" name="edit" id="<?= $r['id']; ?>" onclick="actionRoom(this);">endswitch</a>
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

<script type="text/javascript">
function orderEvent(){
    $('a[name="activity-event-order"]').trigger('click');
}

$(document).ready(function(){
    $('#tabledt').dataTable();
})

</script>