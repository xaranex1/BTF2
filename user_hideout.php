<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */
require 'include/config.php';
require 'include/tpl/top.php';

$user = user_information( $_SESSION['id'] );

$house_cost = user_hideout_update_cost( $user['pl_house'], 'house' );
$fence_cost = user_hideout_update_cost( $user['pl_fence'], 'fence' );
$road_cost = user_hideout_update_cost( $user['pl_road'], 'road' );
$nbh_cost = user_hideout_update_cost( $user['pl_nbh'], 'nbh' );

$deposito_cofre = "";
$retirar_cofre = "";

if ( isset( $_GET['b'] ) )
    user_hideout_update( $user, $_GET['b'] );

?>
<center>
    <table class="upgrade" cellpadding="2" cellspacing="2" border="0" width="100%" bordercolor="red">
        <tr>
            <td colspan="4" class="tdh">Esconderijo:</td>
        </tr>
        <tr>
            <td class="tdn" width="100">Seu Gold:</td>
            <td class="tdn" width="150"><?php echo pretty_number( $user['gold'] ); ?> <img src="img/res2.gif" alt="Residencia" align="absmiddle" border="0" /></td>
        </tr>
        <tr>
            <td class="tdn" width="100"><a href="">Pedras do Inferno:</a></td>
            <td class="tdn" width="150"><?php echo pretty_number( $user['ignicit'] ); ?> <img src="img/res3.gif" alt="Residencia" align="absmiddle" border="0" /></td>
        </tr>
    </table>
    <table cellpadding="2" cellspacing="2" border="0" width="100%">
        <tr>
            <td colspan="3" class="tdh">Ver seu esconderijo</td>
        </tr>
        <tr>
            <td colspan="3" class="tdn">
                <center>
                    <table width="700" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="3" style="background-image: url('img/hideout/b/bg<?php echo $user['pl_nbh']; ?>.jpg'); background-repeat: no-repeat; background-position: center;" align="center">
                                <table style="background-image: url('img/hideout/weg/s<?php echo $user['pl_road']; ?>.gif'); background-repeat: no-repeat; background-position: center;" width="100%">
                                    <tr>
                                        <td valign="bottom">
                                            <table style="background-image: url('img/hideout/u/stufe<?php echo $user['pl_house']; ?>.gif'); background-repeat: no-repeat; background-position: center;" width = "100%">
                                                <tr><td valign = "bottom"><img src="img/hideout/m/stufe<?php echo $user['pl_fence']; ?>.gif"></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </center>
            </td>
        </tr>
    </table>
    <table class="upgrade" cellpadding="2" cellspacing="2" border="0" width="100%" bordercolor="red">
        <tr>
            <td colspan="4" class="tdh">Evoluir o esconderijo:</td>
        </tr>
        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace5.jpg" alt="Baú do Tesouro" ></td>
            <td class="tdn" width="150"><a href="#hint">Baú do Tesouro</a></td>
            <td class="tdn" width="100"><?php echo $user['pl_chest_t'] ? '<b style="color: yellow;">Ativo</b>' : 'Inativo'; ?></td>
            <?php if ( !$user['pl_chest_t'] ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=5">4 semanas custa 20</a>
                <img src="img/res3.gif" alt="Residencia" align="absmiddle" border="0" />
            </td>
            <?php else: ?>
            <td class="tdn" align="center"><?php echo pretty_timer_regressive( $user['pl_chest_t'] - time() ); ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace6.jpg" alt="Baú do Tesouro" ></td>
            <td class="tdn" width="150"><a href="#hint">Gárgula Guardiã</a></td>
            <td class="tdn" width="100"><?php echo $user['pl_grg_t'] ? '<b style="color: yellow;">Ativo</b>' : 'Inativo'; ?></td>
            <?php if ( !$user['pl_grg_t'] ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=6">4 semanas custa 20</a>
                <img src="img/res3.gif" alt="Residencia" align="absmiddle" border="0" />
            </td>
            <?php else: ?>
            <td class="tdn" align="center"><?php echo pretty_timer_regressive( $user['pl_grg_t'] - time() ); ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace7.jpg" alt="Baú do Tesouro" ></td>
            <td class="tdn" width="150"><a href="#hint">Livro dos Mortos</a></td>
            <td class="tdn" width="100"><?php echo $user['pl_book_t'] ? '<b style="color: yellow;">Ativo</b>' : 'Inativo'; ?></td>
            <?php if ( !$user['pl_book_t'] ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=7">4 semanas custa 20</a>
                <img src="img/res3.gif" alt="Residencia" align="absmiddle" border="0" />
            </td>
            <?php else: ?>
            <td class="tdn" align="center"><?php echo pretty_timer_regressive( $user['pl_book_t'] - time() ); ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace1.jpg" alt="Casa" ></td>
            <td class="tdn" width="150"><a href="#hint">Residencia</a></td>
            <td class="tdn" width="100">Nível <?php echo $user['pl_house']; ?> / 11</td>
            <?php if ( $user['pl_house'] < 11 ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=1">Próximo nivel custa <?php echo pretty_number( $house_cost ); ?></a>
                <img src="img/res2.gif" alt="Residencia" align="absmiddle" border="0" />
            </td>
            <?php else: ?>
            <td class="tdn" align="center"></td>
            <?php endif;?>
        </tr>
        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace2.jpg" alt="Cerca/Muro" ></td>
            <td class="tdn" width="150"><a href="#hint">Cerca/Muro</a></td>
            <td class="tdn" width="100">Nível <?php echo $user['pl_fence']; ?> / 6</td>
            <?php if ( $user['pl_fence'] < 6 ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=2">Próximo nivel custa <?php echo pretty_number( $fence_cost ); ?></a>
                <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0" />
            </td>
            <?php else: ?>
            <td class="tdn" align="center"></td>
            <?php endif;?>
        </tr>

        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace3.jpg" alt="Caminho" ></td>
            <td class="tdn" width="150"><a href="#hint">Caminho</a></td>
            <td class="tdn" width="100">Nível <?php echo $user['pl_road']; ?> / 6</td>
            <?php if ( $user['pl_road'] < 6 ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=3">Próximo nivel custa <?php echo pretty_number( $road_cost ); ?></a>
                <img src="img/res2.gif" alt="Caminho" align="absmiddle" border="0">
            </td>
            <?php else: ?>
            <td class="tdn" align="center"></td>
            <?php endif;?>
        </tr>
        <tr>
            <td class="tdn" width="100"><img src="img/hideout/palace4.jpg" alt="Fundo" ></td>
            <td class="tdn" width="150"><a href="#hint">Meio envolvente</a></td>
            <td class="tdn" width="100">Nível <?php echo $user['pl_nbh']; ?> / 6</td>
            <?php if ( $user['pl_nbh'] < 6 ): ?>
            <td class="tdn" align="center">
                <a href="user_hideout.php?b=4">Próximo nivel custa <?php echo pretty_number( $nbh_cost ); ?></a>
                <img src="img/res2.gif" alt="Fundo" align="absmiddle" border="0">
            </td>
            <?php else: ?>
            <td class="tdn" align="center"></td>
            <?php endif;?>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="3" class="tdh"><a name="hint" />Dica:</a></td>
        </tr>
        <tr>
            <td class="tdn" style="text-align:justify">
                O seu Esconderijo protege-te dos seus inimigos. A sua proteção contra os inimigos aumenta cada vez que evoluis a Residência ou a Cerca/Muro. O nível da Cerca/Muro, Caminho ou Meio Envolvente não pode ser superior ao nível da sua Residência!<br/><br/>
                <b>Baú do Tesouro</b>:&nbsp;Pode guardar uma parte do seu ouro no Baú do Tesouro. O equivalente a 24h de trabalho (dependendo do nível) é protegido e não poderá ser roubado.<br/><br/>
                <b>Gárgula Guardiã</b>:&nbsp;A Gárgula protege-te dos ataques dos teus inimigos. A eficácia na tua defesa é aumentada em 30%. <br>Defesa +30%<br />
                Você só recebe o aumento quando é atacado.<br/><br/>
                <b>Livro dos Mortos</b>:&nbsp;Desde o inicio dos tempos que os Anciãos partilham imensa informação no Livro dos Mortos, esta informação pode ser-te útil na luta contra os teus inimigos. Usando o Livro a tua força aumenta 30%. <br>Força + 30%<br />
                Você só receberá o aumento quando você for o atacante.<br/><br/>
                <b>Residência</b>:&nbsp;Por cada nível da Residência ganha mais dois espaços no seu inventário.<br/><br/>
                <b>Cerca/Muro</b>:&nbsp;O muro/cerca protege-te dos ataques uma vez que reduz os danos que sofres. <br> A tua cerca/muro (nível 0) provoca 0% de danos bónus nos teus inimigos quando estes te atacam.<br/><br/>
                <b>Caminho</b>:&nbsp;Um bom caminho faz-te mover mais rápido. Assim poderá executar mais ações. <br> +1 nos PA máximos por nível do caminho.<br/><br/>
                <b>Meio envolvente</b>:&nbsp;O meio envolvente simboliza a sua aura obscura. Quanto mais forte você for maior será o efeito contra os inimigos que te ataquem. <br> Com seu meio envolvente (nível 0) recebe 0% de probabilidade de bónus ao activar os teus talentos quando és atacado.<br/><br/>
            </td>
        </tr>
    </table>
</center>
<?php require 'include/tpl/footer.php'; ?>
