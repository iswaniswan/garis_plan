"use strict";
/**
 * Class Event
 */
class Event {

    constructor(
        title, start, end, description, extendedProps, backgroundColor, borderColor, textColor){
        this.title = title;
        this.start = start;
        this.end = end ;
        this.description = description;
        this.extendedProps = extendedProps;
        this.backgroundColor = backgroundColor;
        this.borderColor = borderColor;
        this.textColor = textColor;
    };

    title; start; end; description; extendedProps; backgroundColor; borderColor; textColor;

    toObject(){
        return {
            title: this.title,
            start: this.start,
            end: this.end,
            extendedProps: this.extendedProps,
            backgroundColor: this.backgroundColor,
            borderColor:  this.borderColor,
            textColor: this.textColor
        };
    }
}
/**
 * 
 *  utility funciton
 * 
 */

function dateTimeStrToDateStr(dateTimeStr){
    let dateStr = moment(dateTimeStr).format('YYYY-MM-DD');
    return moment(dateStr).format('YYYY-MM-DD');
}

function include(arr,obj) {
    return (arr.indexOf(obj) != -1);
}

function renderCalendar(events){    
    $("#myCalendar").empty().fullCalendar({
        height: 'auto',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2020-01-01',
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
            console.log(event);
        }
    });  
}

function titleHris(titleStr, counter){
    let strCounter = titleStr.replace('hris +', '') || 0;
    let newCounter = parseInt(strCounter) + counter;
    return 'hris +' + newCounter.toString();
}
/**
 * 
 * initialize calendar
 * 
 */
function loadComponentCalendar(element){
    $.ajax({
        url: 'Home/calendar',
        type: "GET",
        dataType: "text"
    }).done(function(response){
        element.append(response);
        // loadEvents();
    }); 

    loadEvents();

};

function loadUpcomingSchedule(data){
    let schEl = $('#mySchedule');
    data.sort((a, b) => {
        return (moment(a, 'YYYY-MM-DD') - moment(b, 'YYYY-MM-DD') ? 1 : -1);
    })
    .forEach(item => {
        let mStart = moment(item.start, 'YYYY-MM-DD');
        let mEnd = moment(item.end, 'YYYY-MM-DD');
        let dtStr = (item.start === item.end ? 
            mStart.format('D MMM YY') : mStart.format('D MMM YY') + ' - ' + mEnd.format('D MMM YY')
            );
        let entry = `<div><h5 class="list-schedule">${dtStr}</h5><p class="section-lead">
            <strong>${item.title}</strong><br/>${item.description}</p></div>`;
        schEl.append(entry);
    });
}

function getDataHRIS(events_params){
    const eventToMerge = events_params;
    // let url_api = 'http://172.73.1.94/rest/rest-izin.php/data?tgl=2020-07-01&tgl_end=2020-08-10';
    let url_api = 'http://assetsmanagement.lan/assets/json/data_izin.json';
    $.ajax({
        url:url_api,
        cache: false,
        type:'GET',
        dataType:'JSON',
        crossDomain:true,
    }).done(function(response_api){             
        const dt_json = response_api.data;
        let events = [];
        let backgroundColor= '#fd7e14';
        let borderColor= '#fd7e14';
        let textColor= '#fafafa';

        for(let i=0; i<dt_json.length; i++){
            let h_extProps = {
                start:dt_json[i].tgl,
                end:dt_json[i].tgl_end,
                description: dt_json[i].nama,
                department: dt_json[i].nama_bag,
            };  

            let event = new Event(
                1, dt_json[i].tgl, dt_json[i].tgl_end, null, h_extProps, null, null, null
            );

            if(event.start !== event.end){
                let eventToSplit = $(this).buildExtendEventsFullCalendar(event);
                events.push(...eventToSplit);
            }else{
                events.push(event);
            }
        }

        // grouped events
        let eventsIndex = [];
        let groupsEvent = [];
        // console.log("now length : "+JSON.stringify(events));
        for(let i=0; i<events.length; i++){
            if(include(eventsIndex, events[i].start)){
                let inTo = eventsIndex.map(function(e) { 
                            return e;
                        }).indexOf(events[i].start);
                let count = parseInt(groupsEvent[inTo].title);
                groupsEvent[inTo].title = count + 1;
                let ext = [].concat(groupsEvent[inTo].extendedProps, events[i].extendedProps);
                groupsEvent[inTo].extendedProps = ext;
            }else{
                let event = new Event(
                    1, events[i].start, events[i].end, null, events[i].extendedProps, backgroundColor, borderColor, textColor
                );
                groupsEvent.push(event);
                eventsIndex.push(event.start);
            }
        }

        let events_combined = [].concat(eventToMerge, groupsEvent);
        return events_combined;
        // renderCalendar(events_combined);   
    });
}

