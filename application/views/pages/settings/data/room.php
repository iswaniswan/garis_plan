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
    <h1 class="">ROOM</h1>
</div>
<div class="card">
    <div class="card-header">
        <h4 id="table_title">List Room</h4>
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
                            <td class="align-middle"><?= $r['location']; ?></td>
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