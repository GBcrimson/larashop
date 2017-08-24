var timer;

$('.action_buttons [data-action]').click(function(e){
    var btn = $(this);
    var inp =  btn.siblings("input")[0];
    console.log($(this).data('action'));
    switch (btn.data('action')) {
        case "inc":
            console.log(inp);
            inp.value ++;
            break;
        case "dec":
            inp.value --;
            break;
    }
});

$(".action_buttons input").on('change, input', (function(e){

    var inp = $(this);
    console.log(inp);
    var productId = inp.closest("[data-product]").data("product");
    sendData(productId, inp.val());

}));

function sendData(productId, num) {
    clearTimeout(timer);
    timer = setTimeout(function() {
        var data = {
            'num': num
        };
        console.log(data);

        $.ajax({
            type: "POST",
            url: 'set/' + productId,
            data: data,
            success: function(res){
                console.log(res);
            },
            error: function (err) {
                console.error(err);
            }});    }, 1000);

}

function reRender() {

}