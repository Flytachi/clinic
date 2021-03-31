function number_format(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
    var s = ''

    var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
        .toFixed(prec)
    }

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
    }
    return s.join(dec)
}

function FirstClick(item) {
    // item.style.display = "none"; 
    // var element = document.createElement("div");
    // element.id = "Something";
    // element.className = "btn btn-sm";
    // element.disabled = true;
    // element.innerHTML = "Loading...";
    // item.parentElement.appendChild(element); 
}

String.prototype.FirstUpperWords = function () {
    return this.replace(/\w+/g, function(a){
        return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
    })
}

function Print(events) {
    var WinPrint = window.open(``,'ABC','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
    $.ajax({
        type: "GET",
        url: events,
        success: function (data) {
            WinPrint.document.write(data);
            WinPrint.document.close();
            WinPrint.focus();
            window.stop();
            $(WinPrint).on('load', function () {
                WinPrint.print();
                WinPrint.close();
            });
        },
    });
};

function NewNoty() {
    event.preventDefault();
    $.ajax({
        type: $(event.target).attr("method"),
        url: $(event.target).attr("action"),
        data: $(event.target).serializeArray(),
        success: function (result) {
            if (result == 1) {
                $(event).trigger('reset');
                new Noty({
                    text: 'Успешно!',
                    type: 'success'
                }).show();
            }else {
                new Noty({
                    text: result,
                    type: 'error'
                }).show();
            }
        },
    });
}

function TabControl(tab) {
    $('.tab-pane').removeClass('show').removeClass('active');
    $('.nav-link').removeClass('show').removeClass('active');
    $('#'+tab).addClass('show').addClass('active');
    $('a[href="#'+tab+'"]').addClass('show').addClass('active');
}

$( document ).ready(function() {

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

});
