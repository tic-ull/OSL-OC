jQuery(function($) {
  function searchProducts() {
    $('.products-list').fadeOut(250);
    $('#dvloader').fadeIn(500);
    $.ajax({
      type: 'POST', 
      url: huge_it_catalog_gs_vars.ajaxurl,
      data: {
        action: 'huge_it_catalog_listProducts',
        from_product: document.getElementById('fromSearchProduct').value,
      },
      success: function( data ) {
          $("#dvloader").fadeOut(1);
          $('.products-list').html( data );
          $('.products-list').fadeIn(500);
          $('.ui-autocomplete').hide();
      },
      error: function( jqXHR, textStatus, errorThrown ) {
        if (jqXHR.status === 404) {
          console.log('Requested page not found [404]');
        } else if (jqXHR.status == 0) {
          console.log('Not connect: Verify Network.');
        } else if (jqXHR.status == 500) {
            console.log('Internal Server Error [500].');
        } else if (textStatus === 'parsererror') {
          console.log('Requested JSON parse failed.');
        } else if (textStatus === 'timeout') {
          console.log('Time out error.');
        } else if (textStatus === 'abort') {
          console.log('Ajax request aborted.');
        } else {
          console.log('Uncaught Error: ' + jqXHR.responseText);
        }
      }
    });
  }
  $('.show_software').on('click', function(event) {
    event.preventDefault();
    searchProducts();
  });

  $('#fromSearchProduct').autocomplete({
    source: function (request, response) {
      $.ajax({
        type: 'POST', 
        url: huge_it_catalog_gs_vars.ajaxurl,
        dataType: 'json',
        data: {
          action: 'huge_it_catalog_productNames',
          from_product: document.getElementById('fromSearchProduct').value
        },
        success: function (data) {
          response( data );
        }
      })
    },
    select: function(event) {
      event.preventDefault();
      searchProducts();
    }
  });
});