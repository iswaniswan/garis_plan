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
    <h1 class="">Facilities settings</h1>
</div>
<div id="facility_wrapper">
    <div class="card" id="facility_content">
        <div class="card-header">
            <h4 id="table_title">List Facility</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tabledt">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Condition</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($fa as $r){
                            ?>
                            <tr>
                                <td class="align-middle"><?= $i; ?></td>
                                <td class="align-middle"><?= $r['name']; ?></td>
                                <?php 
                                $class = 'badge badge-success';
                                if($r['condition'] == 'bad'){
                                    $class = 'badge badge-warning';
                                }
                                ?>
                                <td class="align-middle">
                                    <div class="<?= $class; ?>">
                                        <?= $r['condition']; ?>
                                    </div>
                                </td>
                                <td class="align-middle"><?= $r['note']; ?></td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-secondary" name="view" id="<?= $r['id']; ?>" onclick="actionFacility(this);">detail</a>
                                    <a href="#" class="btn btn-info" name="edit" id="<?= $r['id']; ?>" onclick="actionFacility(this);">edit</a>
                                    <a href="#" class="btn btn-danger" name="delete" id="<?= $r['id']; ?>" onclick="actionFacility(this);">delete</a>
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

async function actionFacility(e){
    console.log(e);
    let params = {
        mode : $(e).attr('name'),
        id: $(e).attr('id')
    }   
    let form; 
    if(params.mode === 'add'){
        form = await new Components().formAddFacility(params);
    }else{
        form = await new Components().formFacility(params);
    }
    // console.log("actionFacility -> form", form)
    
    $('#facility_content').fadeOut('fast');
    $('#facility_wrapper').append(form);
    $('#form_facility').fadeIn('slow');
    
}

function removeForm(){
    // $('#form_facility').remove();
    $('a[name="settings-data-facilities"]').trigger('click');
}


$(document).ready(function(){
    $("#tabledt").dataTable();
});

</script>