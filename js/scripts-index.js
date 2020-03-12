$('document').ready(function () {

    "use strict";   
    
    $('#search').on('input', function() {
        $('.loader').show();       
    });
    
    $('#search').keyup(buscar);
    
    var delayTimer;
    
    function buscar() {
        var data = $('#search').val();
        $('.hide').hide();
        $('.empty').hide();
        $('.main-search h2').hide();
        $('.main-search h4').hide();
        $('.main-search').css({
            'background':'#ffffff'
        });  
        $('.search-bar').hide();
        $('.search-bar').css({
            'margin-top':'-75px'
        });
        $('.search-bar input').css({
            'width' : '70%',
            '-webkit-box-shadow': 'none',
            '-moz-box-shadow': 'none',
            'box-shadow': 'none',
            'border':'.5px solid #f5f5f5'
        });
        $('.search-bar button').css({
            '-webkit-box-shadow': 'none',
            '-moz-box-shadow': 'none',
            'box-shadow': 'none'
        });
        $('.search-bar').addClass('slide');
        $('.search-bar').show();
        
        if (data == '') {
            $('#display').hide();
            $('.empty').show();
            $('.loader').hide();
        } else {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "includes/funciones/search-ajax.php",
                    data: {
                        search_input: data
                    },
                    success: function (html) {
                        $('#display').html(html).show();
                        $('.loader').hide();
                    }
                    ,
                    async: false
                });
            }, 1000); 
        }
    }
    
});
