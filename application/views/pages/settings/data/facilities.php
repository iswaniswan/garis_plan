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
    <h1 class="">Facilities</h1>
</div>
<div class="card">
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
                                <a href="#" class="btn btn-secondary">detail</a>
                                <a href="#" class="btn btn-info">edit</a>
                                <a href="#" class="btn btn-danger">delete</a>
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

<script type="text/javascript">

$(document).ready(function(){
    $("#tabledt").dataTable();
});

</script>