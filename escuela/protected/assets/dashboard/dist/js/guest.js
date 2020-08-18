$(document).ready(function(){


    $(".inicio").on('click',function(e){
        e.preventDefault();
        window.location.reload();
    });

    $(document).on('click','.inscripciones',function(e){
        e.preventDefault();
        $.ajax({
             type:'post',
             url: $(this).attr('href'),
             success: function(respuesta){
               $('.modal .modal-body').html(respuesta);
               $('.modal').modal('show'); 
             }
         });
    });

    $(document).on('click','.consultar-curso',function(e){
        e.preventDefault();
        $.ajax({
             type:'post',
             url: $(this).attr('href'),
             success: function(respuesta){
               $('.modal .modal-body').html(respuesta);
               $('.modal').modal('show'); 
             }
         });
    });

    $('#quienesSomos').on('click', function(e){
        e.preventDefault();
        animScrollTo("main",0);
        let text = $('.divQuienesSomos').html();
        $('.main').html('');
        $('.main').html(text);
    });

    $('#sucursales').on('click', function(e){
        e.preventDefault();
        animScrollTo("main",0);
        let text = $('.divSucursales').html();
        $('.main').html('');
        $('.main').html(text);
    });

   $('#carrerasCursos').on('click', function(e){
        e.preventDefault();
        animScrollTo("main",0);
        $.ajax({
            type:'post',
            url: $(this).attr('href'),
            success: function(respuesta){
                $('.main').html('');
                $('.main').html(respuesta);
            }
        });
    });
    //ver datells del cueros
    $(document).on('click','.cursoItem',function(e){
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            type:'post',
            url: $(this).data('url'),
            data: {id:id},
            success: function(respuesta){
                $('.main').html('');
                $('.main').html(respuesta);
            }
        });
    });

    $('#newsLetter').on('click', function(e){
        e.preventDefault();
        animScrollTo("footer",0);
    });

    function animScrollTo(id, speed){
        var etop = $('.' + id).offset().top-100;
        $('html, body').animate({
          scrollTop: etop
        }, speed);

    }

    $('#login').on('click', function(e) {
        e.preventDefault();
      $.ajax({
           type:'post',
           url: $(this).attr('href'),
           success: function(respuesta){
             $('.modal .modal-body').html(respuesta);
             $('.modal').modal('show'); 
           }
       });

    });
    //llamando al form login
    $(document).on('click','#formLogin',function(e){
        e.preventDefault();
        $("#login").click();
    });

    //llamando al form recuperar clave
    $(document).on('click','.formRecuperar',function(e) {
        e.preventDefault();
       $.ajax({
           type:'post',
           url:$(this).attr('href'),
           success: function(respuesta) {
             $('.modal .modal-body').html('');
             $('.modal .modal-body').html(respuesta);
             //$('.modal').modal('show');   
           }
       });
    });

    $(document).on('click','#divRecuperarClaveClose',function(e){
        e.preventDefault();
        $('.modal').modal('hide');

    });


    //cerrar el popup de youtube
    $('#imgPopUpCross').on('click',function(e){
        e.preventDefault();
        $('#divOverlay').hide();
        $('#divPopUpInicial').hide();
        $('#iframeYoutubePopUpInicial').hide();
        $(this).hide();
    });


});
