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
    var _componentFullCalendarEvents = function (url, droppable_status) {
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

        // Add switcher for events removal
        // var remove = document.querySelector(".form-check-input-switchery");
        // var removeInit = new Switchery(remove);

        // External events
        // ------------------------------
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (bypassEventData) {
                // Initialize the calendar
                $(".fullcalendar-external").fullCalendar({
                    header: {
                        left: "prev,next today",
                        center: "title",
                        right: "month,agendaWeek,agendaDay,listWeek",
                    },
                    timezone: "local",
                    editable: droppable_status,
                    defaultDate: new Date(),
                    events: bypassEventData,
                    locale: "ru",
                    allDaySlot: true,
                    droppable: droppable_status, // this allows things to be dropped onto the calendar
                    drop: function (info, allDay) {
                        CalendarDrop(info, this, allDay);
                    },
                    eventReceive: function (info) {
                        $(".fullcalendar-external").fullCalendar(
                            "removeEvents",
                            info._id
                        );
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
            },
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

            // Tolltip
            var item = this;

            $.ajax({
                type: "GET",
                url: bypassDataUrl,
                data: { pk: item.dataset.id },
                success: function (result) {
                    $(item).popover({
                        trigger: "hover",
                        popup: "popover",
                        placement: "top",
                        html: true,
                        title: item.innerHTML,
                        content: result,
                    });
                },
            });
        });
    };

    //
    // Return objects assigned to module
    //

    return {
        init: function (url) {
            _componentFullCalendarEvents(url, true);
        },
        block: function (url) {
            _componentFullCalendarEvents(url, false);
        },
    };
})();
