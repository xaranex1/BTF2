<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */
require 'include/config.php';
require 'include/tpl/top.php';

$clan_id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0 ;
$p = isset( $_GET['p'] ) && $_GET['p'] > 1 ? (int) $_GET['p'] : 1;
$off = ( $p - 1 ) * 10;

$clan = clan_information_by_id( $clan_id );
$users = clan_users( $clan, $off );

function pages ( $p ) {
    global $clan;
    $row = clan_users_total( $clan );
    $b = ceil ( $row / 10 );
    $x = 1;
    $pages = '';
    while ( $b >= $x ) {
        if ( $x == $p ) {
            $pages .= " [{$x}] ";
        } else {
            $pages .= " <a href=\"info_clan_members.php?p={$x}\">{$x}</a> ";
        }
        $x++;
    }
    return $pages;
}
?>
<h2><center>Lista de Membros</center></h2>
<table cellpadding="2" cellspacing="2" border="1" bordercolor="red" width="100%" class="tdn">
    <tr>
        <td align="center"> # </td>
        <td align="center">Raça</td>
        <td align="center">Nome</td>
        <td align="center">Nível</td>
        <td align="center">Total Roubado</td>
        <td align="center">Vitimas</td>
        <td align="center">Vitorias</td>
        <td align="center">Derrotas</td>
        <td align="center">Ouro perdido</td>
    </tr>
<?php foreach ( $users as $user ): ?>
    <tr>
        <td><?php echo ++$off; ?></th>
        <td><img src="img/race<?php echo $user['race']; ?>small.gif" alt="<?php echo $user['race'] == 1 ? 'Vampiro' : 'Lobsomen'; ?>" /></th>
        <td><a href="info_clan.php?id=<?php echo $user['id']; ?>" title="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></a></th>
        <td align="right"><?php echo user_calculate_level( $user['exp'] ); ?></th>
        <td align="right"><?php echo pretty_number( $user['stat_prey'] ); ?></th>
        <td align="right"><?php echo pretty_number( $user['stat_victim'] ); ?></th>
        <td align="right"><?php echo pretty_number( $user['stat_win'] ); ?></th>
        <td align="right"><?php echo pretty_number( $user['stat_loss'] ); ?></th>
        <td align="right"><?php echo pretty_number( $user['stat_gold_p'] ); ?></th>
    </tr>
<?php endforeach; ?>
</table>
<?php
echo pages ( $p );
require 'include/tpl/footer.php';
?>