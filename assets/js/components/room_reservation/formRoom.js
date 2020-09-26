import { TYPE_EVENT, BRANCH } from '../../settings.js'
import { Api } from '../../modules/api.js';

export class FormRoom {
    constructor(data, mode){
        this.mode = mode;
        this.data = data;
    }   
    
    async render(){
        const usersHris = await new Api().userHris();        
        const usersData = usersHris.data;
        const dt_room = await new Api().roomAll();
        const disabled = (this.mode === 'view' ? 'disabled' : '');
        const dateEvent = moment(this.data.date_start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD');
        const time_start = moment(this.data.date_start, 'YYYY-MM-DD HH:mm:ss').format('HH:mm');
        const time_end = moment(this.data.date_end, 'YYYY-MM-DD HH:mm:ss').format('HH:mm');
        const participant = JSON.parse(this.data.participant);
        const form = `
            <div class="row">
                <div class="col-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4> </h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-info" href="#" onClick="removeForm();"><i class="fas fa-times"></i> Back </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" methods="POST" class="needs-validation" novalidate="" onsubmit="event.preventDefault(); submitUpdateReservation(this);">
                                <div class="section-title mt-0 text-primary mb-5">${this.mode.toUpperCase()}</div>
                                
                                <input type="text" name="id" value="${this.data.event_id}" class="d-none">
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>choose room</label>
                                            <select class="form-control select2" id="select_room" name="name" required="" ${disabled}>
                                                ${dt_room.map(r=>{
                                                    let selected = (r === this.data.id ? 'selected' : '');
                                                    return `
                                                        <option cp_capacity="${r.capacity}" value="${r.id}" ${selected}>${r.name}</option>
                                                    `;
                                                }).join('')}
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
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Date</label>
                                            <input type="text" class="form-control datetimepicker" name="start" value="${dateEvent}" ${disabled}>
                                            <div class="invalid-feedback">title cannot be empty</div>
                                        </div>
                                        <div class="col-3">
                                            <label>Start time</label>
                                            <input type="text" class="form-control timepicker" name="time_start" required="" value="${time_start}" ${disabled}>
                                            <div class="invalid-feedback">duration zero</div>
                                        </div>
                                        <div class="col-3">
                                            <label>End time</label>
                                            <input type="text" class="form-control timepicker" name="time_end" required="" value="${time_end}" ${disabled}>
                                            <div class="invalid-feedback">duration zero</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Event title</label>
                                            <input type="text" class="form-control" name="title" required="" value="${this.data.title}" ${disabled}>
                                            <div class="invalid-feedback">title cannot be empty</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Description</label>
                                            <textarea name="description" rows="3" class="form-control" style="min-height:96px;" required="" ${disabled}>${this.data.note}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Add participant</label>
                                            <select class="select2 form-control" name="participant" multiple="" required="" id="user-selection" ${disabled}>
                                                ${usersData.map((u) => {
                                                    let selected = (participant.findIndex((t) => (t == u.NIK)) > -1 ? 'selected' : '' )                                                    
                                                    return `<option name="nik" value="${u.NIK}" ${selected}>${u.Nama}</option>`
                                                }).join('')}
                                            </select>
                                            <div class="invalid-feedback">check user</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-primary mb-2" name="submit" ${disabled}>submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;


        $(form).ready(function(){

            let dateStart = moment();

            $('.datetimepicker').daterangepicker({
                locale: {format: 'YYYY-MM-DD'},
                singleDatePicker: true,
                timePicker: false,
                timePicker24Hour: false,
                minDate: dateStart.format('YYYY-MM-DD'),
            }, function(start, end){
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

            // form validation
            $(".needs-validation").submit(function() {
                var form = $(this);
                if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }else{
                    roomReservationOrderSubmit(form);
                }
                form.addClass('was-validated');
            });

            $('#back').click(function(){
                back();
            })

        
        })

        return form;
    }

}

function back(){
    $('.modal').modal('hide');
}

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
    const c = $('#select_room').find(":selected").attr("cp_capacity");
    console.log("getCapacity -> c", c)
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

async function roomReservationOrderSubmit(e){
    const time_start = $(e).find('input[name="time_start"]').val();
    const time_end = $(e).find('input[name="time_end"]').val();
    const date_start = $(e).find('input[name="start"]').val() + ' ' + time_start;
    const date_end = $(e).find('input[name="start"]').val() + ' ' + time_end;
    let params = {
        start: date_start ,
        end: date_end,
        title: $(e).find('input[name="title"]').val(),
        type: 'group',
        note: $(e).find('textarea[name="description"]').val() || '',
        participant: $(e).find('select[name="participant"]').val(),
        room_id: $(e).find('select[name="name"]').val(),
    }

    const result = await new Api().roomReservationOrderSubmit(params);
    const msg = (
        result.data == true 
        ? `<div class="container text-center"><h5 class="text-success">Success! reservation has been added</h5></div>`
        : `<div class="container text-center"><h5 class="text-danger">Error occured, please reload page</h5></div>`
    );
    $('form').empty().append(msg);
    setTimeout(()=>{
        location.reload();
    }, 1500);
}