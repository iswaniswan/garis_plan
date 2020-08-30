class Components {

    // static properties
    BRANCH = ['bandung', 'jakarta', 'pasuruan', 'purwakarta'];

    constructor(){
        this.compId = this.generateId()
    }
    
    generateId = function(){
        return Math.random().toString().substr(2, 5);
    }

    simpleTableHris = function (data){
        const table = `
        <div class="card">
            <div class="card-header">
                <h4 class="text-warning">${data.title} 
                    <span class="ml-2 text-dark">(${moment(data.start, 'YYYY-MM-DD').format('D MMM YYYY')})</span>
                </h4>
                <div class="card-header-action">
                    <a class="btn btn-icon btn-info" href="#" onClick="calendarShow(this)"><i class="fas fa-times"></i> Back </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-detail-event">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>From</th>
                                <th>Until</th>
                                <th>Destination</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.extendedProps.map((e, i) => {
                                return `<tr>
                                    <td>${i+=1}</td>
                                    <td>${e.name}</td>
                                    <td>${e.department}</td>
                                    <td>${e.start}</td>
                                    <td>${e.end}</td>
                                    <td>${e.destination}</td>
                                </tr>`
                            }).join("")}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        `;
        return table;
    };

    simpleModal = function(data){
        const modal = `
            <div class="modal fade" tabindex="-1" role="dialog" id="" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title" id="">${data.title}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="">${data.description}
                        </div>
                    </div>
                </div>
            </div>
        `;
        $(modal).modal('show');
    }

    eventModal = function(data){
        let type = data.extendedProps[0].type;
        let color;
        if(type === 'nasional'){
            color = 'card-danger';
        }else if(type === 'company'){
            color ='card-warning';
        }else if(type === 'private'){
            color ='card-info';
        }else if(type === 'group'){
            color = 'card-success';
        }else{
            color = 'card-dark';
        }
        const modal = `
            <div class="modal fade" tabindex="-1" role="dialog" id="" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Event info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="">
                            <div class="card ${color}">
                                <div class="card-header">
                                    <h4 class="text-dark">${data.title}</h4>
                                </div>
                                <div class="card-body"><p>${data.description}</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $(modal).modal('show');
    }

    scheduleBoard = function(data){
        const board = `
            ${data.sort((a, b) => {
                return (moment(a, 'YYYY-MM-DD') - moment(b, 'YYYY-MM-DD') ? 1 : -1);
            }).map(item => {
                let mStart = moment(item.start, 'YYYY-MM-DD');
                let mEnd = moment(item.end, 'YYYY-MM-DD');
                let dtStr = (item.start === item.end ? 
                    mStart.format('D MMM YY') : mStart.format('D MMM YY') + ' - ' + mEnd.format('D MMM YY')
                    );
                return `<div><h5 class="list-schedule">${dtStr}</h5><p class="section-lead">
                    <strong>${item.title}</strong><br/>${item.description}</p></div>`;
            }).join('')}
        `;
        return board;
    }

    formRoom = async function(data){
        const disabled = (data.mode === 'view' ? 'disabled' : '');
        const dt_json = await fetchRoomByID(data.id);     
        const room = dt_json.room;
        const facilities = dt_json.facilities;
        const form = `
        <div class="row justify-content-center" id="form_room" style="display:none">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Room</h4>
                        <div class="card-header-action">
                            <a class="btn btn-icon btn-info" href="#" onclick="removeForm()"><i class="fas fa-times"></i> Back </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="Home/room_view" methods="POST" class="needs-validation" novalidate="">
                            <div class="section-title mt-0 mb-5 strong">${data.mode}</div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="${room[0].name}" ${disabled}>
                                        <div class="invalid-feedback">title cannot be empty</div>
                                    </div>
                                    <!-- capacity -->
                                    <div class="col-6">
                                        <label>Capacity</label>
                                        <input type="number" class="form-control" name="capacity" required="" value="${room[0].capacity}" ${disabled}>
                                    </div>
                                </div>
                            </div>
                            <!-- facility -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Facility</label>
                                        <select class="select2 form-control" name="facilities" multiple="" required="" ${disabled}>
                                            ${facilities.map((f, i) =>{
                                                let selected;
                                                room[0].facilities.map(x =>{
                                                    if(x == f.id){
                                                        selected = 'selected'
                                                    }
                                                })
                                                return `
                                                    <option value="${f.id}" ${selected}>${f.name}</option>
                                                `;
                                            }).join('')}
                                        </select>
                                        <div class="invalid-feedback">title cannot be empty</div>
                                    </div>
                                </div>
                            </div>
                            <!-- location -->
                            <div class="form-group">
                                <div class="row">
                                    <!-- branch location -->
                                    <div class="col-6">
                                        <label>Branch</label>
                                        <select class="form-control" name="location" required="" ${disabled}>
                                            ${this.BRANCH.map(b => {
                                                let selected = (room[0].location == b ? 'selected' : '');
                                                return `
                                                    <option value="${b}" ${selected}>${b.toUpperCase()}</option>
                                                `;
                                            }).join('')}
                                        </select>
                                    </div>
                                    <!-- floor -->
                                    <div class="col-6">
                                        <label>Floor</label>
                                        <input type="number" name="floor" class="form-control" value="${room[0].floor}" ${disabled}>
                                    </div>
                                </div>
                            </div>
                            <!-- is_available -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-label">Availability</div>
                                        <label class="custom-switch mt-2" style="padding-left: unset !important;">
                                            <input type="checkbox" name="is_available" class="custom-switch-input" ${
                                                (room[0].is_available == 1 ? 'checked' : '')
                                            } ${disabled}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">is room can be used immediately ?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- submit -->
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-primary mb-2" name="submit" ${disabled}>submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `;
        return form;
    }

    roomModal = function(data){
        const modal = `
        <div class="modal fade" tabindex="-1" role="dialog" id="" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="card card-mt text-center">
                        <div class="card-header" style="display:block;">
                            <h4>Confirm DELETE</h4>
                        </div>
                        <div class="card-body">
                            <form action="Home/room_update_delete" methods="POST" onsubmit="event.preventDefault(); submitDeleteRoom(this);">
                                <input type="text" class="d-none" name="id" value="${data.id}">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        $(modal).modal('show');        
    }

}