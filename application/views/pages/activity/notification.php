<!-- override css -->
<style>
    tbody tr.unread {
        font-weight:800 !important;
    }
</style>
<!--  -->
<div class="section-header" id="section-notification">
    <h1 class="">Notification</h1>
</div>

<div id="notification_wrapper">
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
                        if($notification){
                        $i = 1;
                        foreach ($notification as $n){
                            ?>
                            <tr class="<?= $n['is_read'] == 0 ? 'unread' : ''; ?>">
                                <td class="align-middle"><?= $i; ?></td>
                                <td class="align-middle">
                                    <?php
                                    $date = date_create_from_format('Y-m-d H:i:s', $n['updated_date']);
                                    echo $date->format('d M y H:i');;
                                    ?>
                                </td>
                                <td class="align-middle"><?= $n['title']; ?></td>
                                <td class="align-middle">
                                    <?php
                                        $user_sender = (isset($n['sender']) ? $n['sender'] : $n['user_id'] ); 
                                        echo strToUpper($user_sender); 
                                    ?>
                                </td>
                                <td class="align-middle">
                                    <?php 
                                        $is_read_icon = ($n['is_read'] == 0 ? 'far fa-envelope' : 'far fa-envelope-open');
                                    ?>
                                    <a href="#" class="<?= $n['is_read'] == 0 ? 'btn btn-success' : 'btn btn-light'; ?>" is_read="<?= $n['is_read']; ?>" name="view" id="<?= $n['id']; ?>" onclick="actionNotification(this);">
                                        <i class="<?= $is_read_icon; ?>"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
async function actionNotification(e){
    const id = $(e).attr('id');
    let is_read = $(e).attr('is_read');
    let form = await new Components().notification_form(id);

    if(is_read == 0){
        // set notif has read
        api_NotificationHasRead(id);
    }

    $('#notification_wrapper')
        .empty()
        .append(form);
    $(form).toggleButton();
}



$(document).ready(function(){
    $('#tabledt').dataTable();
});

(function($){



}(jQuery))

</script>