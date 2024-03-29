$(document).ready(function() {

    //valida tamanho do arquivo
    $("#arquivos").children('input[type="file"]').bind('change', function() {
        //validarTamanhoArquivo(this.files[0]);
        validarArquivosTamanho();
    });

    //Valida o lote de arquivos enviados.
    $("#frmPedidoInteracao,#update-form,#update-form").submit(function(event) {

        var arquivos = $("#arquivos").children('input[type="file"]');
        var arquivos_hidden = $("#arquivos").children('input[name="arquivos_hidden[]"]');

        if (arquivos_hidden.length > 0) {
            $.merge(arquivos, arquivos_hidden);
        }

        if (!validarArquivosTamanho()) {
            event.preventDefault();
            event.stopImmediatePropagation();
            return false;
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
    $("#novoArquivo").click(function() {

        total = $("#arquivos").children('input[type="file"]').length;

        if (total > 19) {
            $("#arquivos").append("<span class='error'>Só é permitido 20 arquivos por interação</span>");
            return;
        }

        $("#arquivos").append('<input type="file" name="arquivos[]" accept=".pdf,.xls,.xlsx,.txt,.doc,.docx,.csv,.rar,.zip,.7z,.jpg,.jpeg" id="BSbtnInfoInserir' + (total + 2) + '"><br/>');

        $("#arquivos > input[type='file']").last().filestyle({
            buttonName: 'btn-info',
            buttonText: ' Anexar arquivos.'
        });

        $("#BSbtnInfoInserir" + (total + 2)).bind('change', function() {

            validarArquivosTamanho();

        });

    });

    $('input[type="file"]').filestyle({
        buttonName: 'btn-info',
        buttonText: ' Anexar arquivos.'
    });
});

function validarArquivosTamanho() {
    var arquivos = $("#arquivos").children('input[type="file"]');
    var arquivos_hidden = $("#arquivos").children('input[name="arquivos_hidden[]"]');

    if (arquivos_hidden.length > 0) {
        $.merge(arquivos, arquivos_hidden);
    }

    var tamanhoTotal = 0;
    var total_arquivos = arquivos.length
    for (i=0; i<total_arquivos; i++)
    {
        var arqFile = arquivos[i].files;
        const arqFileArr = Array.from(arqFile)
        // Loop through an array
        arqFileArr.forEach(file => {
            var arqFileSize =file.size
            var tamanho = Math.round(arqFileSize / 1048576);
            tamanhoTotal += tamanho;
        })

    }
    if (tamanhoTotal > 200) {
        if ($('.error').length > 0) {
            $('.error').remove()
        }
        $("#arquivos").append("<span class='error' style='font-size:15px;'>O tamanho dos arquivos excede o máximo de 200MB do nosso formulário.</span><br><span class='error' style='font-size:13px;'>Entre em contato com <a href='mailto:suporteaep@transparencia.org.br' style='color:red;text-decoration: underline;'>suporteaep@transparencia.org.br</a> para realizarmos o cadastro do anexo manualmente. Você pode subir o(s) arquivo(s) em uma nuvem compartilhada (ex: Google Drive) e anexar o link público para o arquivo também no email.</span>");
        return false;
    } else {
        if ($('.error').length > 0) {
            $('.error').remove()
        }        
        return true;
    }
}