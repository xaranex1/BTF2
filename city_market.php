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

if ( isset( $_GET['buy'] ) ) {
    $item = market_item_information( (int) $_GET['buy'] );
    if( $item ) {
        if ( $item['lvl'] > $user['level'] ) {
            $msg = 'Você não pode receber esse item ainda';
        } else {
            if ( $user['gold'] >= $item['cost'] )
                user_market_item_buy( $user, $item );
            else
                $msg = 'Ouro insuficiente';
        }
    }
}

$model = isset( $_GET['model'] ) && $_GET['model'] >= 1 ? (int) $_GET['model'] : 1;
$items = market_items( $model );
?>
<br/>
<u>Hello, <?php echo $user['name']; ?> </u>
<center>
    <br/><br/>
    <?php if ( isset( $msg ) ): ?><div class="ainfo4"><b><?php echo $msg; ?></b></div><br><br><?php endif; ?>
    <p class="buildingDesc">
        <img src="img/npc/0_5.jpg" align="left" />
        <table cellpadding="2" cellspacing="2" border="0" >
            <tr>
                <td colspan="3" class="tdh" align="center">Mercador</td>
            </tr>
            <tr>
                <td colspan="3" class="tdn" style="text-align:justify">Bom, na minha umilde loja, vendo os itens que os outros Jogadore nao queiram mais, e entregam eles a mim para eu vendelos.. escolha o item desejado abaixo para efetuar uma compra</td>
            </tr>
            <tr>
                <td class="tdn"> O seu ouro:</td>
                <td colspan="2" class="tdn"><?php echo pretty_number( $user['gold'] ) ?> <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0"> + <?php echo pretty_number( $user['ignicit'] ); ?> <img src="img/res3.gif" alt="Èãíèöèò" align="absmiddle" border="0"></td></tr>
        </table>
    </p>
    <div style="clear: both;width:100%;">
        <br/>
        <table cellpadding="2" cellspacing="2" border="0" width="100%">
            <tr>
                <td colspan="3" class="tdh" align="center">Em que bens estás interessado?</td>
            </tr>
            <tr>
                <td colspan="3" class="tdn" align="center"><a href="city_market.php?model=1" >Armas</a>
                    | <a href="city_market.php?model=2" >Capacetes</a> | <a href="city_market.php?model=3" >Assessórios</a>
                    | <a href="city_market.php?model=4" >Luvas</a> | <a href="city_market.php?model=5" >Escudos</a><br>
                    <a href="city_market.php?model=6" >Armaduras</a> | <a href="city_market.php?model=7" >Botas</a>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td colspan="3" class="tdh" align="center">Resumo</td>
            </tr>
            <?php foreach( $items as $item ): ?>
            <tr>
                <td class="active" width="300px"><img src="img/item/<?php echo $item['id']; ?>.jpg" alt="<?php echo $item['item']; ?>" ></td>
                <td class="active">
                    <strong><?php echo $item['item']; ?> (<a style='color:orangered' href='city_market.php?buy=<?php echo $item['m_id']; ?>'>Comprar</a>)</strong><br />Preço: <?php echo pretty_number( $item['cost'] ); ?><br/>
                    <?php if ( $item['pow'] > 0 ): ?>Força: <?php echo $item['pow']; ?><br/><?php endif; ?>
                    <?php if ( $item['def'] > 0 ): ?>Defesa: <?php echo $item['def']; ?><br/><?php endif; ?>
                    <?php if ( $item['agi'] > 0 ): ?>Agilidade: <?php echo $item['agi']; ?><br/><?php endif; ?>
                    <?php if ( $item['stam'] > 0 ): ?>Carisma: <?php echo $item['stam']; ?><br/><?php endif; ?>
                    <?php if ( $item['chr'] > 0 ): ?>Destreza: <?php echo $item['chr']; ?><br/><?php endif; ?>
                    <?php if ( $item['s_double'] > 0 ): ?>Ataque Duplo: <?php echo $item['s_double']; ?><br/><?php endif; ?>
                    <?php if ( $item['s_block'] > 0 ): ?>Bloqueio: <?php echo $item['s_block']; ?><br/><?php endif; ?>
                    <?php if ( $item['s_chance_kick'] > 0 ): ?>Chance de Fugir: <?php echo $item['s_chance_kick']; ?><br/><?php endif; ?>
                    <?php if ( $item['s_chance_blow'] > 0 ): ?>Chance de Defesa: <?php echo $item['s_chance_blow']; ?><br/><?php endif; ?>
                    <?php if ( $item['s_dam'] > 0 ): ?>Dano: <?php echo $item['s_dam']; ?><br/><?php endif; ?>
                    Nivel Necessario: <b><?php echo $item['lvl']; ?></b>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</center>
<?php require 'include/tpl/footer.php'; ?>