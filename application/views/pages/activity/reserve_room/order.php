<!-- override css -->
<style>
    #select_room {
        background-position-x: 95%;
    }
    input.invalid, .select2-selection.invalid{
        border-color: #dc3545 !important;
        padding-right: calc(1.5em + .75rem);
        background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E);
        background-repeat: no-repeat;
        background-position: center right calc(.375em + .1875rem);
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
</style>

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
                <form action="Home/reserve_room_submit" methods="POST" class="needs-validation" novalidate="">
                    <div class="section-title mt-0">Room</div>
                    <!-- room select -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label>choose room</label>
                                <select class="form-control select2" id="select_room" required="" >
                                    <option></option>
                                    <?php 
                                        for($i=0; $i<count($room); $i++){
                                            ?>
                                            <option value="<?= $room[$i]['id']; ?>" 
                                                cp_facilities="<?= $room[$i]['facilities']; ?>"
                                                cp_capacity="<?= $room[$i]['capacity']; ?>"
                                                cp_location="<?= $room[$i]['location']; ?>"
                                                >
                                                <?= $room[$i]['name']; ?>
                                            </option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">no room selected</div>
                            </div>

                            <div class="col-6">
                                <div class="card card-primary" id="room_info" style="display:none;">
                                    <div class="card-header">
                                        <h4>Room info</h4>
                                        <div class="card-header-action">
                                            <a class="btn btn-icon btn-danger" href="#" onClick="hideCard()"><i class="fas fa-times"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- date time -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label>Date</label>
                                <input type="text" class="form-control datetimepicker">
                                <div class="invalid-feedback">title cannot be empty</div>
                            </div>
                            <div class="col-3">
                                <label>Start time</label>
                                <input type="text" class="form-control timepicker" name="time_start" required="">
                                <div class="invalid-feedback">duration zero</div>
                            </div>
                            <div class="col-3">
                                <label>End time</label>
                                <input type="text" class="form-control timepicker" name="time_end" required="">
                                <div class="invalid-feedback">duration zero</div>
                            </div>
                        </div>
                    </div>
                    <!-- event title -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Event title</label>
                                <input type="text" class="form-control" name="title" required="">
                                <div class="invalid-feedback">title cannot be empty</div>
                            </div>
                        </div>
                    </div>
                    <!-- description -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Description</label>
                                <textarea name="description" rows="3" class="form-control" style="min-height:96px;" required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- participant -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Add participant</label>
                                <select class="select2 form-control" name="participant" multiple="" required="" id="user-selection">
                                    <option value="1">user 1</option>
                                </select>
                                <div class="invalid-feedback">check capacity</div>
                            </div>
                        </div>
                    </div>
                    <!-- submit -->
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary mb-2" name="submit">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function hideCard(){
    $('#room_info').hide('slow', function(){
        $(this).find('.card-body').html('');
    });
}

function totalHours(){
    let startTime = moment($('input[name="time_start"]').val(), "HH:mm");
    let endTime = moment($('input[name="time_end"]').val(), "HH:mm");
    let duration = moment.duration(endTime.diff(startTime));  
    return duration;
}

function isTimeValid(element, duration){
    let errElement = element.siblings('.invalid-feedback');
    let btnSubmit = $('button[name="submit"]');
    if(duration <= 0){
        element.addClass('invalid');
        errElement.show('fast');
        btnSubmit.prop('disabled', true);
    }else{
        element.removeClass('invalid');
        errElement.hide('fast');
        btnSubmit.prop('disabled', false);
    }
}

function getCapacity(){
    c = $('#select_room').find(":selected").attr("cp_capacity");
    return c;
}

function isParticipantValid(element){
    var capacity = getCapacity();
    let participant = element.select2('data').length;
    let element2 = $('span.select2-selection');
    let errElement = element.siblings('.invalid-feedback');
    let btnSubmit = $('button[name="submit"]');
    console.log("participat : " + participant + " capacity : " + capacity);
    if(participant > capacity){
        element2.addClass('invalid');
        errElement.show('fast');
        btnSubmit.prop('disabled', true);
    }else{
        element2.removeClass('invalid');
        errElement.hide('fast');
        btnSubmit.prop('disabled', false);
    }
}

async function getUser(){
    const dt_json = await fetchUserHris();
    const users = dt_json.data;

    const cmp_user_list = users.map((user, index) =>{
        return `<option value="${user.NIK}">${user.Nama.toLowerCase()}</option>`
    }).join('');
    $('#user-selection').html(cmp_user_list);
}

$(document).ready(function(){
    getUser();
    /**
     * 
     * form parameters
     * 
     */
    let dateStart = moment();
    let date_start, date_end;

    $('.datetimepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
        timePicker: false,
        timePicker24Hour: false,
        minDate: dateStart.format('YYYY-MM-DD'),
    }, function(start, end){
        console.log("start : " + start.format('MMMM D, YYYY') + ", end : " + end.format('MMMM D, YYYY') );
    });

    $('input[name="time_start"]').timepicker({
        showMeridian:false,
        defaultTime:'8',
        icons: {
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down'
        }
    }).on('change', function(time){
        let duration = totalHours();
        isTimeValid($(this), duration);
    });

    $('input[name="time_end"]').timepicker({
        showMeridian:false,
        defaultTime:'18',
        icons: {
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down'
        }
    }).on('change', function(time){
        let duration = totalHours();
        isTimeValid($(this), duration);
    });

    $('.select2').select2().on('select2:close', function() {
        isParticipantValid($(this));
    });

    $('#select_room').on('change', function() {
        let value = $(this).find(':selected').val();
        console.log("value : " + value);
        if(value !== ''){
            let facilities = $(this).find(":selected").attr("cp_facilities");
            let capacity = $(this).find(":selected").attr("cp_capacity");
            let location = $(this).find(":selected").attr("cp_location");
            let room_info = '<p>Facilities : ' + facilities + '<br/>Capacity : ' + capacity + '<br/>Location : ' + location + '</p>';
            $('#room_info').show('slow', function(){
                $(this).find('.card-body').html(room_info); 
            });
        }else{
            hideCard();
        }
    });

    // form validation
    $(".needs-validation").submit(function() {
        var form = $(this);
        if (form[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        }
        form.addClass('was-validated');
    });

});
</script>