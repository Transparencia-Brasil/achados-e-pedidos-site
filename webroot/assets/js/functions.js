function checkboxToSequencia(nome, delimitador){

	checkboxes = $("input[name='" + nome +"']:checked");

	if(checkboxes == null || checkboxes == undefined)
		return "";
	
	elementos = [];
	$.each(checkboxes, function(i, j){
		elementos.push($(j).val());
	});

	if(elementos.length > 0)
		return elementos.join(delimitador);

	return "";
}

$(document).ready(function(){


	$(".form-control,input[type='radio']").bind('keyup change click', function(){
		$(this).parents('.t-info').first().children("span.error").html("");
		$(this).siblings("span.error").html("");
	});

	(function(){

    var parallax = document.querySelectorAll(".parallax"),
        speed = 0.5;

    window.onscroll = function(){
      [].slice.call(parallax).forEach(function(el,i){

        var windowYOffset = window.pageYOffset,
            elBackgrounPos = "50% " + (windowYOffset * speed) + "px";

        el.style.backgroundPosition = elBackgrounPos;

      });
    };

  })();

  $('.slider-Graficos').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      infinite: false,
      autoplay: false,
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false
        }
      },
      {
        breakpoint: 320,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });

  $('.next-step, .prev-step').on('click', function (e){
     var $activeTab = $('.tab-pane.active');

     $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

     if ( $(e.target).hasClass('next-step') )
     {
        var nextTab = $activeTab.next('.tab-pane');
        var formstep = $activeTab.next('.tab-pane').attr('formstep');
        console.log(formstep + " " + nextTab.attr("id"));
        $('button[formstep="'+ formstep +'"]').addClass('btn-info').removeClass('btn-default');
        //$('[href="#'+ nextTab +'"]').tab('show');
        $activeTab.removeClass("active").removeClass("in")
        nextTab.addClass("active").addClass("in")
     }
     else
     {
        var prevTab = $activeTab.prev('.tab-pane');
        var formstep = $activeTab.prev('.tab-pane').attr('formstep');
        console.log(formstep + " - " + prevTab.attr("id"));
        $('button[formstep="'+ formstep +'"]').addClass('btn-info').removeClass('btn-default');
        //$('[href="#'+ nextTab +'"]').tab('show');
        $activeTab.removeClass("active").removeClass("in")
        prevTab.addClass("active").addClass("in")
     }
   });

  $('#BSbtnInfoInserir').filestyle({
    buttonName : 'btn-info',
        buttonText : ' Anexar arquivos.'
  }); 

  var d = new Date();
  $.datepicker.regional['pt-BR'] = {
    closeText: 'Fechar',
    prevText: '&lt;Anterior',
    nextText: 'Próximo&gt;',
    currentText: 'Hoje',
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
    'Jul','Ago','Set','Out','Nov','Dez'],
    dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
    dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 0,
    isRTL: false,
    showMonthAfterYear: false,
    maxDate:new Date(d),
    yearSuffix: ''};
  $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

  $('.datePicker').datepicker().on('changeDate', function(e) {
      // Revalidate the date field
      $('#eventForm').formValidation('revalidateField', 'date');
  });

  // Menu Dropdown
  $("li.dropdownMenu").click(function(){
      $(".dropdown-menu2").toggle();
  });

  $('#map_canvas1').addClass('scrolloff'); // set the pointer events to none on doc ready
  $('#canvas1').on('click', function () {
      $('#map_canvas1').removeClass('scrolloff'); // set the pointer events true on click
  });

  // you want to disable pointer events when the mouse leave the canvas area;

  $("#map_canvas1").mouseleave(function () {
      $('#map_canvas1').addClass('scrolloff'); // set the pointer events to none when mouse leaves the map area
  });

  //Select representantes
  $("#id_tipo_contacto").on('change', function(){
      $('.representantesEstado').css('display', 'none');
      $('#' + this.value).css('display', 'block');
  });

  $('[data-toggle=popover]').popover({
     content: $('#popover-table').html(),
     html: true,
     trigger: 'hover'
  });
});