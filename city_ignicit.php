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

if ( isset( $_GET['shadowlord'] ) && $user['ignicit'] >= 15 ) {
    user_buy_shadowlord( $user );
}
?>
    <table width="722" border="0" border="1" cellspacing="1" cellpadding="1">
        <th valign="top">
            <img src="img/npc/0_6.jpg" border=0 width=194/>
        </th>
        <th>
            <div id="keyinfo">
                <h2><b>Loja VooDoo</b></h2>
                <table cellpadding="2" cellspacing="2" width="100%" border=0 bordercolor=red>
                    <tr>
                        <td colspan="2">
                            <br/><br/>
                            Bem vindo à loja VooDoo, um lugar realmente maravilhoso.
                            Com uma pequena visão do interior da loja você pode perceber que misteriosos itens podem estar escondidos aqui.
                            De repente um goblin aparece atrás do balcão e diz: "O que eu posso fazer por você, Sir?"
                            <br/><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>Os seus pertences:</td>
                        <td><?php echo $user['gold']; ?> <img src="img/res2.gif" alt="Ouro"> + <?php echo $user['ignicit']; ?> <img src="img/res3.gif" alt="Pedras do Inferno"> </td>
                    </tr>
                </table>
            </div>
        </th>
    </table>
    <h2><b>Pedras do Inferno</b></h2>
    <div id="keyinfo">
        <table cellpadding="2" cellspacing="2" width="720" border="0">
            <tr>
                <td width="150"><img src="img/cehennemtasi.jpg"></td>
                <td width="470">
                    <b>Pedras do Inferno</b><br/>
                    Estes cristais místicos foram primeiramente encontrados nas minas de Muldagor.
                    Eles parecem possuir uma energia enorme, então é isso que usam para oferecer a possibilidade de criar os itens mais poderosos já vistos.
                </td>
                <td width="100"><a href="<?php echo $config['url']['hellstones']; ?>">Comprar</a></td>
            </tr>
        </table>
    </div>
    <h2><b>Lorde das Sombras</b></h2>
    <div id="keyinfo">
        <table cellpadding="2" cellspacing="2" width="720" border="0">
            <tr>
                <td width="200"><img src="img/shadowlord.jpg"></td>
                <td width="420">
                    <b>Pedras do Inferno</b>
                    <li>Sem propagandas.
                    <li>Você recebe ouro todo dia.
                    <li>Mais 50% nos pontos de ação.
                    <li>Estatisticas de caça.
                    <li>Pesquisa avançada de opnentes.
                    <li>Imagens individuis de personagem.
                    <li>Um adicional de uma porção de vida de 100%.
                    <li>5 pastas adcionais no seu sistema de mensagens.
                </td>
                <td width="100"><a href="city_ignicit.php?shadowlord">14 dias por 15 Pedras do Inferno</a></td>
            </tr>
        </table>
    </div>
<?php require 'include/tpl/footer.php'; ?>
