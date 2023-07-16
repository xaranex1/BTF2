<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */
require 'include/config.php';
require 'include/tpl/top.php';

$user = user_information($_SESSION['id']);
$searchtyp = isset( $_POST['searchtyp'] ) ? $_POST['searchtyp'] : '';
$text = isset( $_POST['text'] ) ? $_POST['text'] : '';
$exact = isset( $_POST['exact'] ) && $_POST['exact'] == 'on' ? true : false;

if ( $searchtyp == 'name' && $_POST['text'] ) {
    $users = search_user_by_name( $text, $exact );
} else if ( $searchtyp == 'clan' && $_POST['text'] ) {
    $clans = search_clan_by_name( $text, $exact );
} else if ( $searchtyp == 'tag' && $_POST['text'] ) {
    $clans = search_clan_by_tag( $text, $exact );
}
?>
<div>
    <h2>Está à procura de quê?</h2>
    <form action="user_search.php"  method="POST">
        <p>
        <table width=100%>
            <tr>
                <td><input type="radio" name="searchtyp" value="name"<?php if ( $searchtyp == 'name' ) echo ' checked'; ?>></td>
                <td style="width:100px;">Jogador</td>
            </tr>
            <tr>
                <td><input type="radio" name="searchtyp" value="clan"<?php if ( $searchtyp == 'clan' ) echo ' checked'; ?>></td>
                <td>Clã (Nome)</td>
            </tr>
            <tr>
                <td><input type="radio" name="searchtyp" value="tag"<?php if ( $searchtyp == 'tag' ) echo ' checked'; ?>></td>
                <td>Clã (TAG do Clã)</td>
            </tr>
            <tr>
                <td>Texto:</td>
                <td><input type="text" name="text" size="30" maxlength="30" value="<?php echo $text; ?>"></td>
                <td><input type="checkbox" name="exact">Apenas mostra resultados exatos</td>
            </tr>
            <tr>
                <th colspan="3"><input type="submit" name="search" value="procurar"></th>
            </tr>
        </table>
        </p>
    </form>
</div>
<?php if ( $searchtyp == 'name' && $text ): ?>
<div>
    <h2>Resultados</h2>
    <p>
        <table width='80%'>
            <tr>
                <td>Raça</td>
                <td>Jogador</td>
                <td>Clã</td>
                <td>Total roubado</td>
                <td>Vitorias/Derrotas</td>
            </tr>
    <?php if ( $users ): ?>
        <?php foreach ( $users as $user ): ?>
            <tr>
                <td><img src='img/race<?php echo $user['race']; ?>small.gif' title='<?php echo $user['race'] == 1 ? 'Vampiro' : 'Lobisomen'; ?>' border='0'></td>
                <td><a href='info_user.php?id=<?php echo $user['id']; ?>'><?php echo $user['name']; ?></a></td>
                <td><?php if ( $user['clan_id'] ): ?><a href="i_klan.php?id=<?php echo $user['clan_id']; ?>"><?php echo $user['clan_name']; ?></a><?php endif; ?></td>
                <td><?php echo pretty_number( $user['stat_prey'] ); ?></td>
                <td><?php echo "{$user['stat_win']}/{$user['stat_loss']}"; ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan='2'>25 Resultados (25 max.)</td>
            </tr>
    <?php else: ?>
            <tr><td colspan='3'>Sem resultados</td></tr>
    <?php endif; ?>
        </table>
    </p>
</div>
<?php elseif ( $searchtyp == 'clan' && $text ): ?>
<div>
    <h2>Resultados</h2>
    <p>
        <table width='80%'>
            <tr>
                <td>Raça</td>
                <td>Clã</td>
                <td>Membros</td>
                <td>Total roubado (Sangue/Carne)</td>
            </tr>
    <?php if ( $clans ): ?>
        <?php foreach ( $clans as $clan ): ?>
            <tr>
                <td><img src='img/race1small.gif' title='Vampiros' border='0'></td>
                <td><a href='info_clan.php?id=<?php echo $clan['id']; ?>'><?php echo $clan['name']; ?></a></td>
                <td><?php echo $clan['total_user'] . '/' . clan_hideout_max_memb( $clan['castle'] ); ?></td>
                <td><?php echo pretty_number( $clan['total_prey'] ); ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan='2'>25 Resultados (25 max.)</td>
            </tr>
    <?php else: ?>
            <tr><td colspan='3'>Sem resultados</td></tr>
    <?php endif; ?>
        </table>
    </p>
</div>
<?php elseif ( $searchtyp == 'tag' && $text ): ?>
<div>
    <h2>Resultados</h2>
    <p>
        <table width='80%'>
            <tr>
                <td>Raça</td>
                <td>Nome</td>
                <td>TAG</td>
                <td>Membros</td>
                <td>Total roubado (Sangue/Carne)</td>
            </tr>
    <?php if ( $clans ): ?>
        <?php foreach ( $clans as $clan ): ?>
            <tr>
                <td><img src='img/race<?php echo $clan['race']; ?>small.gif' title='Vampiros' border='0'></td>
                <td><a href='info_clan.php?id=<?php echo $clan['id']; ?>'><?php echo $clan['name']; ?></a></td>
                <td><?php echo $clan['tag']; ?></td>
                <td><?php echo $clan['total_user'] . '/' . clan_hideout_max_memb( $clan['castle'] ); ?></td>
                <td><?php echo pretty_number( $clan['total_prey'] ); ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan='2'>25 Resultados (25 max.)</td>
            </tr>
    <?php else: ?>
            <tr><td colspan='3'>Sem resultados</td></tr>
    <?php endif; ?>
        </table>
    </p>
</div>
<?php endif; ?>
<?php require 'include/tpl/footer.php'; ?>