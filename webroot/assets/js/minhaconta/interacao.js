notaInput = null;

function toogleSeguir(co, ct, obj){
	
	if(!logado){
		$("#modalLogin").click();
	}
	else if(co <= 0 || ct <= 0){
		$(obj).closest(".error").html("Erro ao efetuar operação. Por favor tente novamente mais tarde");
	}
	else{
		$.ajax({
			url : base_url + 'json/toggleSeguir/' + ct + '/' + co,
			method : 'POST',
			data : { },
			dataType : 'json',
			success : function(data){

				if(data.erro != null){
					$(obj).siblings(".error").html(data.msg);
					$(obj).parents('.raizInteracao').find(".error").html(data.msg);
				}else{

					if($(obj).html() == "Seguir"){
						$(obj).html('Deixar de seguir');
					}else{
						$(obj).html('Seguir');
					}
				}
			},
			error : function(erro, erro1, erro2)
			{
				$(obj).siblings(".error").html("Erro interno. Por favor tente novamente mais tarde");
				$(obj).parents('.raizInteracao').find(".error").html("Erro interno. Por favor tente novamente mais tarde");
			}
		});
	}
}

$(document).ready(function(){

	$("#btnComentar").click(function(e)
	{
		e.preventDefault();
		co = $("#co").val();
		ct = $("#ct").val();
		texto = $("#textoComentario").val();

		if(!logado){
			$("#modalLogin").click();
		}
		else if(co <= 0 || ct <= 0){
			$("#erro_comentario").html("Erro ao salvar comentário. Por favor tente novamente mais tarde");
		}else if(texto.length < 10){
			$("#erro_comentario").html("Texto muito curto. Por favor, digite ao menos 10 caracteres.");
		}
		else{
			$.ajax({
				url : base_url + 'json/comentar/' + ct + '/' + co,
				method : 'POST',
				data : { texto : texto},
				dataType : 'json',
				success : function(data){

					if(data.erro != null){
						$('#erro_comentario').html(data.msg);
					}else{
						var sucesso = $('#comentario-sucesso-template').html();
    					$("#btnComentar").parents('.col-md-12').html(sucesso);
					}
				},
				error : function(erro, erro1, erro2)
				{
					$("#erro_comentario").html("Erro ao salvar comentário. Por favor tente novamente mais tarde");
				}
			});
		}
	});

	$("#btnPedidoRevisao").click(function(){
		cp = $("#co").val();
		texto = $("#textoRevisao").val();

		if(!logado){
			$("#modalLogin").click();
		}else if(cp <= 0){
			$("#erro_revisao").html("Erro ao salvar revisão. Por favor tente novamente mais tarde.");
		}else if(texto.length <= 30){
			$("#erro_revisao").html("Texto muito curto. Por favor, digite ao menos 30 caracteres.");
		}else{
			$.ajax({
				url : base_url + 'json/pedidoRevisao/' + cp,
				method : 'POST',
				data : { texto : texto},
				dataType : 'json',
				success : function(data){

					if(data.erro != null){
						$('#erro_revisao').html(data.msg);
					}else{
						$(".s-content").hide();
						$(".msg-success-content").show();
					}
				},
				error : function(erro, erro1, erro2)
				{
					$("#erro_revisao").html("Erro ao salvar revisão. Por favor tente novamente mais tarde");
				}
			});
		}
	});

	$("#btnToggleSeguir").click(function(e){
		e.preventDefault();
		co = $("#co").val();
		ct = $("#ct").val();

		toogleSeguir(co, ct, $(this));
	});

	$("input[name='fb']").click(function(){
		nota = $(this).val();

		co = $("#co").val();
		ct = $("#ct").val();

		if(!logado){
			$("#modalLogin").click();
		}
		else if(co == null || ct == null){
			$(this).siblings(".error").html("Erro ao avaliar.");
		}else{
			notaInput = $(this);
			$.ajax({
				url : base_url + 'json/avaliar/' + ct + '/' + co + '/' + nota,
				method : 'POST',
				data : { },
				dataType : 'json',
				success : function(data){

					if(data.erro != null){
						$(notaInput).parent().children(".error").html(data.msg);
					}else{
						// void
					}
				},
				error : function(erro, erro1, erro2)
				{
					$(notaInput).siblings(".error").html("Erro ao salvar avaliar.");
				}
			});
		}
	});
});