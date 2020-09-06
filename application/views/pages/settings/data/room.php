<!-- overriding css -->
<style>
.badge.badge-success {
    background-color: #63ed7a !important;
}
.badge {
    vertical-align: middle !important;
    padding: 7px 12px !important;
}
td a.hover {
    text-decoration: none !important;
}
</style>
<div class="section-header">
    <h1 class="">Room settings</h1>
</div>

<div id="room_wrapper">
    <div class="card" id="room_content">
        <div class="card-header">
            <h4 id="table_title">List Room</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="0" name="add" onclick="actionRoom(this);">
                Add room
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
                            <th>Capacity</th>
                            <th>Location</th>
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
                                <td class="align-middle"><?= $r['capacity']; ?></td>
                                <td class="align-middle"><?= strToUpper($r['location']); ?></td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-secondary" name="view" id="<?= $r['id']; ?>" onclick="actionRoom(this);">detail</a>
                                    <a href="#" class="btn btn-info" name="edit" id="<?= $r['id']; ?>" onclick="actionRoom(this);">edit</a>
                                    <a href="#" class="btn btn-danger" name="delete" id="<?= $r['id']; ?>" onclick="deleteRoom(this);">delete</a>
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

async function actionRoom(e){
    let params = {
        mode : $(e).attr('name'),
        id: $(e).attr('id')
    }   
    let form; 
    if(params.mode === 'add'){
        form = await new Components().formAddRoom(params);
    }else{
        form = await new Components().formRoom(params);
    }
    
    $('#room_content').fadeOut('fast');
    $('#room_wrapper').append(form);
    $('#form_room').fadeIn('slow');
    $('.select2').select2();
    
}

function deleteRoom(e){
    let params = {
        id: $(e).attr('id')
    }
    let modal = new Components().roomModal(params);    
}

function submitDeleteRoom(e){
    let payload = $(e).serialize();
    $.ajax({
        type: "POST",
        url: "settings/room_update_delete",
        data: payload,
        dataType: "json",
        success: function(response) {
            console.log(response);
        }
    }).done(function(){
        $('.modal').remove();
        $('.modal-backdrop').remove();
        $('a[name="settings-data-room"]').trigger('click');
    });
}

async function submitNewRoom(e){
    let is_available = ($(e).find('input[name="is_available"]').is(':checked') == true ? 1 : 0);

    let payload = {
        name: $(e).find('input[name="name"]').val(),
        capacity: $(e).find('input[name="capacity"]').val(),
        facilities: $(e).find('.select2').val(),
        branch: $(e).find('select[name="location"]').val(),
        floor: $(e).find('input[name="floor"]').val(),
        is_available: is_available,
    }
    const result = await api_NewRoom(payload);
    removeForm();
    
}

async function submitUpdateRoom(e){
    let is_available = ($(e).find('input[name="is_available"]').is(':checked') == true ? 1 : 0);

    let payload = {
        id: $(e).attr('id'),
        name: $(e).find('input[name="name"]').val(),
        capacity: $(e).find('input[name="capacity"]').val(),
        facilities: $(e).find('.select2').val(),
        branch: $(e).find('select[name="location"]').val(),
        floor: $(e).find('input[name="floor"]').val(),
        is_available: is_available,
    }
    const result = await api_UpdateRoom(payload);
    removeForm();    
}

function removeForm(){
    $('#form_room').remove();
    // $('#room_content').fadeIn('slow');
    $('a[name="settings-data-room"]').trigger('click');
}

$(document).ready(function(){
    $("#tabledt").dataTable();
    
});

(function($){
    
}(jQuery))

</script>