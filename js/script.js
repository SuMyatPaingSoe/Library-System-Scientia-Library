$(document).ready( function () {

    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    $("[id=list_table]").DataTable({
      responsive: true
    });

    $("[id=normal_table]").DataTable({
      responsive: true,
      paging: false,
      searching: false
    });

} );
