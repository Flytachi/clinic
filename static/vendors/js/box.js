
function TabControl(tab) {
    $('.tab-pane').removeClass('show').removeClass('active');
    $('.nav-link').removeClass('show').removeClass('active');
    $('#'+tab).addClass('show').addClass('active');
    $('a[href="#'+tab+'"]').addClass('show').addClass('active');
}

function Downsum(input) {
    input.attr("class", 'form-control');
    input.val("");
    var inp_s = $('.input_chek');
    inp_s.val($('#total_price').val()/inp_s.length);
}

function Upsum(input) {
    input.attr("class", 'form-control input_chek');
    var inp_s = $('.input_chek');
    var vas = 0;
    for (let key of inp_s) {
        vas += Number(key.value);
    }
    input.val($('#total_price').val()-vas);
}

function getDate()
{
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    //По надобности условие ниже повторить с minutes и hours
    if(minutes < 10)
    {
        minutes = '0' + minutes;
    }
    if(seconds < 10)
    {
        seconds = '0' + seconds;
    }
    document.getElementById('timedisplay').innerHTML = hours + ':' + minutes + ':' + seconds;
}
setInterval(getDate, 0);
