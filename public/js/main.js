$(document).ready(function(){
    "use strict";

    $('#plain').css('font-family', 'Consolas');

    $('.container-plain').hide();
    $('#preview-btn').hide();
    
    tinymce.init({
        selector: 'textarea#editor',
        skin: 'bootstrap',
        plugins: 'lists, link, image, media',
        toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        menubar: false
    });

	var window_width 	 = $(window).width(),
	window_height 		 = window.innerHeight,
	header_height 		 = $(".default-header").height(),
	header_height_static = $(".site-header.static").outerHeight(),
	fitscreen 			 = window_height - header_height;


	$(".fullscreen").css("height", window_height)
	$(".fitscreen").css("height", fitscreen);

     
     // -------   Active Mobile Menu-----//

    $(".menu-bar").on('click', function(e){
        e.preventDefault();
        $("nav").toggleClass('hide');
        $("span", this).toggleClass("lnr-menu lnr-cross");
        $(".main-menu").addClass('mobile-menu');
    });
     
    $('select').niceSelect();
    $('.img-pop-up').magnificPopup({
        type: 'image',
        gallery:{
        enabled:true
        }
    });

    $('.active-works-carousel').owlCarousel({
        center: true,
        items:2,
        loop:true,
        margin: 100,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1,
            },
            768: {
                items: 2,
            }
        }
    });
    // Add smooth scrolling to Menu links
    $(".main-menu li a, .smooth").on('click', function(event) {
            if (this.hash !== "") {
              event.preventDefault();
              var hash = this.hash;
              $('html, body').animate({
                scrollTop: $(hash).offset().top - (-10)
            }, 600, function(){
             
                window.location.hash = hash;
            });
        } 
    });

    $(document).ready(function() {
        $('#mc_embed_signup').find('form').ajaxChimp();
    });

    $('#type').on('change', function() {
        if (this.value === '1') {
            $('#container-editor').hide();
            $('.container-plain').show();
            $('#preview-btn').show();
        } else {
            $('.container-plain').hide();
            $('#container-editor').show();
            $('#preview-btn').hide();
        }
    });

    $('#preview-btn').on('click', function(event) {
        $('#viewer').html($('#plain').val());
    });

    $('.template-item').on('click', function() {
        var item = $(this).find('.card');

        var hasClass = item.hasClass('selected-item');

        $('.card-item').each(function( index ) {
            if ($(this).hasClass('selected-item')) {
                $(this).removeClass('selected-item');
            }
        });

        if (hasClass === false) {
            var template = $(this).find('p').text();
            item.addClass('selected-item');

            template = template.replace(' ', '_');
            while(template.indexOf(' ') !== -1) {
                template = template.replace(' ', '_');
            }

            $.ajax({
                type: 'GET',
                url: '/../templates/' + template + '.html',
                success: function(data) {
                    $('#plain').text(data);
                }
            });
        } else {
            $('#plain').text('');
        }

    });

    $('#send-mail').on('click', function(event) {
        if ($('#recipients').val() === '' || $('#recipients').val() === undefined) {
            $('#recipient-error').html(
                `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    The recipient list is mandatory.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`
            );
            event.preventDefault();
        }
    });
 });
