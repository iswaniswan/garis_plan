function calendarHide(element){
    $('#calendar-box').fadeOut('fast', function(){
        $('#box-table-calendar').append(element).show('slow');
        let dtl_table = $('#table-detail-event');
        if(dtl_table.length == 1){
            dtl_table.dataTable();
        }
    })
}

function calendarShow(element){
    let table = $(element).parents('.card');
    table.fadeOut('fast', function(){
        $('#calendar-box').fadeIn('slow');
        table.remove();
    })
}

function renderCalendar(events){    
    $("#myCalendar").empty().fullCalendar({
        height: 'auto',
        header: {
            left: 'prev,next today',
            center: 'title',
            // right: 'month,agendaWeek,agendaDay'
            right: 'month'
        },
        selectable: true,
        editable: false,
        events:events,
        eventLimit:true,
        views:{
            month:{
                eventLimit:3,
            }
        },
        eventLimitText:"more",
        // eventAfterRender: function(event, element) {
        //     $(element).tooltip({
        //         title: event.description,
        //         container: "body"
        //     });
        // }
        eventRenderWait: 300,
        eventClick: function(event){        
            showCalendarDateDetail(event);
        },
        dayClick: function(date, jsEvent, view){
            if (FullCalendarActions.isDblClick()){
                const valid = ( moment(date, 'YYYY-MM-DD') > moment.now() ? dblclick_callback(date) : '' ); 
            }
        }
    });  
}

const FullCalendarActions = {
    currentTime: null, 
    isDblClick : function() {
        var prevTime = typeof FullCalendarActions.currentTime === null
        ? new Date().getTime() - 1000000
        : FullCalendarActions.currentTime;
        FullCalendarActions.currentTime= new Date().getTime();
        return FullCalendarActions.currentTime - prevTime < 500;
    }
}

async function dblclick_callback(date){
    let dateStr = date.format();
    const modal = await new Components().modalDayClick(dateStr);  
    $(modal).on('shown.bs.modal', function(){
        // const btn_reservation = $('button[name="room_reservation"]');
        // $(btn_reservation).click(async function(){
        //     const form = await new Components().room_reservation_form_quick(dateStr);
        //     $('.modal-content').empty().append(form);
        // })
        // const btn_event = $('button[name="event"]');
        // $(btn_event.click(async function(){
        //     const form = await new Components().event_form_quick();
        //     $('.modal-content').empty().append(form);
        // }))                              
    }).on('hidden.bs.modal', function(){
        $(this).remove();
    }).modal('show');
}

function quickDayClick(el){
    if($(el).attr('name') == 'room_reservation'){
        // $('a[name="activity-room_reservation-order"]').trigger('click');
        const form = new Components().room_reservation_form();
    }else{
        $('a[name="activity-event-order"]').trigger('click');
    }
    $('.modal').modal('hide');
}

async function showCalendarDateDetail(event){
    let ev = new Event(
        event.title, event.start, event.end, event.description, event.extendedProps
    );
    if(!ev.extendedProps[0].name){
        return new Components().eventModal(event);
    }
    const cmp_table = await new Components().simpleTableHris(event);
    calendarHide(cmp_table);
}

function titleHris(titleStr, counter){
    let strCounter = titleStr.replace('hris +', '') || 0;
    let newCounter = parseInt(strCounter) + counter;
    return 'hris +' + newCounter.toString();
}

function loadComponentScheduleBoard(data){
    let eventPrev = [];
    let eventNext = [];
    data.map(d=>{
        return ( moment(d.end, 'YYYY-MM-DD') < moment.now() ? eventPrev.push(d) : eventNext.push(d) )
    });
    eventNext.sort((a, b) => (moment(a.start, 'YYYY-MM-DD') - moment(b.start, 'YYYY-MM-DD')) );
    eventPrev.sort((a, b) => (moment(b.start, 'YYYY-MM-DD') - moment(a.start, 'YYYY-MM-DD')))
    const elPrev = new Components().scheduleBoardPrev(eventPrev.slice(0, 2));
    $('#schedule-prev').html(elPrev);

    const elNext = new Components().scheduleBoardNext(eventNext.slice(0, 2));
    $('#schedule-next').html(elNext);

    setTimeout(()=>{
        checkDoubleEvents(eventNext);
    }, 500);
}

function checkDoubleEvents(events_param){
    let devents = events_param;
    let duplicates = [];

    devents.map((v, i, self) => {
        let idx = self.findIndex((t) => (t.start == v.start))
        if(idx != i){
            duplicates.push({
                date: v.start
            })
        }
    })

    if(duplicates.length >= 1){
        const template = `<div class="d-flex row"><div class="col-12 text-center text-danger">
            <div class="alert alert-danger">You have clashed event on ${moment(duplicates[0].date, 'YYYY-MM-DD').format('D MMM YYYY')} !</div></div></div>`;
        $('#duplicate-alert').empty().append(template)
    }
}

