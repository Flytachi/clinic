
function TabControl(tab) {
    $('.tab-pane').removeClass('show').removeClass('active');
    $('.nav-link').removeClass('show').removeClass('active');
    $('#'+tab).addClass('show').addClass('active');
    $('a[href="#'+tab+'"]').addClass('show').addClass('active');
}
