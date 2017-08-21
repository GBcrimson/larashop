var data = {
    'lol':'kek'
};
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    type: "POST",
    url: 'set/10',
    data: data,
    success: function(res){
        console.log(res);
    },
    error: function (err) {
        console.error(err);
    },
    dataType: 'json'
});