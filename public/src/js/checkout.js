var timer;

init();

function init(){
    $.ajax({
        type: "GET",
        url: 'api/cart',
        success: function(res){
            console.log(res);
            update(res);
        },
        error: function (err) {
            console.error(err);
        }});
}

function setEvents () {
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
        inp[0].value = inp[0].value.replace(/[^0-9\.]/g,'');
        var productId = inp.closest("[data-product]").data("product");
        sendPutData(productId, inp.val());

    }));
}



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
    console.log(data);
    var inner ='';
    if (data.items !== {}) {
        inner = '' +
            '<div class="shopping-cart row">' +
            '<div class="col-sm-10 col-md-8 col-md-offset-2 col-sm-offset-1">' +
            '<table><tr>' +
            '<th>Наименование</th>' +
            '<th>Количество</th>' +
            '<th>Цена</th>' +
            '<th>Сумма</th>' +
            '<th></th>' +
            '</tr>';
        for (var item in data.items){
            item_tmp = data.items[item];
            console.log(item_tmp);

            inner += '' +
                '<tr data-product="' + item_tmp.item.id + '" class="action_buttons">' +
                '<td class="table__name">' + item_tmp.item.title + '</td>' +
                '<td><button type="button" data-action="dec" class="btn btn-xs"> - </button>' +
                '<input type="text" value="' + item_tmp.qty + '">' +
                '<button type="button" data-action="inc" class="btn btn-xs"> + </button>' +
                '</td><td>' + item_tmp.item.price + '</td>' +
                '<td>' + item_tmp.price + '</td><td>' +
                '<button type="button" data-action="remove" class="btn btn-xs btn-danger"> х </button></td>' +
            '</tr>';
        };

        inner += '' +
            '</table></div></div>' +
            '<div class="row">' +
            '<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">' +
            '<strong>Total: <span  id="totalprice">data.totalPrice</span></strong>' +
            '</div></div>';
        // $('#totalprice')[0].innerHTML = data.totalPrice;
    }else {
        inner =
            '<div class="row">' +
            '<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">' +
            '<h2>No Items in Cart!</h2>' +
            '</div></div>';
    }

    $('#shopping_cart')[0].innerHTML = inner;

    $('#cartnum')[0].innerHTML = data.totalQty;

    setEvents();
}