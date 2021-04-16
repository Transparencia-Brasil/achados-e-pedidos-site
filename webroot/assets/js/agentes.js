function filtrar(){
	$("#CodigoPoder").val(checkboxToSequencia("CodigoPoderChk", ","));
	$("#CodigoNivelFederativo").val(checkboxToSequencia("CodigoNivelFederativoChk", ","));

	busca = $("#busca").val();
	if(busca.length >= 5){
		$("#textoBusca").val(busca);
	}

	$("#frmFiltro").submit();
}

$(document).ready(function(){

	$("#btnFiltrarPoder").click(function(e){
		e.preventDefault();
		filtrar();
	});

	$("#btnFiltrarNivelFederativo").click(function(e){
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

		$("#busca").siblings("span").html("");
		busca = $("#busca").val();

		if(busca.length <= 5){
			$("#busca").siblings("span").html("Digite ao menos 5 letras para a busca");
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

});