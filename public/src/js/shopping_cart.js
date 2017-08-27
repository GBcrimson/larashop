var num = $('#cartnum')[0].innerHTML;

$('.addtocart').click(function (el) {
    el.preventDefault();
    console.log(this.href);
    $.ajax({
        type:'post',
        url:this.href,
        success:function(response) {
            $('#cartnum')[0].innerHTML = ++num;
        }
    });
});