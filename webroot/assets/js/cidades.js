$(document).ready(function(){

	$("#CodigoPais").change(function(i){
		codigo = $(this).val();

		$.ajax({
			url : base_url + 'json/ufs/' + codigo,
			method : 'POST',
			data : {},
			dataType : 'json',
			success : function(data){

				if(data == null || data == undefined){
					console.log('Erro ao pesquisar estados');
				}
				else if(data.status != null && data.status == 3){
					$("#CodigoUF").hide();
					$("#CodigoCidade").hide();
				}else{
					var options = "";

					$("#CodigoUF").html('');

					$(data).each(function(i, j, k){
						options += '<option value="' + $(this)[0].Sigla + '">' + $(this)[0].Nome + '</option>';
					});

					$("#CodigoUF").html(options);

					$("#CodigoUF").show();
					$("#CodigoCidade").show();

					if(siglaUF != undefined && siglaUF != null && siglaUF.length > 0){
						$("#CodigoUF option[value=" + siglaUF + "]").attr('selected','selected');
					}

					$("#CodigoUF").trigger('change');
				}
			},
			error : function(erro, erro1, erro2)
			{
				console.log('Erro ao pesquisar estados');
			}
		});
	});

	$("#CodigoPais").trigger('change');

	$("#CodigoUF").change(function(i){
		sigla = $(this).val();

		$.ajax({
			url : base_url + 'json/cidades/' + sigla,
			method : 'POST',
			data : {},
			dataType : 'json',
			success : function(data){

				if(data.erro != null){
					console.log(data.msg);
				}else{
					var options = "";

					$("#CodigoCidade").html('');

					options += '<option value="">Selecione...</option>';
					$(data).each(function(i){
						options += '<option value="' + $(this)[0].Codigo + '">' + $(this)[0].Nome + '</option>';
					});

					$("#CodigoCidade").html(options);

					if(codigoCidade != undefined && codigoCidade > 0)
						$("#CodigoCidade option[value=" + codigoCidade + "]").attr('selected','selected');
				}
			},
			error : function(erro, erro1, erro2)
			{
				console.log('Erro ao pesquisar cidades');
			}
		});
	});

});