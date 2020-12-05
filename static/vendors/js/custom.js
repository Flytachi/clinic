$( document ).ready(function() {

    // Switchery

    var elems = Array.prototype.slice.call(document.querySelectorAll('.swit'));

    elems.forEach(function(html) {
      var switchery = new Switchery(html);
    });

});
