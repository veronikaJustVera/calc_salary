var properties = [
    'order',
    'employee',
    'role',
    'month',
    'salary',
];

$.each( properties, function( i, val ) {

    var orderClass = '';

    $("#" + val).click(function(e){
        e.preventDefault();
        $('.filter__link.filter__link--active').not(this).removeClass('filter__link--active');
        $(this).toggleClass('filter__link--active');
        $('.filter__link').removeClass('asc desc');

        if(orderClass == 'desc' || orderClass == '') {
                $(this).addClass('asc');
                orderClass = 'asc';
        } else {
            $(this).addClass('desc');
            orderClass = 'desc';
        }

        var parent = $(this).closest('.header__item');
            var index = $(".header__item").index(parent);
        var $table = $('.table-content');
        var rows = $table.find('.table-row').get();
        var isSelected = $(this).hasClass('filter__link--active');
        var isNumber = $(this).hasClass('filter__link--number');
        var isDate = $(this).hasClass('filter__link--date');

        rows.sort(function(a, b){

            var x = $(a).find('.table-data').eq(index).text();
                var y = $(b).find('.table-data').eq(index).text();

            if(isNumber) {

                if(isSelected) {
                    return x - y;
                } else {
                    return y - x;
                }

            } else if (isDate){

                if(isSelected) {
                    return new Date(x) > new Date(y) ? 1 : -1;
                } else {
                    return new Date(y) > new Date(x) ? 1 : -1;
                }
            }
            else {

                if(isSelected) {
                    if(x < y) return -1;
                    if(x > y) return 1;
                    return 0;
                } else {
                    if(x > y) return -1;
                    if(x < y) return 1;
                    return 0;
                }
            }
            });

        $.each(rows, function(index,row) {
            $table.append(row);
        });

        return false;
    });

});
