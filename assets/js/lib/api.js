/**
 *  CONSTANT
 */
// const SERVER_API = 'http://assetsmanagement.lan/';
const SERVER_API = 'http://localhost:1381/';
// const SERVER_API = 'http://172.73.1.94/';

async function api_Userprofile(){
    const res = await fetch(SERVER_API + 'assets/json/hris_profile.json');
    const data = await res.json();
    return data;
}

async function api_DataHris(){
    const res = await fetch(SERVER_API + 'assets/json/data_izin.json');
    // const res = await fetch(SERVER_API + 'rest/rest-izin.php/data?tgl=2020-01-01&tgl_end=2020-08-01');
    const data = await res.json();
    return data;
}

async function api_UserHris(){
    const res = await fetch(SERVER_API + 'assets/json/hris_user.json');
    // const res = await fetch(SERVER_API + 'rest/rest-user.php/data');
    const data = await res.json();
    return data;
}

async function api_CalendarEvents(){
    const res = await fetch('Home/calendar_events');
    const data = await res.json();
    return data;
}

async function api_Facilities(){
    const res = await fetch('settings/facilities_id_name');
    const data = await res.json();
    return data;
}

async function api_FacilityById(id){
    let form = new FormData();
    form.append('id', id);

    let requestOptions = {
        method: 'POST',
        body: form
    }    
    
    const res = await fetch(SERVER_API+"settings/facility_get_by_id", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
    
    return data;
}

async function api_RoomByID(id){

    let formdata = new FormData();
    formdata.append("id", id);

    let requestOptions = {
    method: 'POST',
    body: formdata,
    redirect: 'follow'
    };

    const res = await fetch(SERVER_API+"/settings/room_view", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));
    const data = await res.json();
    return data.data;
}

async function api_NewRoom(payload){
    let arrIntFacilities = [];
    payload.facilities.map(x=>{
        return arrIntFacilities.push(parseInt(x));
    });

    let form = new FormData();
    Object.entries(payload).forEach(([key, value]) => {
        if(key == 'facilities'){
            form.append(key, JSON.stringify(arrIntFacilities));
        }else{
            form.append(key, value);
        }
    });

    let requestOptions = {
        method: 'POST',
        body: form
    }    
    
    const res = await fetch(SERVER_API+"settings/room_insert", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
    
    return data;
}

async function api_UpdateRoom(payload){
    let arrIntFacilities = [];
    payload.facilities.map(x=>{
        return arrIntFacilities.push(parseInt(x));
    });

    let form = new FormData();
    Object.entries(payload).forEach(([key, value]) => {
        if(key == 'facilities'){
            form.append(key, JSON.stringify(arrIntFacilities));
        }else{
            form.append(key, value);
        }
    });

    let requestOptions = {
        method: 'POST',
        body: form
    }    
    
    const res = await fetch(SERVER_API+"settings/room_update", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
    
    return data;
}

async function api_roomReservationOrderSubmit(payload){
    let arrUser = [];
    payload.participant.map(x=>{
        return arrUser.push(parseInt(x));
    });

    let form = new FormData();
    Object.entries(payload).forEach(([key, value]) => {
        if(key == 'participant' && value != null){
            form.append(key, JSON.stringify(arrUser));
        }else{
            form.append(key, value);
        }
    });

    let requestOptions = {
        method: 'POST',
        body: form
    }    
    
    const res = await fetch(SERVER_API+"Activity/room_reservation_order_submit", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
        
    return data;
}

async function api_UserNotification(){
    const res = await fetch('activity/notification_get_user_alert');
    const data = await res.json();
    return data;   
}

async function api_DetailNotification(params){
    let form = new FormData();
    form.append("id", params);

    let requestOptions = {
        method: 'POST',
        body: form
    }  
    const res = await fetch('activity/notification_get_by_id', requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));   ;
    const data = await res.json();
    return data;
}

async function api_NotificationHasRead(params){
    let form = new FormData();
    form.append("id", params);

    let requestOptions = {
        method: 'POST',
        body: form
    }  
    const res = await fetch('activity/notification_set_has_read', requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));   
    return res;
}

async function api_PassiveEventInsertUpdate(params){
    let form = new FormData();
    form.append('event_id', params.event_id);
    form.append('is_join', params.is_join);
    form.append('is_cancel', params.is_cancel);

    let requestOptions = {
        method: 'POST',
        body: form
    }  
    const res = await fetch('activity/notification_insert_update_event_passive', requestOptions)
        .then(result => {return result.json()})
        .catch(error => console.log('error', error)); 
    return res;
}