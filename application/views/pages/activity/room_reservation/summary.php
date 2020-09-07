<div class="section-header">
    <h1 class="">Rooms event</h1>
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
                                <a href="#" class="btn btn-primary">
                                    <?= $r['event_count']; ?>
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
