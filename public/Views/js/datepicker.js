$(function(){
    $('.datepicker').datepicker();
    $('.timepicker').timepicker({
    timeFormat: 'H:mm',
    interval: 30,
    minTime: '8',
    maxTime: '23:00',
    defaultTime: '10',
    startTime: '8:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
    });
});