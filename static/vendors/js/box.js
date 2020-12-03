$( document ).ready(function() {

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
