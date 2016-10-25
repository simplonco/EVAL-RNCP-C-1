$(function () {
    // Side Bar Toggle
    $('.hide-sidebar').click(function () {
        $('#sidebar').hide('fast', function () {
            $('#content').removeClass('span9');
            $('#content').addClass('span12');
            $('.hide-sidebar').hide();
            $('.show-sidebar').show();
        });
    });

    $('.show-sidebar').click(function () {
        $('#content').removeClass('span12');
        $('#content').addClass('span9');
        $('.show-sidebar').hide();
        $('.hide-sidebar').show();
        $('#sidebar').show('fast');
    });
});

$(function () {
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        monthNamesShort: ["Janv", "Fevr", "Mars", "Avril", "Mai", "Juin", "Juil", "Aout", "Sept", "Oct", "Nov", "Dec"],
        firstDay: 1,
        yearRange: "2016:2116",
        minDate: 2,
        changeMonth: true,
        beforeShowDay: function(date) {
          var day = date.getDay();
          var array = jQuery.datepicker.formatDate('dd-mm-yy', array);
          var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
          return [(array.indexOf(string) == -1)];
        }
    });
});
