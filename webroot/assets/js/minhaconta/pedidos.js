function novoCadastroOrgao()
{
	$("#pesquisa").hide();
	$(".resultadoBusca").hide();
	$(".resultadoBuscaNao").hide();
	$(".cadastraNovo").show();
}

function pesquisarAgente(){
	$("#pesquisa").show();
	$(".resultadoBusca").hide();
	$(".resultadoBuscaNao").show();
	$(".cadastraNovo").hide();
}

function selecionarAgente(obj){

	var codigo = obj.codigo;

	if(codigo > 0){
		nome = obj.nome;
		descricao = obj.descricao;

		$("#nomeAgenteBusca").html(nome);
		$("#descricaoAgenteBusca").html(descricao);

		$("#nomeAgentePedido").html('<strong>Pedido enviado para:</strong> ' + nome);

		$(".resultadoBusca").show();
		$("#codigoAgente").val(codigo);
	}else{
		$('.error').html('Erro interno. Por favor, tente novamente mais tarde.');
	}
}

function selecionarAgenteSuperior(obj){

	var codigo = obj.codigo;

	if(codigo > 0){
		$("#codigoOrgaoPublico").val(codigo);
	}else{
		$('.error').html('Erro interno. Por favor, tente novamente mais tarde.');
	}
}

function novoAgente(){

	nome = $("#nomeAgente").val();
	agente = $("#codigoOrgaoPublico").val();

	if(agente == null || agente == undefined || agente <= 0){
		$(".resultadoBuscaSuperiorNao").html('Você deve escolher um órgão superior já cadastrado');
	}
	//2017-01-24 Paulo Campos: tirando validação por length (Correios tem menos que 10 caracteres.)
	//else if(nome != null && nome != undefined && nome.length > 10){
	else if(nome != null && nome != undefined){
		$.ajax({
			url : base_url + 'json/novoAgente/' + agente + '/' + nome,
			method : 'POST',
			data : {},
			dataType : 'json',
			success : function(data){

				if(data.erro != null){
					$('#nomeAgenteError').html(data.msg);
				}else{
					
					codigoNovo = data.Codigo;

					$("#codigoAgente").val(codigoNovo);
					$("#nomeAgentePedido").html('<strong>Pedido enviado para:</strong> ' + data.Nome);
					
					$('#passo1').click();
				}
			},
			error : function(erro, erro1, erro2)
			{
				$('#nomeAgenteError').html("Erro ao salvar agente. Por favor, tente novamente mais tarde");
			}
		});
	}else{
		$('#nomeAgenteError').html("Digite ao menos 10 caracteres para o nome do Órgão Público.");
	}
}

$(document).ready(function(){
	var codigoAgenteAtual = $("#codigoAgente").val();

	if(codigoAgenteAtual != null && codigoAgenteAtual != undefined){
		codigoAgenteAtual = parseInt(codigoAgenteAtual, 10);

		if(codigoAgenteAtual > 0){
			$("#menu2").addClass('active in');
		}else{
			$("#menu1").addClass('active in');
		}
	}else{
		$("#menu1").addClass('active in');
	}

	$("#btnPesquisarAgente").autocomplete({
		source: base_url + 'json/agentes/' + 1,
		minLength:3,
		delay:500,
      	dataType: "json",
        select: function( event, ui ) {
        	
        	$(this).val(ui.item.label);
			selecionarAgente({ codigo : ui.item.value, nome : ui.item.label, descricao : ui.item.desc  });
        	return false;
      	},
      	focus : function(event, ui){
      		$(".resultadoBusca").hide();
			
      		$(this).val(ui.item.label);
      		return false;
      	}
    });

    $("#orgaoSuperior").autocomplete({
      	minLength: 0,
      	source: base_url + 'json/agentes/' + 2, 
      	dataType: "json",
        select: function( event, ui ) {
        	$(this).val(ui.item.label);
			selecionarAgenteSuperior({ codigo : ui.item.value, nome : ui.item.label, descricao : ui.item.desc  });
        	return false;
      	},
      	focus : function(event, ui){
      		$(this).val(ui.item.label);
      		return false;
      	}
    });

    $("#dataEnvio").mask("99/99/9999");
});