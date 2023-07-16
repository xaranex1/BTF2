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
$total_unread = user_messages_total_unread( $user );
?>
<table width="100%" cellpadding="3" cellspacing="2">
    <tr><td colspan="2" align="center" class="tdh">Mensagens</td></tr>
    <tr><th colspan="2" class="tdn" ><a href="user_message_new.php" >Escrever uma mensagem</a></th></tr>
    <tr><th colspan="2" class="tdn" ><a href="user_message_show.php?box=in" >Caixa de entrada</a> (<?php echo $total_unread; ?> <?php echo $total_unread == 1 ? 'Noticia nova' : 'Notícias novas'; ?>)</th></tr>
    <tr><th colspan="2" class="tdn" ><a href="user_message_show.php?box=out" >Caixa de saida</a></th></tr>
</table>
<?php require 'include/tpl/footer.php'; ?>