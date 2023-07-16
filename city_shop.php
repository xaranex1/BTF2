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

// Compra o item
if ( isset( $_GET['buy'] ) )
    $msg = user_item_buy( $user, (int) $_GET['buy'] );

$model = isset( $_GET['model'] ) ? (int) $_GET['model'] : 1;
$items = "";

db_query( "SELECT * FROM item WHERE model=? AND lvl<=? ORDER BY cost_gold ASC, lvl ASC", $model, user_calculate_level( $user['exp'] ) );
while ( $item1 = db_fetch() ) {
    $items .= "<tr>";
    $items .= "    <td class=\"active\" width=\"300px\"><img src=\"img/item/{$item1['id']}.jpg\" alt='{$item1['item']}' ></td>";
    $items .= "    <td class='active'>";
    $items .= "        <b style='color: red;'>{$item1['item']}</b> (<a style='color: yellow;' href='city_shop.php?buy={$item1['id']}'>comprar</a>) <br />";
    if ( $item1['cost_gold'] )
        $items .= "        " . pretty_number( $item1['cost_gold'] ) . "<img src=\"img/res2.gif\" alt=\"Ouro\" align=\"absmiddle\" border=\"0\">";
    if ( $item1['cost_ignicit']  )
        $items .= "        " . pretty_number( $item1['cost_ignicit'] ) . "<img src=\"img/res3.gif\" alt=\"Pedras do Inferno\" align=\"absmiddle\" border=\"0\">";
    $items .= "    <br/>";
    
    if ( $item1['pow'] > 0 )
        $items .= "Ataque: +{$item1['pow']}<br>";
    else if ( $item1['pow'] < 0 )
        $items .= "Ataque: {$item1['pow']}<br>";

    if ( $item1['def'] > 0 )
        $items .= "Defessa: +{$item1['def']}<br>";
    else if ( $item1['def'] < 0 )
        $items .= "Defessa: {$item1['def']}<br>";

    if ( $item1['agi'] > 0 )
        $items .= "Agilidade: +{$item1['agi']}<br>";
    else if ( $item1['agi'] < 0 )
        $items .= "Agilidade: {$item1['agi']}<br>";

    if ( $item1['stam'] > 0 )
        $items .= "Carisma: +{$item1['stam']}<br>";
    else if ( $item1['stam'] < 0 )
        $items .= "Carisma: {$item1['stam']}<br>";

    if ( $item1['chr'] > 0 )
        $items .= "Destreza: +{$item1['chr']}<br>";
    else if ( $item1['chr'] < 0 )
        $items .= "Destreza: {$item1['chr']}<br>";

    if ( $item1['s_double'] > 0 )
        $items .= "Ataque Duplo: +{$item1['s_double']}<br>";
    else if ( $item1['s_double'] < 0 )
        $items .= "Ataque Duplo: {$item1['s_double']}<br>";

    if ( $item1['s_block'] > 0 )
        $items .= "Bloqueio: +{$item1['s_block']}<br>";
    elseif ( $item1['s_block'] < 0 )
        $items .= "Bloqueio: -{$item1['s_block']}<br>";

    if ( $item1['s_chance_kick'] > 0 )
        $items .= "Chance de Fugir: +{$item1['s_chance_kick']}<br>";
    else if ( $item1['s_chance_kick'] < 0 )
        $items .= "Chance de Fugir: -{$item1['s_chance_kick']}<br>";

    if ( $item1['s_chance_blow'] > 0 )
        $items .= "Chance de Defesa: +{$item1['s_chance_blow']}<br>";
    else if ( $item1['s_chance_blow'] < 0 )
        $items .= "Chance de Defesa: {$item1['s_chance_blow']}<br>";

    if ( $item1['s_dam'] > 0 )
        $items .= "Dano: +{$item1['s_dam']}<br>";
    else if ( $item1['s_dam'] < 0 )
        $items .= "Dano: {$item1['s_dam']}<br>";

    $items .= " Nivel Necessario: <b>" . $item1['lvl'];
    $items .= " </b></td></tr>";
}
?>
<center>
    <p class="buildingDesc">
        <br/>
        <u>O mercador da-lhe as boas vindas, <?php echo $user['name'] ?> </u>
        <br/><br/>
        <?php if ( isset( $msg ) ) echo $msg; ?>
        <img src="img/npc/0_1.jpg" align="left" />
        <table cellpadding="2" cellspacing="2" border="0" >
            <tr>
                <td colspan="3" class="tdh" align="center">Mercador</td>
            </tr>
            <tr>
                <td colspan="3" class="tdn" style="text-align:justify">Bem vindo a minha modesta loja. Como posso servir-lhe? Posso oferecer-lhe boas armas e alguns itens que podem melhorar as suas habilidades! Escolha o que quiser...</td>
            </tr>
            <tr>
                <td class="tdn">O seu ouro:</td>
                <td colspan="2" class="tdn">
                    <?php echo pretty_number( $user['gold'] ); ?> <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0"> + <?php echo pretty_number( $user['ignicit'] ); ?> <img src="img/res3.gif" alt="Èãíèöèò" align="absmiddle" border="0">
                </td>
            </tr>
        </table>
    </p>
    <div style="clear: both;width:100%;"><br>
        <table cellpadding="2" cellspacing="2" border="0" width="100%">
            <tr>
                <td colspan="3" class="tdh" align="center">Co jsi chcete koupit?</td>
            </tr>
            <tr>
                <td colspan="3" class="tdn" align="center">
                    <a href="city_shop.php?model=1" >Zbraně</a>
                    | <a href="city_shop.php?model=2" >Přilby</a>
                    | <a href="city_shop.php?model=3" >Doplňky</a>
                    | <a href="city_shop.php?model=4" >Rukavice</a>
                    | <a href="city_shop.php?model=5" >Štíty</a>
                    <br/><a href="city_shop.php?model=6" >Brnění</a>
                    | <a href="city_shop.php?model=7" >Boty</a>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td colspan="3" class="tdh" align="center">Resumo</td>
            </tr>
            <?php echo $items; ?>
            </tr>
        </table>
    </div>
</center>
<?php require 'include/tpl/footer.php'; ?>