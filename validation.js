function toggleDate() {
    var element = document.getElementById("specialDate");
    element.classList.toggle("arrDate");
}

let $j = jQuery.noConflict();

let dateFormat = "mm/dd/yy",

    beginDate = $j( "#date1" )
        .datepicker({
            minDate: 0,
            changeMonth: true,
            numberOfMonths: 1
        })
        .on( "change", function() {
            endDate.datepicker( "option", "minDate", getDate( this ) );
        }),

    endDate = $j( "#date2" )
        .datepicker({
            minDate: 0,
            changeMonth: true,
            numberOfMonths: 1
        })
        .on( "change", function() {
            beginDate.datepicker( "option", "maxDate", getDate( this ) );
        });
    
    
    function getDate( element ) {
        let date;
        try {
            date = $j.datepicker.parseDate( dateFormat, element.value );
        }
        catch( error ) {
            date = null;
        }
        return date;
    }