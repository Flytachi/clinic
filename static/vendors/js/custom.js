
var Swit = function() {


    var _componentSwit = function() {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.swit'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
    };

    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSwit();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Swit.init();
});
