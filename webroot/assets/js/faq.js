function filtrarFaq(id)
{
	if(id <= 0)
		$(".faq-elementos").show();
	else{
		// esconde todos os itens
		$(".faq-elementos").hide();
		// exibe apenas a categoria selecionada
		$(".faq-elementos[data-val='"+id+"']").show();
	}
}

function pesquisarDados(texto)
{
	if(texto.length <= 3){
		$(".faq-elementos").show();
	}else{
		// esconde todos os elementos
		$(".faq-elementos").hide();
		$(".faq-elementos > .panel").hide();
		// efetua a pesquisa por comparação
		$(".faq-elementos > .panel").each(function(i, j){
			
			if($(j).find('.panel-title').text().toLowerCase().indexOf(texto) > -1 || 
				$(j).find('.panel-body').text().toLowerCase().indexOf(texto) > -1)
			{
				$(j).parent().show();
				$(j).show();
			}
		});
	}
}

$(document).ready(function(){

	$("#btnPesquisarFaq").bind('keypress keyup', function(){
		var texto = $(this).val().toLowerCase();
		pesquisarDados(texto);
	});

})