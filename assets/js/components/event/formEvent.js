import { TYPE_EVENT, BRANCH } from '../../settings.js'
import { Api } from '../../modules/api.js';

export class FormEvent {
    constructor(data, mode){
        this.mode = mode;
        this.data = data;
        this.TYPE_EVENT = TYPE_EVENT;
        this.BRANCH = BRANCH;
    } 

    async render(){
        // const room_id = (this.data.id != null || this.data.id != undefined ? true : false);
        // if(room_id){
            // console.log("return form room reservation")
            // return this.room_reservation_form(this.data, this.mode);
        // }

        const usersHris = await new Api().userHris();        
        const usersData = usersHris.data;

        const disabled = (this.mode === 'view' ? 'disabled' : '');
        const dateStart = moment(this.data.date_start, 'YYYY-MM-DD HH:mm:ss').format('DD MMM YYYY');
        const dateEnd = moment(this.data.date_end, 'YYYY-MM-DD HH:mm:ss').format('DD MMM YYYY');
        const participant = JSON.parse(this.data.participant);
        const form = `
            <div class="row">
                <div class="col-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-info" href="#" onClick="removeForm();"><i class="fas fa-times"></i> Back </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" methods="POST" class="needs-validation" novalidate="" onsubmit="event.preventDefault(); submitUpdateEvent(this);">
                                <div class="section-title mt-0 text-primary mb-5">${this.mode.toUpperCase()}</div>
                                
                                <input type="text" name="id" value="${this.data.event_id}" class="d-none">                                
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Date start</label>
                                            <input type="text" class="form-control datetimepicker" name="start" value="${dateStart}" ${disabled}>
                                            <div class="invalid-feedback">check date</div>
                                        </div>
                                        <div class="col-6">
                                            <label>Date end</label>
                                            <input type="text" class="form-control datetimepicker" name="end" value="${dateEnd}" ${disabled}>
                                            <div class="invalid-feedback">check date</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Title</label>
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
                                            <div class="invalid-feedback">description cannot be empty</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="control-label" style="color:unset">Type</div>
                                        <div class="custom-switches-stacked mt-2" required="">
                                            ${this.TYPE_EVENT.map(b=>{
                                                let checked = (b.toLowerCase() == this.data.type ? 'checked' : '');
                                                return `
                                                    <label class="custom-switch">
                                                        <input type="radio" name="option" value="${b}" class="custom-switch-input" ${checked} ${disabled}>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">${b}<small>(Only you can see the event)</small></span>
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
                                            <select class="select2 form-control" name="branch" required="" id="branch-selection" ${(this.data.type == 'branch' ? disabled: 'disabled')}>
                                                <option value="" name=""></option>
                                                ${this.BRANCH.map(b=>{
                                                    let selected = (b.toLowerCase() === this.data.branch ? 'selected' : '');
                                                    return `
                                                        <option value="${b}" ${selected}>${b.toUpperCase()}</option>
                                                    `;
                                                }).join('')}
                                            </select>
                                            <div class="invalid-feedback">select branch</div>
                                        </div>
                                        
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
                                    <button type="submit" class="btn btn-primary mb-2" name="submit">submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $(form).ready(function(){

        })

        return form;
    }

}