$(document).ready(function(){

	//valida tamanho do arquivo
	$("#arquivos").children('input[type="file"]').bind('change', function() {
	  validarTamanhoArquivo(this.files[0]);
	});

	//Valida o lote de arquivos enviados.
	$("#frmPedidoInteracao,#update-form,#update-form").submit(function(event){

		var arquivos = $("#arquivos").children('input[type="file"]');
		var arquivos_hidden = $("#arquivos").children('input[name="arquivos_hidden[]"]');

		if (arquivos_hidden.length > 0) {
			$.merge(arquivos,arquivos_hidden);
		}
	
		 //Se o tamanho total foi superior a 900 mb ele não envia o formulário
		//  if(!validarTamanhoTotalArquivos(arquivos)){
		//  	$("#arquivos").append("<span class='error'>Os arquivos ultrupassaram o Tamanho de 900MB por interação.</span>");
		//  	//reseta os arquivos.
		//  	$("#arquivos").wrap('<form>').closest('form').get(0).reset();
		//  	event.preventDefault();
		//  	event.stopImmediatePropagation();
		//  	return false;
		//  }


	});

	//AO clicar adiciona mais anexos.
	$("#novoArquivo").click(function(){

		total = $("#arquivos").children('input[type="file"]').length;

		if(total >1){
			$("#arquivos").append("<span class='error'>Só é permitido 2 arquivos por interação</span>");
			return;
		}
		
		$("#arquivos").append('<input type="file" name="arquivos[]" accept=".pdf,.xls,.xlsx,.txt,.doc,.docx,.csv,.rar,.zip,.7z,.jpg,.jpeg" id="BSbtnInfoInserir'+(total + 2)+'"><br/>');

		$("#arquivos > input[type='file']").last().filestyle({
			buttonName : 'btn-info',
        	buttonText : ' Anexar arquivos.'
		});

		$("#BSbtnInfoInserir"+(total + 2)).bind('change', function() {

	  	//this.files[0].size gets the size of your file.
	  	  validarTamanhoArquivo(this.files[0]);

		});

	});

	$('input[type="file"]').filestyle({
        buttonName : 'btn-info',
        buttonText : ' Anexar arquivos.'
    }); 
});

function validarTamanhoArquivo(file){

	var tamanhoEmMegaBytes = file.size/1048576;

	if(tamanhoEmMegaBytes > 100){
			$("#arquivos").append("<span class='error'>O Arquivo ultrapassa os 100MB permitidos por arquivo.</span>");
	}

}


// function validarTamanhoTotalArquivos(files){

// 	var tamanhoEmMegaBytes  = 0;
// 	var valueParsed;
// 	for(i = 0; i<files.length;i++){
// 		if (typeof $("#arquivos").children('input[name="arquivos_hidden[]"]')[i] !== 'undefined') {
// 			valueParsed = JSON.parse($("#arquivos").children('input[name="arquivos_hidden[]"]')[i].value);
// 			tamanhoEmMegaBytes += valueParsed.size / 1048576;
// 			if(tamanhoEmMegaBytes > 900) {
// 				return false;
// 			}
// 		}
		
// 		if (typeof $("#arquivos").children('input[name="arquivos[]"]')[i] !== 'undefined') {
// 			if (typeof files[i].files[0] !== 'undefined') {
// 				tamanhoEmMegaBytes += files[i].files[0].size / 1048576;
// 				if(tamanhoEmMegaBytes > 900){
// 					return false;
// 				}
// 			}
// 		}
// 	}
// 	return true;
// }
