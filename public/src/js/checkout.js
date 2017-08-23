

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
    var productId = inp.closest("[data-product]").data("product");
    sendData(productId, inp.value);

}));

function sendData(productId, num) {
    var timer;
    var data = {
        'num': num
    };
    $.ajax({
        type: "POST",
        url: 'set/' + productId,
        data: data,
        success: function(res){
            console.log(res);
        },
        error: function (err) {
            console.error(err);
        }});
}

function reRender() {

}