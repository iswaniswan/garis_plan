<div class="section-header">
    <h1 class="">Rooms event</h1>
</div>
<div id="room_wrapper">
    <div class="card" id="room_activity">
        <div class="card-header">
            <h4>List Room</h4>
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
                                    <a href="#" class="btn btn-secondary" name="view" id="<?= $r['id']; ?>" onclick="actionRoom(this);">detail</a>
                                    <a href="#" class="btn btn-info" name="edit" id="<?= $r['id']; ?>" onclick="actionRoom(this);">manage</a>
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

function orderRoom(){
    $('a[name="activity-room_reservation-order"]').trigger('click');
}

$(document).ready(function(){
    $('#tabledt').dataTable();
})

</script>