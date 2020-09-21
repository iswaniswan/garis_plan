<style>
    .section .section-title .holiday:before{
        color: #DC3543!important;
    }
</style>
<div class="section-header">
    <h1 class="">Activity</h1>
</div>
<div class="row">
    <div class="col-12 mx-auto">
        <div class="card-columns">
            <?php 
                $global_count;
                $utils = new Utils();
                foreach($event as $r){
                    if($r['type'] == 'global') {
                        $global_count = $r['event_count']; 
                        continue;
                    }
                    $color = $this->utils->random_color();
                    ?>
                    <div class="card" style="border-top:2px solid <?= $color; ?>">
                        <div class="card-header">
                            <h4 id=""><?= $r['type']; ?></h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary">
                                    <?= $r['event_count']; ?>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="">
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>  
        </div>

        <div class="mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <h2 class="section-title text-primary">Global</h2> 
                        <p class="section-lead">Currently has 
                            <strong><?= $global_count; ?></strong> events registered as national holidays in <?= date('Y'); ?></p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap mb-5">
                        <?php 
                            $object;
                            $i=0;
                            foreach($holiday as $h){
                                $id = 'c' . $h['id'];
                                $date_start = DateTime::createFromFormat('Y-m-d H:i:s', $h['date_start'] );
                                $date_end = DateTime::createFromFormat('Y-m-d H:i:s', $h['date_end'] );
                                $title = $h['title'];
                                $note = $h['note'];
                                $dateStr = ($date_start != $date_end ? $date_start->format('d M Y') . ' - ' . $date_end->format('d M Y') : $date_start->format('d M Y'));
                                ?>
                                <button class="btn btn-primary m-1" type="button" data-toggle="collapse" data-target="#<?= $id; ?>" aria-expanded="true" aria-controls="<?= $id; ?>" onclick="collapseMe(this);">
                                    <?= $dateStr; ?>
                                </button>
                                <?php
                                $object[$i]['id'] = $id;
                                $object[$i]['title'] = $title;
                                $object[$i]['content'] = $note;
                                $i++;
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
            <?php 
                foreach($object as $h){
                            ?>
                            <div class="col-4 collapse" id="<?= $h['id']; ?>">
                                <div class="card card-danger">
                                    <div class="card-header" style="padding-left:42px;">
                                        <h4 class="section-title text-danger"><?= $h['title']; ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="section-lead text-dark"><?= $h['content']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php    
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function collapseMe(e){
    let target = $(e).attr('data-target');
    console.log("collapseMe -> target", target)
    $('.collapse').each(function(){
        if($(this).attr('id') != $(target).attr('id')){
            $(this).removeClass('show');
        }
    });
}

$(document).ready(function(){
    
});

</script>