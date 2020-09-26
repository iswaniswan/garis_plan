function removeForm(){
    $('a[name="activity-event-table"]').trigger('click');
}

async function submitDeleteEvent(e){
    const id = $(e).find('input[name="id"]').val();
    const data = await api_ActivityEventUpdateDelete(id);
    if(data.data == true){
        $('.modal').modal('hide');
        removeForm();
    } 
}

async function submitUpdateEvent(e){
    const date_start = moment($(e).find('input[name="start"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + " 00:00:00";
    const date_end = moment($(e).find('input[name="end"]').val(), 'DD MMM YYYY').format('YYYY-MM-DD') + " 00:00:00";
    let type ;
    $(e).find('input[name="option"]').each(function(){
        if($(this).is(':checked')){
            type = $(this).val();
        }
    })

    let params = {
        id: $(e).find('input[name="id"]').val(),
        start: date_start ,
        end: date_end,
        title: $(e).find('input[name="title"]').val(),
        type: type.toLowerCase(),
        note: $(e).find('textarea[name="description"]').val() || '',
        participant: $(e).find('select[name="participant"]').val(),
        room_id: $(e).find('select[name="name"]').val() || null,
        branch: $(e).find('select[name="branch"]').val() || '',
    }
    console.log("submitUpdateEvent -> params", params)

    const result = await api_ActivityEventUpdate(params);

    if(result.data == true){
        let modal = await new Components().simpleModalSuccess();
        $('form').empty().append(modal);
        $('a[name="activity-event-table"]').trigger('click');
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
        removeForm();
    }
}

function orderEvent(){
    $('a[name="activity-event-order"]').trigger('click');
}