<div class="section-header">
    <h1 class="">Reserve room</h1>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>New reservation</h4>
            </div>
            <div class="card-body">
                <form action="">
                
                <div class="section-title mt-0">Room</div>
                    <!-- room select -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label>choose room</label>
                                <select class="form-control">
                                    <option></option>
                                    <?php 
                                        for($i=0; $i<count($room); $i++){
                                            ?>
                                            <option value="<?= $room[$i]['id']; ?>" 
                                                cp_facilities="<?= $room[$i]['facilities']; ?>">
                                                <?= $room[$i]['name']; ?>
                                            </option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-6">
                                <fieldset disabled>
                                    <div class="form-group d-none">
                                        <input type="textarea" id="disabledTextInput" class="form-control" placeholder="info room">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <!-- date time -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label>Date</label>
                                <input type="text" class="form-control datetimepicker">
                            </div>
                            <div class="col-3">
                                <label>Start time</label>
                                <input type="text" class="form-control timepicker">
                            </div>
                            <div class="col-3">
                                <label>End time</label>
                                <input type="text" class="form-control timepicker">
                            </div>
                        </div>
                    </div>
                    <!-- event title -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Event title</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- description -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Description</label>
                                <textarea name="" id="" rows="3" class="form-control" style="min-height:96px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- participant -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Add participant</label>
                                <select class="form-control select2" multiple="">
                                    <option>user 1</option>
                                    <option>user 2</option>
                                    <option>user 3</option>
                                    <option>user 4</option>
                                    <option>user 5</option>
                                    <option>user 6</option>
                                    <option>user 7</option>
                                    <option>user 8</option>
                                    <option>user 9</option>
                                    <option>user 10</option>
                                    <option>user 11</option>
                                    <option>user 12</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- submit -->
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary mb-2">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $('.datetimepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
        timePicker: false,
        timePicker24Hour: false,
    });

    $('.timepicker').each(function(){
        $(this).timepicker({
            showMeridian:false,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down'
            }
        });
    });

    $('.select2').select2();

});
</script>