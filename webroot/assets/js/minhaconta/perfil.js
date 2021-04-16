$(document).ready(function(){
	$("#data_nascimento").mask("99/99/9999");

	$("#btnExcluirConta").click(function(){

		if(confirm('Tem certeza que deseja excluir sua conta?'))
		{
			$("#frmExcluirConta").submit();
		}
	});

	$("#optinNewsletter").click(function(){

		status = $(this).prop('checked') ? 1 : 0;
		$.ajax({
			url : base_url + "minhaconta/perfil/toggleOptin/" + status,
			method : 'POST',
			success : function(data){
				
			},
			error : function(a, b, c){

			}
		});
	});
});