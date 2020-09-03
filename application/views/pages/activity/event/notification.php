<div class="section-header">
    <h1 class="">Notification</h1>
</div>

<div id="room_wrapper">
    <div class="card" id="notification_content">
        <div class="card-header">
            <h4 id="">Notification list</h4>
            <div class="card-header-action">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tabledt">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>From</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($notification as $n){
                            ?>
                            <tr>
                                <td class="align-middle"><?= $i; ?></td>
                                <td class="align-middle"><?= $n['updated_date']; ?></td>
                                <td class="align-middle"><?= $n['title']; ?></td>
                                <td class="align-middle">
                                    <?php
                                        $user_sender = (isset($n['sender']) ? $n['sender'] : $n['user_id'] ); 
                                        strToUpper($user_sender); 
                                    ?>
                                </td>
                                <td class="align-middle">
                                    <?php 
                                        $is_read_icon = ($n['is_read'] == 0 ? 'far fa-envelope' : 'far fa-envelope-open');
                                    ?>
                                    <a href="#" class="btn btn-secondary" name="view" id="<?= $n['id']; ?>" onclick="actionRoom(this);">
                                        <i class="<?= $is_read_icon; ?>"></i>
                                    </a>
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
$(document).ready(function(){

});
</script>