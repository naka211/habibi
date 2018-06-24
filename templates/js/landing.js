$(document).ready(function () {
   $("#fromAge").change(function () {
       $("#toAge").prop('disabled', 'disabled');
       $.ajax({
            method: "POST",
            url: base_url+"ajax/generateToAgeSelection",
            data: { fromAge: this.value, csrf_site_name: token_value },
            success: function (html) {
                $('#toAge').find('option').remove().end().append(html);
                $("#toAge").prop('disabled', false);
            }
       });
       //alert(this.val());
   });

    $('.regionSelection, .ethnicSelection').multiselect({
        columns: 2,
        texts:{
            'selectAll': 'Vælg alle',
            'unselectAll': 'Fravælg alle',
            'selectedOptions': ' valgt'
        },
        selectAll: true,
        maxPlaceholderOpts: 1
    });

});