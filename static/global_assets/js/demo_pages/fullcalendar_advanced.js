/* ------------------------------------------------------------------------------
 *
 *  # Fullcalendar advanced options
 *
 *  Demo JS code for extra_fullcalendar_advanced.html page
 *
 * ---------------------------------------------------------------------------- */

// Setup module
// ------------------------------

var FullCalendarAdvanced = (function () {
    //
    // Setup module components
    //

    // External events
    var _componentFullCalendarEvents = function () {
        if (
            !$().fullCalendar ||
            typeof Switchery == "undefined" ||
            !$().draggable
        ) {
            console.warn(
                "Warning - fullcalendar.min.js, switchery.min.js or jQuery UI is not loaded."
            );
            return;
        }

        // Add demo events
        // ------------------------------

        // External events
        // ------------------------------

        // Add switcher for events removal
        // var remove = document.querySelector(".form-check-input-switchery");
        // var removeInit = new Switchery(remove);

        // Initialize the calendar
        $(".fullcalendar-external").fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay",
            },
            timeZone: "UTC",
            editable: true,
            defaultDate: new Date(),
            events: eventColors,
            locale: "ru",
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function (info) {
                CalendarDrop(info, this);
            },
            eventDrop: function (info) {
                CalendarEventDropAndResize(info, this);
            },
            eventResize: function (info) {
                CalendarEventDropAndResize(info, this);
            },
            // eventRender: function (info) {
            //     console.log("render");
            // },
            eventClick: function (info) {
                CalendarEventClick(info, this);
            },
            isRTL: $("html").attr("dir") == "rtl" ? true : false,
        });

        // Initialize the external events
        $("#external-events .fc-event").each(function () {
            // Different colors for events
            $(this).css({
                backgroundColor: $(this).data("color"),
                borderColor: $(this).data("color"),
            });

            // Store data so the calendar knows to render an event upon drop
            $(this).data("event", {
                title: $.trim($(this).html()), // use the element's text as the event title
                color: $(this).data("color"),
                stick: true, // maintain when user navigates (see docs on the renderEvent method)
            });

            // Make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0, // original position after the drag
            });
        });
    };

    //
    // Return objects assigned to module
    //

    return {
        init: function () {
            _componentFullCalendarEvents();
        },
    };
})();

// Initialize module
// ------------------------------

document.addEventListener("DOMContentLoaded", function () {
    FullCalendarAdvanced.init();
});
