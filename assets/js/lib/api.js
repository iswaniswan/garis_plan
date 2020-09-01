/**
 *  CONSTANT
 */
// const SERVER_API = 'http://assetsmanagement.lan/';
const SERVER_API = 'http://localhost:1381/';
// const SERVER_API = 'http://172.73.1.94/';

async function fetchUserprofile(){
    const res = await fetch(SERVER_API + 'assets/json/hris_profile.json');
    const data = await res.json();
    return data;
}

async function fetchDataHris(){
    const res = await fetch(SERVER_API + 'assets/json/data_izin.json');
    // const res = await fetch(SERVER_API + 'rest/rest-izin.php/data?tgl=2020-01-01&tgl_end=2020-08-01');
    const data = await res.json();
    console.log("fetchDataHris -> data", data)
    return data;
}

async function fetchUserHris(){
    const res = await fetch(SERVER_API + 'assets/json/hris_user.json');
    // const res = await fetch(SERVER_API + 'rest/rest-user.php/data');
    const data = await res.json();
    return data;
}

async function fetchCalendarEvents(){
    const res = await fetch('Home/calendar_events');
    const data = await res.json();
    return data;
}

async function fetchFacilities(){
    const res = await fetch('Home/fetchFacilities');
    const data = await res.json();
    return data;
}

async function fetchFacilityById(id){
    let form = new FormData();
    form.append('id', id);

    let requestOptions = {
        method: 'POST',
        body: form
    }    
    
    const res = await fetch(SERVER_API+"Home/fetchFacilityById", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
    
    return data;
}

async function fetchRoomByID(id){
    // headers optional
    // let myHeaders = new Headers();
    // myHeaders.append({
    //     'Accept': 'application/json, text/plain, */*',
    //     'Content-Type': 'application/json'
    // });

    let formdata = new FormData();
    formdata.append("id", id);

    let requestOptions = {
    method: 'POST',
    body: formdata,
    redirect: 'follow'
    };

    const res = await fetch(SERVER_API+"/Home/room_view", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));
    const data = await res.json();
    return data.data;
}

async function fetchNewRoom(payload){
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
    
    const res = await fetch(SERVER_API+"Home/room_insert", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
    
    return data;
}

async function fetchUpdateRoom(payload){
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
    
    const res = await fetch(SERVER_API+"Home/room_update", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));    
    const data = await res.json();
    
    return data;
}