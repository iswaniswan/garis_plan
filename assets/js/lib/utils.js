"use strict";
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