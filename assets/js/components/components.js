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

    scheduleBoardPrev = function(data){
        const board = `
            ${data.sort((a, b) => {
                return (moment(a, 'YYYY-MM-DD') - moment(b, 'YYYY-MM-DD'));
            }).map(item => {
                let mStart = moment(item.start, 'YYYY-MM-DD');
                let mEnd = moment(item.end, 'YYYY-MM-DD');
                let dtStr = (item.start === item.end ? 
                    mStart.format('D MMM YY') : mStart.format('D MMM YY') + ' - ' + mEnd.format('D MMM YY')
                    );
                return `<div><h5 class="list-schedule prev">${dtStr}</h5><p class="section-lead">
                    <strong>${item.title}</strong><br/>${item.description}</p></div>`;
            }).join('')}
        `;
        return board;
    }

    scheduleBoardNext = function(data){
        console.log("Components -> scheduleBoardNext -> data", data)
        const board = `
            ${data.map(item => {
                let mStart = moment(item.start, 'YYYY-MM-DD');
                let mEnd = moment(item.end, 'YYYY-MM-DD');
                let dtStr = (item.start === item.end ? 
                    mStart.format('D MMM YY') : mStart.format('D MMM YY') + ' - ' + mEnd.format('D MMM YY')
                    );

                const isGroup = (item.extendedProps[0].type === 'group' ? 'group' : '');

                return `<div><h5 class="list-schedule ${isGroup}">${dtStr}</h5><p class="section-lead">
                    <strong>${item.title}</strong><br/>${item.description}</p></div>`;
            }).join('')}
        `;
        return board;
    }

    // components room

    formRoom = async function(data){
        const disabled = (data.mode === 'view' ? 'disabled' : '');
        const dt_json = await api_RoomByID(data.id);     
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
                        <form action="settings/room_view" methods="POST" class="needs-validation" novalidate=""
                            onsubmit="event.preventDefault(); submitUpdateRoom(this);" id="${data.id}">
                            <div class="section-title mt-0 mb-5 strong">${data.mode.toUpperCase()}</div>
                            
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
                                                    if(x == f.id || parseInt(x) == f.id){
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
                            <form action="settings/room_update_delete" methods="POST" onsubmit="event.preventDefault(); submitDeleteRoom(this);">
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

    formAddRoom = async function(data){
        const facilities = await api_Facilities();
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
                        <form action="" methods="POST" class="needs-validation" onsubmit="event.preventDefault(); submitNewRoom(this);" 
                            novalidate="">
                            <div class="section-title mt-0 mb-5 strong">${data.mode.toUpperCase()}</div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="">
                                        <div class="invalid-feedback">title cannot be empty</div>
                                    </div>
                                    <!-- capacity -->
                                    <div class="col-6">
                                        <label>Capacity</label>
                                        <input type="number" class="form-control" name="capacity" required="" value="">
                                    </div>
                                </div>
                            </div>
                            <!-- facility -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Facility</label>
                                        <select class="select2 form-control" name="facilities" multiple="" required="">
                                            ${facilities.map((f, i) =>{
                                                return `
                                                    <option value="${f.id}">${f.name}</option>
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
                                        <select class="form-control" name="location" required="">
                                            ${this.BRANCH.map(b => {
                                                return `
                                                    <option value="${b}">${b.toUpperCase()}</option>
                                                `;
                                            }).join('')}
                                        </select>
                                    </div>
                                    <!-- floor -->
                                    <div class="col-6">
                                        <label>Floor</label>
                                        <input type="number" name="floor" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <!-- is_available -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-label">Availability</div>
                                        <label class="custom-switch mt-2" style="padding-left: unset !important;">
                                            <input type="checkbox" name="is_available" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">is room can be used immediately ?</span>
                                        </label>
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
        `;
        return form;
    }

    // components room end

    // components facility 

    formFacility = async function(data){
        const disabled = (data.mode === 'view' ? 'disabled' : '');
        const dt_json = await api_FacilityById(data.id);     
        const fac = dt_json;        
        const form = `
        <div class="row justify-content-center" id="form_facility" style="display:none">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Facility</h4>
                        <div class="card-header-action">
                            <a class="btn btn-icon btn-info" href="#" onclick="removeForm()"><i class="fas fa-times"></i> Back </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="settings/room_view" methods="POST" class="needs-validation" novalidate=""
                            onsubmit="event.preventDefault(); submitUpdateFacility(this);" id="${data.id}">
                            <div class="section-title mt-0 mb-5 strong">${data.mode.toUpperCase()}</div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="${fac[0].name}" ${disabled}>
                                        <div class="invalid-feedback">title cannot be empty</div>
                                    </div>
                                    <!-- capacity -->
                                    <div class="col-6">
                                        <label>Condition</label>
                                        <input type="number" class="form-control" name="capacity" required="" value="${fac[0].condition}" ${disabled}>
                                    </div>
                                </div>
                            </div>
                            <!-- note -->
                            <div class="form-group">
                                <div class="row">
                                    <!-- branch location -->
                                    <div class="col-12">
                                        <label>Note</label>
                                        <textarea class="form-control" name="note">${fac[0].note}</textarea>
                                    </div>
                                    <!-- floor -->
                                    <div class="col-12">
                                        <label>Last updated</label>
                                        <input type="text" name="updated_date" class="form-control" value="${fac[0].updated_date}" ${disabled}>
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

    simpleModalSuccess = function(){
        const modal = `
            <div class="modal fade" tabindex="-1" role="dialog" id="" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-success"><h5 class="modal-title" id="">Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="">Data inserted successfully</div>
                    </div>
                </div>
            </div>
        `;
        $(modal).modal('show');
    }

    simpleModalFailed = function(){
        const modal = `
            <div class="modal fade" tabindex="-1" role="dialog" id="" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-danger"><h5 class="modal-title" id="">Failed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="">Some error occured, please contact IT Support</div>
                    </div>
                </div>
            </div>
        `;
        $(modal).modal('show');
    }

    notification = function(data, show){
        console.log("Components -> notification -> data", data)
        const showed = show ? 'show' : '';
        const template = `
            <a href="#" data-toggle="dropdown" id="" class="nav-link notification-toggle nav-link-lg beep">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right ${showed}">
                <div class="dropdown-header">Notifications
                    <div class="float-right d-none">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                ${data.map(x=>{
                    let ntime = moment(x.updated_date, 'YYYY-MM-DD HH:mm:ss').toNow(true);
                    let ntimeStr = 'About ' + ntime + ' ago';
                    return `
                        <div class="dropdown-list-content dropdown-list-icons" style="height:auto";>
                            <a href="#" class="dropdown-item dropdown-item-unread" id=${x.id} onclick="actionNotificationNavbar(this)">
                                <div class="dropdown-item-icon bg-success text-white">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    <span class="">${x.title}</span>
                                    <div class="time text-dark" time="" style="text-transform:unset !important">${ntimeStr}</div>
                                </div>
                            </a>
                        </div>
                    `;
                }).join('')}
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        `;
        return template;
    }

    notification_empty = function(show){
        const showed = show ? 'show' : '';
        return `
        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right ${showed}">
            <div class="dropdown-list-content dropdown-list-icons" style="height:85px">
                <a href="#" class="dropdown-item dropdown-item-unread">
                    <div class="dropdown-item-desc"><h5><small>No new notification</small></h5></div>
                </a>
            </div>
            <div class="dropdown-footer text-center">
                <a href="#" onclick="removeForm();">View All <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        `;
    }

    notification_form = async function(id){
        const data = await api_DetailNotification(id)
        const date_start = moment(data.date_start, 'YYYY-MM-DD HH:mm:ss').format('DD MMM YY');
        const date_end = moment(data.date_end, 'YYYY-MM-DD HH:mm:ss').format('DD MMM YY');
        const dateString = (date_start === date_end ? date_start : date_start + ' - ' + date_end);
        
        console.log("Components -> data.is_join", data.is_join)
        const form = `
        <div class="container">
            <div class="row justify-content-center" style="">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Notification</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-info" href="#" onclick="removeForm()"><i class="fas fa-times"></i> Close </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="section-title mt-0 mb-5 strong">Received at ${moment(data.updated_date, 'YYYY-MM-DD HH:mm:ss').format('DD MMM YY HH:mm')}</div>
                            
                            <div class="container-fluid">
                                <div class="row mb-3">
                                    <div class="col-4 font-weight-bold">Title</div>
                                    <div class="col-8">${(data.title)}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4 font-weight-bold">Event description</div>
                                    <div class="col-8">${(data.note !== undefined ? data.note : '')}</div>
                                </div>
                                <div class="row justify-content-start mb-3">
                                    <div class="col-4 font-weight-bold">Date</div>
                                    <div class="col-8">
                                        ${dateString}
                                    </div>
                                </div>
                                <div class="row justify-content-start mb-3">
                                    <div class="col-4 font-weight-bold">Time</div>
                                    <div class="col-8"></div>
                                </div>
                                <div class="row justify-content-start mb-3">
                                    <div class="col-4 font-weight-bold">Room</div>
                                    <div class="col-8">${(data.room !== undefined ? data.room : '')}</div>
                                </div>
                                <div class="row justify-content-start mb-3">
                                    <div class="col-4 font-weight-bold">Other participant</div>
                                    <div class="col-8">${data.participant.map(x=>{ return x }).join(', ')}</div>
                                </div>
                                <div class="row justify-content-start mb-3">
                                    <div class="col-4 font-weight-bold">Invited by</div>
                                    <div class="col-8">${data.updated_by}</div>
                                </div>
                                <div class="row justify-content-start mt-5 mb-3">
                                    <div class="col-12">
                                        <form action="" methods="POST" class="needs-validation" novalidate="" onsubmit="event.preventDefault(); setPassiveEvent(this);" id="${data.event_id}">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" name="customCheck" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">
                                                    ${data.is_join == 1 ? `I decide to cancel and remove this event from my calendar.` : `I Agree and add mark this event to my calendar.`}
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="event_id" value="${data.event_id}" class="d-none">
                                                ${data.is_join == 1 ? `<input type="text" name="is_cancel" value="1" class="d-none">` : `<input type="text" name="is_join" value="1" class="d-none">`}                                                
                                                <button type="submit" class="btn ${data.is_join == 1 ? `btn-warning` : `btn-primary` } mb-2" name="submit" id="btn_notif_submit" disabled>Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        return form;
    }
    
    room_reservation_form = function(data, mode){
        const disabled = (mode === 'view' ? 'disabled' : '');
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
                            <form action="" methods="POST" class="needs-validation" novalidate="" onsubmit="event.preventDefault();">
                                <div class="section-title mt-0 text-primary mb-5">Add</div>
                                <!-- room select -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>choose room</label>
                                            <select class="form-control select2" id="select_room" name="name" required="" ${disabled}>
                                                <option value="${data.id}" selected>${data.name}</option>
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
                                            <input type="text" class="form-control datetimepicker" name="start">
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
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Event title</label>
                                            <input type="text" class="form-control" name="title" required="">
                                            <div class="invalid-feedback">title cannot be empty</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Description</label>
                                            <textarea name="description" rows="3" class="form-control" style="min-height:96px;" required=""></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Add participant</label>
                                            <select class="select2 form-control" name="participant" multiple="" required="" id="user-selection">
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
        `;
        return form;
    }

}