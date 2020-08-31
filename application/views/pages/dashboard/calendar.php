<div class="section-header">
    <h1 class="">Dashboard</h1>
</div>
<div class="row" id="calendar-box">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Calendar</h4>
            </div>
            <div class="card-body">
            <div class="fc-overflow">
                <div id="myCalendar">
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <strong>Loading...</strong>
                                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Upcoming schedule</h4>
                    </div>
                    <div class="card-body">
                    <div class="fc-overflow">
                        <div id="schedule-next"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Last events</h4>
                    </div>
                    <div class="card-body">
                    <div class="fc-overflow">
                        <div id="schedule-prev"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12" id="box-table-calendar" style="display:none;"></div>
</div>



<script type="text/javascript">
$(document).ready(function(){
    loadEvents();
})

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
            right: 'month,agendaWeek,agendaDay'
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
        }
    });  
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
    
    console.log("loadComponentScheduleBoard -> eventNext", eventNext)
    const elPrev = new Components().scheduleBoardPrev(eventPrev.slice(0, 2));
    $('#schedule-prev').html(elPrev);

    const elNext = new Components().scheduleBoardNext(eventNext.slice(0, 2));
    $('#schedule-next').html(elNext);
}

async function loadEvents(){
    let hrisEvents = []; // izin hris unsplit
    let companyEvents = [];
    let holidayEvents = [];
    let privateEvents = [];
    let groupEvents = [];
    const dt_calendar = await fetchCalendarEvents();
    dt_calendar.forEach(r => {
        let dtStartStr = dateTimeStrToDateStr(r.date_start);
        let dtEndStr = dateTimeStrToDateStr(r.date_end);
        let description = (r.note !== null ? r.note : r.celebration);
        let extendedProps = [];
        extendedProps.push({
            description: description,
            type: r.type
        });
        
        if(r.type === 'private'){
            let eve = new Izin(r.celebration, dtStartStr, dtEndStr, description, extendedProps)
            privateEvents.push(eve);
        }else if(r.type === 'nasional'){
            let eve = new Holiday(r.celebration, dtStartStr, dtEndStr, description, extendedProps);
            holidayEvents.push(eve);
        }else if(r.type === 'group'){
            let eve = new Meeting(r.celebration, dtStartStr, dtEndStr, description, extendedProps);
            groupEvents.push(eve);
        }else if(r.type === 'company'){
            let eve = new Cuti(r.celebration, dtStartStr, dtEndStr, description, extendedProps);
            companyEvents.push(eve);
        }
    }); 

    let boardEvents = [].concat(privateEvents, groupEvents);
    loadComponentScheduleBoard(boardEvents);

    const dt_hris = await fetchDataHris();
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
    // let eventsAll = [].concat.apply([], [array1, array2, ...]);
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
}(jQuery));
</script>