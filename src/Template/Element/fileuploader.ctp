<div class="form-group" id="arquivos">
<?php
    //print_r($this->request->data['submittedfile'])
    if(count($arquivos) == 0){
        $this->Form->control('arquivos[]', ['type' => 'file', 'id' => "BSbtnInfoInserir2", 'class' => 'form-control','label' => false]);
    }else{
        $contadorArquivo = 2;
        foreach($arquivos as $arquivo){
            echo $this->Form->control('arquivos[]', ['type' => 'file', 'id' => "BSbtnInfoInserir".$contadorArquivo, 'class' => 'form-control','label' => false]);
            // echo $this->Form->control('arquivos_hidden[]', ['type' => 'hidden', 'value' => serialize($arquivo), 'class' => 'form-control','label' => false]);
            //json_encode($arquivo)
            $contadorArquivo++;
        }
    }
    echo $this->ValidationText->exibirErro($errosArquivo, "Erro");
?>
</div>
<a href="javascript:void(0);" id="novoArquivo" class="add-conteudo">Adicionar mais um arquivo</a>