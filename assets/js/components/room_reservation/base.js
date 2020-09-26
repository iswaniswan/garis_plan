async function submitDeleteReservation(e){
    const id = $(e).find('input[name="id"]').val();
    const data = await api_ActivityRoomReservationUpdateDelete(id);
    if(data.data == true){
        $('.modal').modal('hide');
        removeForm();
    } 
}

async function submitUpdateReservation(e){
    const time_start = $(e).find('input[name="time_start"]').val();
    const time_end = $(e).find('input[name="time_end"]').val();
    const date_start = moment($(e).find('input[name="start"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + ' ' + time_start;
    const date_end = moment($(e).find('input[name="start"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + ' ' + time_end;
    let params = {
        id: $(e).find('input[name="id"]').val(),
        start: date_start ,
        end: date_end,
        title: $(e).find('input[name="title"]').val(),
        type: 'group',
        note: $(e).find('textarea[name="description"]').val() || '',
        participant: $(e).find('select[name="participant"]').val(),
        room_id: $(e).find('select[name="name"]').val(),
        branch: $(e).find('select[name="branch"]').val() || '',
    }

    const result = await api_ActivityRoomReservationUpdate(params);

    if(result.data == true){
        let modal = await new Components().simpleModalSuccess();
        $('form').empty().append(modal);
        $('a[name="activity-room_reservation-table"]').trigger('click');
    }
}

// async function actionRoom(e){
//     const params = {
//         id: $(e).attr('id'),
//         mode: $(e).attr('name')
//     }

//     if(params.mode === 'delete'){
//         const modal = await new Components().modalConfirmDeleteReservation(params);
//         return false;
//     }

//     const data = await api_ActivityRoomReservationTableGetRoom(params);
//     if(data){
//         const form = await new Components().room_reservation_form(data, params.mode);
//         $('#room_wrapper').empty().append(form);
//         $('select[name="participant"]').select2();
//     }   
    
// }

function removeForm(){
    $('a[name="activity-room_reservation-table"]').trigger('click');
}

function orderRoom(){
    $('a[name="activity-room_reservation-order"]').trigger('click');
}