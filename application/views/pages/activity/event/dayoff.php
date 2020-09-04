<!-- override css -->
<style>
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
    <h1 class="">Set Day Mark</h1>
</div>
<div class="row">
    <div class="col-8 mx-auto">
        <div class="card">
            <div class="card-header d-none">
                <h4></h4>
            </div>
            <div class="card-body">
                <form action="" methods="POST" class="needs-validation" novalidate="" onsubmit="event.preventDefault();">
                    <div class="section-title mt-0 text-primary mb-5">Add Event</div>
                    
                    <!-- date time -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label>Date start</label>
                                <input type="text" class="form-control datetimepicker" name="start">
                                <div class="invalid-feedback">check date</div>
                            </div>
                            <div class="col-6">
                                <label>Date end</label>
                                <input type="text" class="form-control datetimepicker" name="end">
                                <div class="invalid-feedback">check date</div>
                            </div>
                        </div>
                    </div>
                    <!-- event title -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Title</label>
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
                                <div class="invalid-feedback">description cannot be empty</div>
                            </div>
                        </div>
                    </div>
                    <!-- event type -->
                    <div class="form-group mb-3">
                        <div class="control-label" style="color:unset">Type</div>
                            <div class="custom-switches-stacked mt-2" required="">
                                <label class="custom-switch">
                                    <input type="radio" name="option" value="private" class="custom-switch-input" checked="">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Private <small>(Only you can see the event)</small></span>
                                </label>
                                <label class="custom-switch">
                                    <input type="radio" name="option" value="group" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Group <small>(Must have participant)</small></span>
                                </label>
                                <label class="custom-switch">
                                    <input type="radio" name="option" value="branch" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Branch <small>(All employees at certain branch)</small></span>
                                </label>
                                <label class="custom-switch">
                                    <input type="radio" name="option" value="global" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Global <small>(Nasional event)</small></span>
                                </label>
                            </div>
                            <div class="invalid-feedback">type cannot be empty</div>
                    </div>
                    <!-- participant -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Select branch</label>
                                <select class="select2 form-control" name="branch" required="" id="branch-selection" disabled>
                                    <option value=""></option>
                                    <option value="bandung">BANDUNG</option>
                                    <option value="jakarta">JAKARTA</option>
                                    <option value="purwakarta">PURWAKARTA</option>
                                    <option value="pasuruan">PASURUAN</option>
                                </select>
                                <div class="invalid-feedback">select branch</div>
                            </div>
                            
                            <div class="col-12">
                                <label>Add participant</label>
                                <select class="select2 form-control" name="participant" multiple="" required="" id="user-selection" disabled>
                                    <option value="1">user 1</option>
                                </select>
                                <div class="invalid-feedback">check user</div>
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

function totalDateLength(){
    let startDate = moment($('input[name="start"]').val(), "YYYY-MM-DD HH:mm:ss");
    let endDate = moment($('input[name="end"]').val(), "YYYY-MM-DD HH:mm:ss");
    let duration = moment.duration(endDate.diff(startDate));  
    console.log("totalDateLength -> duration", duration)
    
    return duration;
}

function isDateValid( element, duration){
    let changed = $('input[name="end"]').hasClass('changed');
    if(!changed) return false;

    let errElement = element.siblings('.invalid-feedback');
    let btnSubmit = $('button[name="submit"]');
    if(duration < 0){
        element.addClass('invalid');
        errElement.show('fast');
        btnSubmit.prop('disabled', true);
    }else{
        $('.datetimepicker').each(function(){
            $(this).removeClass('invalid');
        })
        $('.datetimepicker').siblings('.invalid-feedback').each(function(){
            $(this).hide('fast');
        })
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

async function setDayOff(params){

    const result = await fetchNewRoomReservation(params);
    if(result.data == true){
        let modal = await new Components().simpleModalSuccess();
        $('form').empty().append(modal);
        $('a[name="activity-event-dayoff"]').trigger('click');
    }
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

    $('.datetimepicker').each(function(){
        $(this).daterangepicker({
            locale: {format: 'YYYY-MM-DD'},
            singleDatePicker: true,
            timePicker: false,
            timePicker24Hour: false,
            minDate: dateStart.format('YYYY-MM-DD'),
        }).on('change', function(){
            let duration = totalDateLength();
            isDateValid($(this), duration);
        });
    })

    $('input[name="end"]').on('change', function(){
        $(this).addClass('changed');
        let duration = totalDateLength();
        isDateValid($(this), duration);
    })

    $('select[name="branch"]').select2();

    $('select[name="participant"]').select2().on('select2:close', function() {
    });

    $('input[name="option"]').each(function(index, value){
        $(this).brandOrParticipantIput();
    });

    // form validation
    $(".needs-validation").submit(function() {
        var form = $(this);
        if (form[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();

        }else{
            // extra validation
            let valid;

            let type;
            $('input[name="option"]').each(function(){
                return ( $(this).is(':checked') ? type = $(this).val() : '' );
            })

            valid = (type == '' || type == undefined ? false : true);
                    
            let branch;
            if(type === 'branch'){
                branch = $('select[name="branch"]').val();
                valid = (branch === '' || branch === undefined ? false : true);
            }

            if(type === 'group'){
                let group = $('select[name="participant"]').val();
                valid = (group.length <= 0 ? false : true);
            }

            if(valid){
                // build parameter
                let form = {
                    start: $(this).find('input[name="start"]').val() + ' 00:00:00',
                    end: $(this).find('input[name="end"]').val() + ' 00:00:00',
                    title: $(this).find('input[name="title"]').val(),
                    note: $(this).find('textarea[name="description"]').val() || '',
                    type: type,
                    branch: branch || '',
                    participant: $(this).find('select[name="participant"]').val(),
                }
                setDayOff(form);
            }else{
                console.log("invalid")
            }
        }
        form.addClass('was-validated');
    });

});

(function($){

    $.fn.brandOrParticipantIput = function(index, value){
        const select_branch = $('select[name="branch"]');
        const add_participant = $('select[name="participant"]')
        let category;
        $(this).attr('checked', false);

        $(this).on('change', function(){
            category = $(this).val();

            add_participant.prop('disabled', true);
            select_branch.prop('disabled', true);

            if(category == 'branch'){
                select_branch.prop('disabled', false);
            }
            if(category == 'group'){
                add_participant.prop('disabled', false);
            }

            $(this).attr('checked', true);

        });
    }

}(jQuery))

</script>