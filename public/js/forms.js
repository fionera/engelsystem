/**
 * Sets all checkboxes to the wanted state
 *
 * @param {string} id Id of the element containing all the checkboxes
 * @param {bool} checked True if the checkboxes should be checked
 */
function checkAll(id, checked) {
    $("#" + id + " input[type='checkbox']").each(function () {
        this.checked = checked;
    });
}

/**
 * Sets the checkboxes according to the given type
 *
 * @param {string} id The elements ID
 * @param {list} shifts_list A list of numbers
 */
function checkOwnTypes(id, shifts_list) {
    $("#" + id + " input[type='checkbox']").each(function () {
        this.checked = $.inArray(parseInt(this.value), shifts_list) != -1;
    });
}

/**
 * @param {moment} date
 */
function formatDay(date) {
    return date.format("YYYY-MM-DD");
}

/**
 * @param {moment} date
 */
function formatTime(date) {
    return date.format("HH:mm");
}

/**
 * @param {moment} from
 * @param {moment} to
 */
function setInput(from, to) {
    var fromDay = $("#start_day"), fromTime = $("#start_time"), toDay = $("#end_day"), toTime = $("#end_time");

    fromDay.val(formatDay(from));
    fromTime.val(formatTime(from));

    toDay.val(formatDay(to));
    toTime.val(formatTime(to));
}

function setDay(days) {
    days = days || 0;

    var from = moment();
    from.hours(0).minutes(0).seconds(0);

    from.add(days, "d");

    var to = from.clone();
    to.hours(23).minutes(59);

    setInput(from, to);
}

function setHours(hours) {
    hours = hours || 1;

    var from = moment();
    var to = from.clone();

    to.add(hours, "h");
    if (to < from) {
        setInput(to, from);
        return;
    }

    setInput(from, to);
}

function set_to_now(id) {
    document.getElementById(id + '_time').value = moment().format('HH:mm');
    var days = document.getElementById(id + '_date').getElementsByTagName('option');
    for (var i = 0; i < days.length; i++) {
        if (days[i].value === moment().format('YYYY-MM-DD')) {
            days[i].selected = true;
        }
    }
}

$(function () {
    /**
     * Disable every submit button after clicking (to prevent double-clicking)
     */
    // $("form").submit(function (ev) {
    //     $("input[type='submit']").prop("readonly", true).addClass("disabled");
    //     return true;
    // });

    $('#Select').on('change', function (e) {
        $('.tab-pane').hide();
        $('.tab-pane').eq($(this).val()).show();
    });

    // $(".dropdown-menu").css("max-height", function () {
    //     return ($(window).height() - 50) + "px";
    // }).css("overflow-y", "scroll");

    $('.dropdown-menu li').click(function () {
        $('li').removeClass('active');
        $(this).parent().parent().find('button').get(0).innerHTML = $(this).get(0).innerText + '<span class="caret"></span>';
    })
});
