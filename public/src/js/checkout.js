var data = {
    'num': '5'
};
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
// $.ajax({
//     type: "POST",
//     url: 'set/1',
//     data: data,
//     success: function(res){
//         console.log(res);
//     },
//     error: function (err) {
//         console.error(err);
//     },
//     dataType: 'json'
// });

$('.addfive').click(function(e){
    e.preventDefault();
    $.ajax({
    type: "POST",
    url: 'set/1',
    data: data,
    success: function(res){
        console.log(res);
    },
    error: function (err) {
        console.error(err);
    }});
});