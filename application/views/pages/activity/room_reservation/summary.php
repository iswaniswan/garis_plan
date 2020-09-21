<div class="section-header">
    <h1 class="">Activity</h1>
</div>
<div class="row">
    <div class="col-12 mx-auto">
        <div class="card-columns">
            <?php 
                $utils = new Utils();
                foreach($room as $r){
                    $color = $this->utils->random_color();
                    ?>
                    <div class="card" style="border-top:2px solid <?= $color; ?>">
                        <div class="card-header">
                            <h4 id=""><?= $r['name']; ?></h4>
                            <div class="card-header-action">
                                <?php 
                                    $count = $r['event_count'];
                                    $class = ((int) $count >=1 ? 'btn-primary' : 'btn-secondary');
                                ?>
                                <a href="#" class="btn <?= $class; ?>">
                                    <?= $count; ?>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="">
                                <?= strToUpper($r['location']); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>

            
        </div>
    </div>
</div>
