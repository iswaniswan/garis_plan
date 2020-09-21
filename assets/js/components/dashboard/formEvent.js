import { TYPE_EVENT, BRANCH } from '../../settings.js'
import { Api } from '../../modules/api.js';

export class FormEvent {
    constructor(params){
        this.date = params.date;
    }

    async render(){
        const participant = await new Api().userHris();
        const form = `
            <div class="row">
                <div class="col-12 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="section-title mt-0 text-primary mt-3">Add Event</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-info" href="#" id="back"><i class="fas fa-times"></i> Back </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" methods="POST" class="needs-validation" novalidate="" onsubmit="event.preventDefault();" >
                                <input type="text" name="id" value="" class="d-none">         
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Date start</label>
                                            <input type="text" class="form-control btn btn-success" name="start" value="${this.date}" disabled>
                                            <div class="invalid-feedback">check date</div>
                                        </div>
                                        <div class="col-6">
                                            <label>Date end</label>
                                            <input type="text" class="form-control datetimepicker" name="end" value="${this.date}">
                                            <div class="invalid-feedback">check date</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title" required="" value="">
                                            <div class="invalid-feedback">title cannot be empty</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Description</label>
                                            <textarea name="description" rows="3" class="form-control" style="min-height:96px;" required="" ></textarea>
                                            <div class="invalid-feedback">description cannot be empty</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="control-label" style="color:unset">Type</div>
                                        <div class="d-flex flex-wrap mt-2" required="">
                                            ${TYPE_EVENT.map(b=>{
                                                let select = (b.toLocaleLowerCase() == 'private' ? 'checked' : '');
                                                return `
                                                    <label class="ml-1 mr-2">
                                                        <input type="radio" name="option" value="${b.toLocaleLowerCase()}" class="custom-switch-input" ${select}>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">${b}</span>
                                                    </label>
                                                `;
                                            }).join('')}
                                        </div>
                                        <div class="invalid-feedback">type cannot be empty</div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label>Select branch</label>
                                            <select class="select2 form-control" name="branch" required="" id="branch-selection" disabled>
                                                <option value="" name=""></option>
                                                ${BRANCH.map(b=>{
                                                    return `
                                                        <option value="${b.toLocaleLowerCase()}">${b.toUpperCase()}</option>
                                                    `;
                                                }).join('')}
                                            </select>
                                            <div class="invalid-feedback">select branch</div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label>Add participant</label>
                                            <select class="select2 form-control" name="participant" multiple="" required="" id="user-selection" disabled>
                                                ${participant.data.map(p=>{
                                                    return `<option name="id" value="${p.NIK}">${p.Nama}</option>`;
                                                }).join('')}
                                            </select>
                                            <div class="invalid-feedback">check user</div>
                                        </div>
            
                                    </div>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-primary mb-2" name="submit">submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $(form).ready(function(){
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
        
            let select_branch = $('#branch-selection');
            let add_participant =  $('#user-selection');
            add_participant.select2();

            $('input[type="radio"]').each(function(index, value){
                
                $(this).on('change', function(){
                    let category;
                    $(this).attr('checked', false);
                    
                    category = $(this).val();
                    console.log("FormEvent -> render -> category", category)
        
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
            });

            // form validation
            $(".needs-validation").submit(function() {
                submitForm($(this));
            });

            $('#back').click(function(){
                back();
            });
        
        })

        return form;
    }

}

function back(){
    $('.modal').modal('hide');
}

function submitForm(el){
    var form = $(el);
    if (form[0].checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();

    }else{
        // extra validation
        let valid;
        let type;
        form.find('input[name="option"]').each(function(){
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
            let params = {
                start: form.find('input[name="start"]').val() + ' 00:00:00',
                end: form.find('input[name="end"]').val() + ' 00:00:00',
                title: form.find('input[name="title"]').val(),
                note: form.find('textarea[name="description"]').val() || '',
                type: type,
                branch: branch || '',
                participant: form.find('select[name="participant"]').val(),
            }
            eventDailySubmit(params);
        }else{
            console.log("invalid");
        }
    }
    form.addClass('was-validated');
}

async function eventDailySubmit(params){
    const result = await new Api().roomReservationOrderSubmit(params);
    const msg = (
        result.data == true 
        ? `<div class="container text-center"><h5 class="text-success">Success! Event has been added</h5></div>`
        : `<div class="container text-center"><h5 class="text-danger">Error occured, please reload page</h5></div>`
    );
    $('form').empty().append(msg);
    setTimeout(()=>{
        location.reload();
    }, 2000);
}