jQuery(function($) {
  $('.show_software').on('click', function(event) {
  event.preventDefault();
        $.ajax( {
            type: 'POST', 
            url: hit_gs_vars.ajaxurl,
            data: {
                action: 'huge_it_catalog_listProducts',
                from_product: document.getElementById('fromSearchProduct').value,
            },
            success: function( data ) {
                jQuery('.products-list').html( data );
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                if (jqXHR.status === 404) {

                    alert('Requested page not found [404]');
        
                  } else if (jqXHR.status == 0) {
                    alert('Not connect: Verify Network.');
                    
        
                  } else if (jqXHR.status == 500) {
        
                    alert('Internal Server Error [500].');
        
                  } else if (textStatus === 'parsererror') {
        
                    alert('Requested JSON parse failed.');
        
                  } else if (textStatus === 'timeout') {
        
                    alert('Time out error.');
        
                  } else if (textStatus === 'abort') {
        
                    alert('Ajax request aborted.');
        
                  } else {
        
                    alert('Uncaught Error: ' + jqXHR.responseText);
        
                  }
            }
        } );
      });
    });