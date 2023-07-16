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
$friends = user_friends( $user );
?>
<h1>Lista de Amigos</h1>
<table align="center" border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr><td class="tdh" align="center">Lista de Amigos</td></tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="1" width="100%">
    <?php if ( $friends ): ?>
    <?php foreach ( $friends as $friend  ): ?>
    <tr>
        <td class="tdn" align="center"><a href="info_user.php?id=<?php echo $friend['id']; ?>"><?php echo $friend['name']; ?></a></td>
        <td class="tdn" align="center"><a href="user_friend.php?del=<?php echo $friend['id']; ?>">Deletar Amigo</a></td>
        <td class="tdn" align="center"><a href="user_message_new.php?to=<?php echo $friend['id']; ?>">Enviar Mensagem</a></td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <center>Desculpe, mas você ainda não adicionar nenhum amigo a sua lista.</center>
    <?php endif; ?>
</table>
<br>

<?php require 'include/tpl/footer.php'; ?>