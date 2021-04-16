function moderar(codigo, status)
{
	obj = $("div[data-val='"+codigo+"']");

	if(codigo <= 0 || (status < 1 || status > 4))
	{
		$(obj).find('.retorno').html('Erro ao atualizar elemento.');
	}else{
		
		$.ajax({
			url : '/admin/moderacao/moderar/' + codigo + '/' + status,
			method : 'POST',
			data : { },
			dataType : 'json',
			success : function(data){

				if(data.erro != null){
					$(obj).find('.retorno').html(data.msg);
				}else{
					$(obj).find('.retorno').html('Elemento moderado!');
					setTimeout(function() { 
						$(obj).hide('slow');
					}, 3000);
				}
			},
			error : function(erro, erro1, erro2)
			{
				$(obj).find('.retorno').html("Erro interno. Por favor tente novamente mais tarde");
			}
		});
		
	}
}

$(document).ready(function(){

});