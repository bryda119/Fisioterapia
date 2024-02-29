$('#open_hours').datetimepicker({
    format: 'LT'
});
$('#close_hours').datetimepicker({
    format: 'LT'
});
$('#edit_open_hours').datetimepicker({
    format: 'LT'
});
$('#edit_close_hours').datetimepicker({
    format: 'LT'
});

$(".select-clinic").select2({
    placeholder: "Select clinic",
    allowClear: true
});
$(".countries").select2({
    placeholder: "Select a country",
    allowClear: true
});
$(".states").select2({
    placeholder: "Select a state",
    allowClear: true
});
$(".cities").select2({
    placeholder: "Select a city",
    allowClear: true
});
$(".multiple-service").select2({
    allowClear: true
});
// $('.datetimepicker-input').datetimepicker({
//     format: 'DD-MM-YYYY',
//     maxDate: new Date()
//   });