<section class="contato">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h1>RESPONDER EMAIL DE CONTATO</h1>
        <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona"><br><br>
        <h2> Nome:</h2>
        <span> <?=$contato->Nome?></span>
        <br>
        <h2> Destinatário:</h2>
        <span> <?=$contato->Email?></span>
        <br>
        <h2> Mensagem:</h2>
        <span> <?=$contato->Mensagem?></span>
      </div>
      <h2> Resposta:</h2>
      <div class="col-md-12">
        <div class="form-group">
          <div class='form-control'>
            <textarea style='width:600px' class='text-area' rows="10"></textarea>
          </div>
        </div>
      </div>
      <input type="submit" class="bntVer" value="Enviar">
    </div>
  </div>
</section>
