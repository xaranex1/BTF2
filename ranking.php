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
$statistics = ranking_race_statistics();

$p = isset( $_GET['p'] ) ? (int) $_GET['p'] : 1;
$off = ( $p - 1 ) * 10;

function pages( $p ) {
    $row = ranking_total_users();
    $b = ceil( $row / 10 );
    $x = 1;
    $pages = '';

    while ( $b >= $x ) {
        $pages .= $x == $p ? " [{$x}] " : " <a href=\"ranking.php?p={$x}\">{$x}</a> ";
        $x++;
    }

    return $pages;
}

$ranking = ranking( $off );
?>

                            <h2><center>Raça - Ranking</center></h2>
                            <table cellpadding="2" cellspacing="2" border="0" width="100%" bordercolor=red class="tdn">
                                <tr>
                                    <td align="center">
                                        <img src="img/race1.gif" alt="Vampiro" ><br />
                                        <br /><?php echo pretty_number( $statistics['vampire']['total'] ); ?> Vampiros
                                        <br />Total Roubado: <?php echo pretty_number( $statistics['vampire']['stat_prey'] ); ?> litros de sangue
                                        <br />Vitimas Mordidas: <?php echo pretty_number( $statistics['vampire']['stat_victim'] ); ?>
                                        <br />Vitorias: <?php echo pretty_number( $statistics['vampire']['stat_win'] ); ?>
                                        <br />Ouro: <?php echo pretty_number( $statistics['vampire']['gold'] ); ?> <img src="img/res2.gif" alt="Ouro" align="absmiddle" border="0"><br />
                                    </td>
                                    <td width="10">&nbsp;</td>
                                    <td align="center">
                                        <img src="img/race2.gif" alt="Lobisomen" ><br />
                                        <br /><?php echo pretty_number( $statistics['werewolf']['total'] ); ?> Lobisomens
                                        <br />Total Roubado: <?php echo pretty_number( $statistics['werewolf']['stat_prey'] ); ?> litros de sangue
                                        <br />Vitimas Mordidas: <?php echo pretty_number( $statistics['werewolf']['stat_victim'] ); ?>
                                        <br />Vitorias: <?php echo pretty_number( $statistics['werewolf']['stat_win'] ); ?>
                                        <br />Ouro: <?php echo pretty_number( $statistics['werewolf']['gold'] ); ?> <img src="img/res2.gif" alt="Ouro" align="absmiddle" border="0"><br />
                                    </td>
                                </tr>
                            </table>
                            <h2><center>Jogadores - Ranking</center></h2>
                            <?php
                            ?>
                            <table cellpadding="2" cellspacing="2" border="0" bordercolor="red" width="100%" class="tdn">
                                <tr>
                                    <td align="center">#</td>
                                    <td align="center">Raça</td>
                                    <td align="center">Nome</td>
                                    <td align="center">Experiencia</td>
                                    <td align="center">Total Roubado</td>
                                    <td align="center">Vitimas</td>
                                    <td align="center">Vitorias</td>
                                    <td align="center">Derrotas</td>
                                    <td align="center">Ouro</td>
                                </tr>
<?php foreach( $ranking as $user ): ?>
                                <tr>
                                    <td><?php echo ++$off; ?></td>
                                    <td><img src="img/race<?php echo $user['race']; ?>small.gif" alt="<?php echo $user['race'] == 1 ? 'Vampiro' : 'Lobisomem'; ?>" ></td>
                                    <td><a href="info_user.php?id=<?php echo $user['id']; ?>" title="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></a></td>
                                    <td align="right"><?php echo pretty_number( $user['exp'] ); ?></td>
                                    <td align="right"><?php echo pretty_number( $user['stat_prey'] ); ?></td>
                                    <td align="right"><?php echo pretty_number( $user['stat_victim'] ); ?></td>
                                    <td align="right"><?php echo pretty_number( $user['stat_win'] ); ?></td>
                                    <td align="right"><?php echo pretty_number( $user['stat_loss'] ); ?></td>
                                    <td align="right"><?php echo pretty_number( $user['stat_gold_p'] ); ?></td>
                                </tr>
<?php endforeach; ?>
                            </table>
<?php
echo pages( $p );
require 'include/tpl/footer.php';
?>