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
        case "remove":
            var tr = btn.closest('tr');
            sendDeleteData(tr.data('product'), function(){
                tr.remove();
            });
            break;
    }
});

$(".action_buttons input").on('change, input', (function(e){

    var inp = $(this);
    console.log(inp);
    var productId = inp.closest("[data-product]").data("product");
    sendData(productId, inp.val());

}));

function sendPutData(productId, num) {
    clearTimeout(timer);
    timer = setTimeout(function() {
        var data = {
            'num': num
        };
        console.log(data);

        $.ajax({
            type: "PUT",
            url: 'api/cart/' + productId,
            data: data,
            success: function(res){
                console.log(res);
                update(res);

            },
            error: function (err) {
                console.error(err);
            }});    }, 1000);

}
function sendDeleteData(productId, callback) {
        console.log(productId);
        $.ajax({
            type: "DELETE",
            url: 'api/cart/' + productId,
            success: function(res){
                callback();
                console.log(res);
                update(res);
            },
            error: function (err) {
                console.error(err);
            }});

}

function update(data) {
    $('#cartnum')[0].innerHTML = data.totalQty;
    $('#totalprice')[0].innerHTML = data.totalPrice;
}