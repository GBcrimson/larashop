var num = $('#cartnum')[0].innerHTML;

$('.addtocart').click(function (el) {
    el.preventDefault();
    console.log(this.href);
    $.ajax({
        type:'get',
        url:this.href,
        success:function(response) {
            console.log(response);
            $('#cartnum')[0].innerHTML = ++num;
        }
    });
});