async function loadEvents(){
    let events = []; // izin hris unsplit
    let companyEvents = [];
    let holidayEvents = [];

    const dt_calendar = await fetchCalendarEvents();
    // console.log(dt_calendar);
    dt_calendar.forEach(r => {
        let dtStartStr = dateTimeStrToDateStr(r.date_start);
        let dtEndStr = dateTimeStrToDateStr(r.date_end);
        let description = (r.note !== null ? r.note : r.celebration);
        let backgroundColor = (r.type === 'nasional' ? '#fc544b' : '#3abaf4');
        let borderColor = backgroundColor;
        let textColor = '#fafafa';

        let event = new Event(
            r.celebration, dtStartStr, dtEndStr, description, null, backgroundColor, borderColor, textColor
        );
        if(r.type === 'company'){
            companyEvents.push(event);
        }else{
            holidayEvents.push(event);
        }
    }); 
    loadUpcomingSchedule(companyEvents);

    const dt_hris = await fetchDataHris();
    dt_hris.data.forEach(data => {
        let backgroundColor= '#fd7e14';
        let borderColor= backgroundColor;
        let textColor= '#fafafa';
        let h_extProps = {
            start: data.tgl,
            end: data.tgl_end,
            description: data.nama,
            department: data.nama_bag,
        }; 
        let event = new Event(
            "hris +1", data.tgl, data.tgl_end, null, h_extProps, backgroundColor, borderColor, textColor
        );
        if(event.start !== event.end){
            let eventToSplit = $(this).buildExtendEventsFullCalendar(event);
            events.push(...eventToSplit);
        }else{
            events.push(event);
        }
    });

    console.log("events len " +companyEvents.length);

    // grouped events
    let eventsIndex = [];
    let hrisEvent = [];
    events.map(x => {
        if(include(eventsIndex, x.start)){
            let inTo = eventsIndex.map(function(e) { 
                        return e;
                    }).indexOf(x.start);
            let titleSrc = hrisEvent[inTo].title;
            hrisEvent[inTo].title = titleHris(titleSrc, 1);
            let ext = [].concat(hrisEvent[inTo].extendedProps, x.extendedProps);
            hrisEvent[inTo].extendedProps = ext;
        }else{
            let ev = new Event(
                "hris +1", x.start, x.end, null, x.extendedProps, x.backgroundColor, x.borderColor, x.textColor
            );
            hrisEvent.push(ev);
            eventsIndex.push(ev.start);
        }
    });

    let events_combined = [].concat(companyEvents, holidayEvents);
    events_combined = [].concat(events_combined, hrisEvent);
    renderCalendar(events_combined);
};

async function fetchDataHris(){
    const res = await fetch('http://assetsmanagement.lan/assets/json/data_izin.json');
    const data = await res.json();
    return data;
}

async function fetchCalendarEvents(){
    const res = await fetch('Home/calendar_events');
    const data = await res.json();
    return data;
}

$(document).ready(function(){  
    /**
     * 
     * sidebar menu click
     * 
     */
    let sidebar_menu = $("#sidebar_menu a");
    let content_page = $("#main_content");

    sidebar_menu.each(function(){
        $(this).click(function(event){
            event.preventDefault();
            let valid_url = $(this).attr("href");
            if(valid_url !== "#"){
                $(this).custom_callback(valid_url, content_page);
            }
        });
    });    
    
    loadComponentCalendar(content_page); 

});

(function($){

    $.fn.custom_callback = function(url, element){
        $.ajax({
            url: url,
            type: "GET",
            dataType: "text",
            success: function(){
                element.empty();
            }
        }).done(function(response){
            element.append(response);
        });
    };

    $.fn.buildExtendEventsFullCalendar = function(event){

        let eventRanged = new Event(
            event.title, event.start, event.end, event.description, event.extendedProps, event.backgroundColor, event.borderColor, event.textColor
        );
        let eventDiff = moment(eventRanged.end, 'YYYY-MM-DD').diff(
            moment(eventRanged.start, 'YYYY-MM-DD'), 'days'
        );
        let description = eventRanged.description;
        let extEvent = [];
        for(let i=0; i<=eventDiff; i++){
            let currDate = moment(eventRanged.start, 'YYYY-MM-DD').add(i, 'days');
            let currDateStr = currDate.format('YYYY-MM-DD');
            let event = new Event(
                eventRanged.title, currDateStr, currDateStr, description, eventRanged.extendedProps,
                eventRanged.backgroundColor, eventRanged.borderColor, eventRanged.textColor
            );
            extEvent.push(event);
        }
        // return as array of Event
        return extEvent; 
    }

}(jQuery));


