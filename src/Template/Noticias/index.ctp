            <div class="pg pg-imprensa">
                <div class="title">
                    <h3>Notícias</h3>
                    <p>Principais artigos escritos por representantes da Transparência Brasil e reportagens que mencionam a entidade ou se baseiam no seu trabalho.</p>
                </div>
                <div class="columns">
                    <?php
                        $count = 0;
                        foreach($itens as $item): 
                        ?>
                        <div class="bx-highlight bx-<?=$count?>">
                            <div class="categoria">
                                <div class='nome-categoria'>
                                    <span><?=$item->ImprensasCategoria->Nome?></span>
                                </div>
                                <?php 
                                    if(isset($item->DataPublicacao))
                                        echo "<div class='data'><span>" . $item->DataPublicacao->i18nFormat('MM/Y') . "</span></div>";
                                ?>
                            </div>
                            <div class="bx-img">
                                <?php
                                if(strlen($item->Imagem) > 0):?>
                                  <a href="<?=$item->Link?>" target="_blank" onclick="registrarEvento('veja_mais', 'clique', '<?=$item->Titulo?>')"><img src="<?=BASE_URL?>img/imprensa/<?=$item->Imagem?>" /></a>
                                <?php endif; ?>
                            </div>
                            <div class="bx-txt">
                                <h4>
                                    <?php if(strlen($item->Veiculo) > 0) 
                                        echo strtoupper($item->Veiculo) . ': ';
                                    ?>
                                    <?=$item->Titulo?></h4>
                                <div class="char-limit-2">
                                    <p><?=$item->Resumo?></p>
                                </div>
                                <div class="btn-ver">
                                    <a href="<?=$item->Link?>" class="btn" target="_blank" onclick="registrarEvento('veja_mais', 'clique', '<?=$item->Titulo?>')">Veja Mais</a>
                                </div>
                            </div>
                        </div>
                    <?php 
                    $count++;
                    endforeach; ?>
                </div>
            </div>