async function loadEvents(){
    // izin hris unsplit
    let hrisEvents = []; 
    let companyEvents = [];
    let holidayEvents = [];
    let privateEvents = [];
    let groupEvents = [];

    // event yg tampil di schedule board, hanya private dan group, dan tidak di split
    let boardEvents = [];
    const dt_calendar = await api_CalendarEvents();
    dt_calendar.forEach(r => {
        let dtStartStr = dateTimeStrToDateStr(r.date_start);
        let dtEndStr = dateTimeStrToDateStr(r.date_end);
        let tmStartStr = dateTimeStrToTimeStr(r.date_start);
        let tmEndStr = dateTimeStrToTimeStr(r.date_end);
        let description = (r.note !== null ? r.note : r.title);
        let extendedProps = [];
        extendedProps.push({
            description: description,
            type: r.type,
            participant: r.participant,
            time_start: tmStartStr,
            time_end: tmEndStr,
        });
        
        if(r.type === 'private'){
            let eve = new Izin(r.title, dtStartStr, dtEndStr, description, extendedProps);
            boardEvents.push(eve);
            if(eve.start !== eve.end){
                console.log("split")
                let eventToSplit = $(this).splitEvent(eve, 'private');
                privateEvents.push(...eventToSplit);
            }else{
                privateEvents.push(eve);
            }
        }else if(r.type === 'global'){
            let eve = new Holiday(r.title, dtStartStr, dtEndStr, description, extendedProps);
            if(eve.start !== eve.end){
                let eventToSplit = $(this).splitEvent(eve, 'global');
                holidayEvents.push(...eventToSplit);
            }else{
                holidayEvents.push(eve);
            }
        }else if(r.type === 'group'){
            let eve = new Meeting(r.title, dtStartStr, dtEndStr, description, extendedProps);
            boardEvents.push(eve);
            if(eve.start !== eve.end){
                let eventToSplit = $(this).splitEvent(eve, 'group');
                groupEvents.push(...eventToSplit);
            }else{
                groupEvents.push(eve);
            }
        }else if(r.type === 'branch'){
            let eve = new Cuti(r.title, dtStartStr, dtEndStr, description, extendedProps);
            if(eve.start !== eve.end){
                let eventToSplit = $(this).splitEvent(eve, 'branch');
                companyEvents.push(...eventToSplit);
            }else{
                companyEvents.push(eve);
            }
        }
    }); 

    // let boardEvents = [].concat(privateEvents, groupEvents);
    loadComponentScheduleBoard(boardEvents);

    const dt_hris = await api_DataHris();
    dt_hris.data.forEach(data => {
        let h_extProps = {
            name: data.nama,
            start: data.tgl,
            end: data.tgl_end,
            description: '',
            department: data.nama_bag,
            destination: data.tujuan,
        }; 
        // extendeProps harus terinisialisasi sebagai array
        let extendedProps = [];
        extendedProps.push(h_extProps);
        let event = new Hris(
            "hris +1", data.tgl, data.tgl_end, null, extendedProps);
        if(event.start !== event.end){
            let eventToSplit = $(this).splitHrisEvent(event);
            hrisEvents.push(...eventToSplit);
        }else{
            hrisEvents.push(event);
        }
    });

    // grouped events
    let eventsIndex = [];
    let hrisEventCombined = [];
    hrisEvents.map(x => {
        if(include(eventsIndex, x.start)){
            let inTo = eventsIndex.map(function(e) { 
                        return e;
                    }).indexOf(x.start);
            let titleSrc = hrisEventCombined[inTo].title;
            hrisEventCombined[inTo].title = titleHris(titleSrc, 1);
            let ext = [].concat(hrisEventCombined[inTo].extendedProps, x.extendedProps);
            hrisEventCombined[inTo].extendedProps = ext;
        }else{
            let ev = new Hris(
                "hris +1", x.start, x.end, null, x.extendedProps
            );
            hrisEventCombined.push(ev);
            eventsIndex.push(ev.start);
        }
    });
    
    let events_combined = [].concat.apply([], [companyEvents, holidayEvents, privateEvents, groupEvents, hrisEventCombined]);
    renderCalendar(events_combined);
};

(function($){

    $.fn.splitHrisEvent = function(event){

        let eventRanged = new Hris(
            event.title, event.start, event.end, event.description, event.extendedProps
        );
        let eventDiff = moment(eventRanged.end, 'YYYY-MM-DD').diff(
            moment(eventRanged.start, 'YYYY-MM-DD'), 'days'
        );
        let description = eventRanged.description;
        let extEvent = [];
        for(let i=0; i<=eventDiff; i++){
            let currDate = moment(eventRanged.start, 'YYYY-MM-DD').add(i, 'days');
            let currDateStr = currDate.format('YYYY-MM-DD');
            let event = new Hris(
                eventRanged.title, currDateStr, currDateStr, description, eventRanged.extendedProps
            );
            extEvent.push(event);
        }
        // return as array of Event
        return extEvent; 
    }

    $.fn.splitEvent = function(event, type){
        let eventDiff = moment(event.end, 'YYYY-MM-DD').diff(
            moment(event.start, 'YYYY-MM-DD'), 'days'
        );
        let description = event.description;
        let extEvent = [];
        for(let i=0; i<=eventDiff; i++){
            let currDate = moment(event.start, 'YYYY-MM-DD').add(i, 'days');
            let currDateStr = currDate.format('YYYY-MM-DD');
            let nEvent;
            switch(type){
                case 'private':
                    nEvent = new Izin(event.title, currDateStr, currDateStr, description, event.extendedProps);
                    break;
                case 'group':
                    nEvent = new Meeting(event.title, currDateStr, currDateStr, description, event.extendedProps);
                    break;
                case 'global':
                    nEvent = new Holiday(event.title, currDateStr, currDateStr, description, event.extendedProps);
                    break;
                case 'branch':
                    nEvent = new Cuti(event.title, currDateStr, currDateStr, description, event.extendedProps);
                    break;
                default:
                    break;
            }
            extEvent.push(nEvent);
        }
        return extEvent; 
    }

    $.fn.dateClick = function(){
        let dataDate = $(this).attr('data-date');
        console.log(dataDate);
    }

}(jQuery));