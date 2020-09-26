import { HOST } from '../settings.js';

export class Api {
    async room(){
        const res = await fetch('activity/room_get_data_id_name');
        return res.json();
    }

    async roomAll(){
        const res = await fetch('api/room');
        return res.json();
    }

    async userHris(){    
        const res = await fetch(`/assets/json/hris_user2.json`);
        return res.json();
    }

    async roomReservationOrderSubmit(payload){
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
        
        const res = await fetch("activity/room_reservation_order_submit", requestOptions)
            .then(result => {return result})
            .catch(error => console.log('error', error));    
        const data = await res.json();
            
        return data;
    }

    async activityRoomReservationTableGetRoom(params){
        let form = new FormData();
        form.append('id', params.id);
    
        let requestOptions = { method: 'POST', body: form }
    
        const res = await fetch('activity/room/reservation/table/get', requestOptions)
            .then(result => { return result.json() })
            .catch(error => { console.log('error', error) })
        return res;
    }

    async activityEventTableGetEvent(params){
        let form = new FormData();
        form.append('id', params.id);
    
        let requestOptions = { method: 'POST', body: form }
    
        const res = await fetch('activity/event/table/get', requestOptions)
            .then(result => { return result.json() })
            .catch(error => { console.log('error', error) })
        return res;
    }

}
