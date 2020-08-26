/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
/**
 * 
 *  utility funciton
 * 
 */
function isArray(myArray) {
    return Array.isArray(myArray);
};

function groupObjectsInsideArray(arrayObj){
    const array = arrayObj;
    for(var j=0;j<array.length;j++){
        var current = array[j];
        for(var i=j+1; i<array.length; i++){
          if(current.start = array[i].start){
            if(!isArray(current.extendedProps))
              current.extendedProps = [ current.extendedProps ];
            if(isArray(array[i].extendedProps))
               for(var v=0; v<array[i].extendedProps.length; v++)
                 current.extendedProps.push(array[i].extendedProps[v]);
            else
              current.extendedProps.push(array[i].extendedProps);
            array.splice(i,1);
            i++;
          }
        }
    }
    return array;
}

function customFunc(param){
    const xArray = param;
    console.log("len " + xArray.length);
    // find duplicate
    let counter = 0;
    
    for(let i=0; i<xArray.length-1; i++){
        let iStart = xArray[i].start;
        for(let j=i+1; j<xArray.length; j++){
            let jStart = xArray[j].start;
            if(iStart === jStart){
                counter += 1
                
                let idxI = xArray.map(function (xi){
                    return xi.start;
                }).indexOf(iStart);
                let idxJ = xArray.map(function (xj){
                    return xj.start;
                }).indexOf(jStart);

                console.log("counter : " + counter + " idxOf : " + idxI + " | idxOf : " + idxJ);
            }
        }
        console.log("idx " + i + " " + xArray[i].start);
    }

    // let obj = array.find(x => x.start === h_dtstart);
    // let index = events.indexOf(obj);
    // if(index >= 0){
    //     let objs = obj.extendedProps;
    //     let arrObj = [].concat(objs, ev.extendedProps);
    //     let countArr = arrObj.length;
    //     events.fill(obj.title = 'H +' + countArr, index, index++);
    //     events.fill(obj.extendedProps = arrObj, index, index++);                    
    // }else{
    //     events.push(ev);
    // }
    
}

