$(function(){
        var currencies = new Array();
        var url = $('#url_autocomplete').val();
        $.ajax({
            type: 'GET',
            url: url,
            data: $('#autocomplete').val(),
            success: function(data){
                var registros = JSON.parse(data);

                var contador = 0;
                var totalElements = registros.length;
                var count = 0;
                var i;

                for (i in registros) {
                    if (registros.hasOwnProperty(i)) {
                        currencies.push({'value': registros[i]});
                        count++;
                    }
                }
            },
            error: function(data){
                console.log('error');
                console.log(data);
            }
        });


  // setup autocomplete function pulling from currencies[] array
  $('.autocomplete').autocomplete({
    lookup: currencies,
    onSelect: function (suggestion) {
      var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ';
      $('#outputcontent').html(thehtml);
    }
  });


});
