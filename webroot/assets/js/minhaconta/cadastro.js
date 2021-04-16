$(document).ready(function(){

	$("#data_nascimento").mask("99/99/9999");


	$("#documento").trigger('focus');

	$("#documento").focus(function(e){

		var valor = $(this).val();
		valor = valor.replace(/[^0-9]/g, "");

		$(this).mask('99999999999999');

		$(this).val(valor);		
	});

	$("#documento").focusout(function(e){
		var valor = $(this).val();

		valor = valor.replace(/[^0-9]/g, "");
		
		if(valor.length < 11 || (valor.length > 11 && valor.length < 14)){
			$(this).mask('99999999999999');
			
			if($(this).parent().find('span').length > 0)
				$(this).parent().find('span').html('Digite o documento corretamente');
			else
				$(this).parent().append('<span class="error">Digite o documento corretamente.</span>');
		}else if(valor.length == 11){
			$(this).mask("999.999.999-99");
		}else{
			$(this).val(valor).mask("99.999.999/9999-99");
		}
		
	});
});