$(document).ready(function(){   
    var events_combined = []; 
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
    /**
     * 
     * initialize calendar
     * 
     */
    function loadCalendar(element){
        $.ajax({
            url: 'Home/calendar',
            type: "GET",
            dataType: "text"
        }).done(function(response){
            element.append(response);
            loadEvents();
        }); 
    };

    function loadUpcomingSchedule(data){
        let schEl = $('#mySchedule');
        let newEl, dtStr;
        for(let i=0; i<data.length; i++){
            dtStr = (data[i].start === data[i].end ? data[i].start : data[i].start + ' - ' + data[i].end);
            newEl = '<div><h5 class="list-schedule">'+
                dtStr+'</h5><p class="section-lead"><strong>'+
                data[i].title+'</strong><br/>'+data[i].description+'</p></div>';
            schEl.append(newEl);
        }
    }

    function getDataHRIS(events_params){
        const eventToMerge = events_params;
        // let url_api = 'http://172.73.1.94/rest/rest-izin.php/data?tgl=2020-07-01&tgl_end=2020-08-10';
        let url_api = 'http://192.168.1.43:1381/assets/json/data_izin.json';
        $.ajax({
            url:url_api,
            cache: false,
            type:'GET',
            dataType:'JSON',
            crossDomain:true,
        }).done(function(response_api){             
            const dt_json = response_api.data;
            // console.log('d : ' + dt_json.length);

            // cek data hris
            let events = [];
            for(let i=0; i<10; i++){
                let eventToSplit = [];
                let h_name, h_div, h_dtstart, h_dtend, h_dest;
                h_name = dt_json[i].nama;
                h_div = dt_json[i].nama_bag;
                h_dtstart = dt_json[i].tgl;
                h_dtend = dt_json[i].tgl_end;

                // cek data hris
                                
                let desc = h_name+', '+h_div ;
                let ev = {
                    title:'H',
                    start:h_dtstart,
                    end:h_dtend,
                    description: '',
                    backgroundColor: '#fd7e14',
                    borderColor: '#fd7e14',
                    textColor: '#fafafa',
                    extendedProps: {
                        start:h_dtstart,
                        end:h_dtend,
                        description: desc,
                        department: h_div,
                      },
                };

                // jika event lebih dari h+1
                let isDateRange = false;
                if(h_dtstart !== h_dtend){
                    console.log("lebih dari h+1"); 
                    //  buat object anak sebanyak range tgl
                    eventToSplit = $(this).buildExtendEventsFullCalendar(ev);
                    // console.log("eventToSplit : " + eventToSplit[0].start);
                    events.push(...eventToSplit);
                    isDateRange = true;
                    continue;
                }
                

                let obj = events.find(x => x.start === h_dtstart);
                let index = events.indexOf(obj);
                if(index >= 0){
                    let objs = obj.extendedProps;
                    let arrObj = [].concat(objs, ev.extendedProps);
                    let countArr = arrObj.length;
                    events.fill(obj.title = 'H +' + countArr, index, index++);
                    events.fill(obj.extendedProps = arrObj, index, index++);                    
                }else{
                    events.push(ev);
                }

            }
            // console.log(events.length);
            
            // console.log("e combined : " + eventToMerge);
            let events_combined = [].concat(eventToMerge, events);
            // final events, group all objects 
            // let groupedEvents = groupObjectsInsideArray(events_combined);
            // console.log(JSON.stringify(events_combined));
            customFunc(events_combined);
            renderCalendar(events_combined);   
        });
    }

    function dateTimeStrToDateStr(dateTimeStr){
        let dateStr = moment(dateTimeStr).format('YYYY-MM-DD');
        return moment(dateStr).format('YYYY-MM-DD');
    }

    function loadEvents(){
        let events = [];
        $.ajax({
            url: 'Home/calendar_events',
            type: "GET",
            dataType: "json"
        }).done(function(response){
            const r = response;
            let companyEvents = [];
            for(let i=0; i<r.length; i++){
                let dtStartStr = dateTimeStrToDateStr(r[i].date_start);
                let dtEndStr = dateTimeStrToDateStr(r[i].date_end);
                let event = {
                    title:r[i].celebration,
                    start: dtStartStr,
                    end:dtEndStr,
                    description: (r[i].note !== null ? r[i].note : r[i].celebration),
                    backgroundColor: (r[i].type === 'nasional' ? '#fc544b' : '#3abaf4'),
                    borderColor: (r[i].type === 'nasional' ? '#fc544b' : '#3abaf4'),
                    textColor: '#fafafa'
                };
                events.push(event);
                if(r[i].type === 'company'){
                    companyEvents.push(event);
                }
            }   
            loadUpcomingSchedule(companyEvents);  
            getDataHRIS(events);
        });
    };

    loadCalendar(content_page); 

    function renderCalendar(events){
        const dt_events = events;        
        $("#myCalendar").fullCalendar({
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
                // console.log(event, jsEvent, view)
                console.log(event);
            }
        });  
    }


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

    // $.fn.cari_selisih_hari_str = function(dtStartStr, dtEndStr){
    //     let dtStart = moment(dtStartStr, 'YYYY-MM-DD');
    //     let dtEnd = moment(dtEndStr, 'YYYY-MM-DD');
        
    //     // let differ = moment.duration(dtStart.diff(dtEnd)).asDays();
    //     let differ = dtEnd.diff(dtStart, 'days');

    //     for(let i=0; i<differ; i++){
    //         console.log("build events : " + moment(dtStart + i).format('YYYY-MM-DD'));
    //     }
    //     // console.log ('selisih '+dtStartStr + ' ke '+dtEndStr + ' : '+differ);
    //     // return moment(dateStr).format('YYYY-MM-DD');
    //     return;
    // };

    $.fn.buildExtendEventsFullCalendar = function(events){
        const event = events;
        let title = event.title;
        // let obj = {"test":"child"};
        // let extProps = [].concat(event.extendedProps, obj);
        let extProps = event.extendedProps;
        let backgroundColor = event.backgroundColor;
        let borderColor = event.borderColor;
        let textColor = event.textColor;
        let dtStart = moment(event.start, 'YYYY-MM-DD');
        let dtEnd = moment(event.end, 'YYYY-MM-DD');
        let differ = dtEnd.diff(dtStart, 'days');
        console.log("differ : " + differ);

        let extEvent = [];
        for(let i=0; i<=differ; i++){
            // console.log("build events : " + moment(dtStart + i).format('YYYY-MM-DD'));
            let currDate = moment(dtStart, 'YYYY-MM-DD').add(i, 'days');
            let currDateStr = currDate.format('YYYY-MM-DD');
            
            
            let currEvent = {
                title:title,
                start:currDateStr,
                end:currDateStr,
                extendedProps:extProps,
                backgroundColor:backgroundColor,
                borderColor:borderColor,
                textColor:textColor
            };
            extEvent.push(currEvent);
        }
        // console.log("rebuild Event : "+ JSON.stringify(extEvent));
        // console.log ('selisih '+dtStartStr + ' ke '+dtEndStr + ' : '+differ);
        // return moment(dateStr).format('YYYY-MM-DD');
        return extEvent;
    }

}(jQuery));
