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

if ( isset( $_GET['add'] ) && $_GET['add'] != 1 ) {
    $friend = user_information( (int) $_GET['add'] );

    if ( !$friend ) {
        $msg = 'Este jogador não existe';
    } else if ( user_friend_already( $user, $friend ) ) {
        $msg = 'Você já é amigo deste jogador';
    } else {
        user_friend_add( $user, $friend );
        $msg = "O jogador {$friend['name']} foi adicionad a sua lista de amigos";
    }
} else if ( isset( $_GET['del'] ) && $_GET['del'] != 1 ) {
    $friend = user_information( (int) $_GET['del'] );

    if ( !$friend ) {
        $msg = 'Esse jogador não existe.';
    } else if ( !user_friend_already( $user, $friend ) ) {
        $msg = 'Você não é amigo deste jogador';
    } else {
        user_friend_delete( $user, $friend );
        $msg = "O jogador {$friend['name']} não está mais em sua lista de amigos";
    }
} else {
    echo "<script type=\"text/javascript\">window.location = 'user_main.php'; </script>";
    exit;
}
?>
<div>
    <h2>Lista de Amigos</h2>
    <p>
    <table border="0" cellpadding="2" cellspacing="2" width="100%">
        <tbody>
            <tr>
                <td rowspan="2"><?php echo $msg; ?> </td>
            </tr>
        </tbody></table>
</p>
</div>
<?php require 'include/tpl/footer.php'; ?>