/**
 *  CONSTANT
 */
const SERVER_API = 'http://assetsmanagement.lan/';

async function fetchDataHris(){
    const res = await fetch(SERVER_API + 'assets/json/data_izin.json');
    const data = await res.json();
    return data;
}

async function fetchUserHris(){
    const res = await fetch(SERVER_API + 'assets/json/hris_user.json');
    const data = await res.json();
    return data;
}

async function fetchCalendarEvents(){
    const res = await fetch('Home/calendar_events');
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

    const res = await fetch("http://assetsmanagement.lan/Home/room_view", requestOptions)
        .then(result => {return result})
        .catch(error => console.log('error', error));
    const data = await res.json();
    return data.data;
}

