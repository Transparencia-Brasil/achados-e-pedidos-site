function filtrar(){

	$("#CodigoPoder").val(checkboxToSequencia("CodigoPoderChk", ","));
	$("#CodigoNivelFederativo").val(checkboxToSequencia("CodigoNivelFederativoChk", ","));

	$("#CodigoTipoPedidoSituacao").val(checkboxToSequencia("CodigoTipoPedidoSituacaoChk", ","));

	$("#CodigoStatusPedido").val(checkboxToSequencia("CodigoStatusPedidoChk", ","));

	busca = $("#busca").val();
	$("#erroBusca").html("");
	if(busca.length >= 5){
		$("#textoBusca").val(busca);
	}

	$("#frmFiltro").submit();
}


//AO clicar adiciona mais um campo de busca enviado para.
$("#novoCampo").click(function(){
  total = $("#env-para").children('input[type="text"]').length;
  if(total >= 1){
      $('#removerCampo').css("display", "block");
  }
  if(total >9){
    $("#env-para").append("<span class='error'>É permitido apenas 10 órgãos por interação</span>");
    return;
  }
  $("#env-para").append('<input type="text" list="fieldListEnviadoPara" datalist="fieldListEnviadoPara" class="form-control inp-marg" id="enviadoPara'+(total + 1)+'">');
});

$("#removerCampo").click(function(){
  $('#env-para input[type="text"]:last-child').remove();
});


$(document).ready(function(){

	$("#btnFiltrarOrgaoPublico").click(function(e){
		e.preventDefault();
		filtrar();
	});

	$("#btnFiltrarSituacaoPedido").click(function(e){
		e.preventDefault();
		filtrar();
	});

	$("#btnFiltrarStatusPedido").click(function(e){
		e.preventDefault();
		filtrar();
	});

	$("#btnFiltrarData").click(function(e){
		e.preventDefault();
		filtrar();
	});

	$("#busca").bind("keypress", function(event){
		if(event.which == 13)
		{
			$("#btnFiltrarTextoBusca").trigger("click");
		}
	});

	$("#btnFiltrarTextoBusca").click(function(e){
		e.preventDefault();

		$("#erroBusca").html("");
		busca = $("#busca").val();

		if(busca.length <= 5){
			$("#erroBusca").html("Digite ao menos 5 letras para a busca");
		}else{
			$("#textoBusca").val(busca);
			filtrar();
		}
	});

	$(".pagination > li").click(function(){
		pagina = $(this).data("val");

		$("#pagina").val(pagina);

		filtrar();
	});

	$("#dataFinal").mask("99/99/9999");
	$("#dataInicial").mask("99/99/9999");

});
