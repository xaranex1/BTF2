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

if ( @$_GET['stat'] == 'send' ) {
    if ( isset( $_GET['to'] ) ) $to = $_GET['to'];
    else if ( isset( $_POST['to'] ) ) $to = $_POST['to'];
    $subj = @$_POST['subj'];
    $msg = @$_POST['msg'];

    $user_to = user_information_by_name( $to );
    if ( strlen( $msg ) > 100 ) {
        $err = "Você deve digitar um assunto e deve ter no maximo 100 caracteres.";
    } else if ( strlen( $msg ) > 1000 ) {
        $err = "A mensagem não pode contar mais de 1000 caracteres.";
    } else if ( !$user_to ) {
        $err = "Destinatario não existe.";
    } else if ( $user_to['lord'] && user_messages_total( $user_to ) >= $config['game']['mail']['lord'] ) {
        $err = "O usuario não pode mais receber novas mensagens pois está com a caixa de e-mails cheia.";
    } else if ( user_messages_total( $user_to ) >= $config['game']['mail']['normal'] ) {
        $err = "O usuario não pode mais receber novas mensagens pois está com a caixa de e-mails cheia.";
    } else {
        user_messages_send( $user, $user_to, $subj, $msg );
        $err = "Mensagem enviada com sucesso.";
        unset( $_POST );
    }
}
?>
<table width=100%>
    <tr>
        <td colspan="2" align="center" class="tdh">Escrever uma mensagem</td>
    </tr>
    <?php if ( isset( $err ) ) echo "<tr><td colspan=\"2\" style=\"color: yellow;\" class=\"tdn\"><b>{$err}</td></tr>"; ?>
    <form action="user_message_new.php?stat=send" method="post">
        <tr>
            <td width="30%" class="tdn">Remetente:</td>
            <td width="70%" class="tdn"><?php echo $user['name']; ?></td>
        </tr>
        <tr>
            <td width="30%" class="tdn">Destinatario:</td>
            <td width="70%" class="tdn"><input type="text" name="to" size="30" maxlength="20" class="input" value="<?php if ( isset( $_POST['to'] ) ) echo $_POST['to']; ?>"/>(nome do jogador)</td>
        </tr>
        <tr>
            <td width="30%" class="tdn">Assunto:</td>
            <td width="70%" class="tdn"><input type="text" name="subj" size="30" maxlength="100" class="input" value="<?php if ( isset( $_POST['subj'] ) ) echo $_POST['subj']; ?>"></td>
        </tr>
        <tr>
            <td width="30%" class="tdn" valign="top">Mensagem<br>(1000 max.)</td>
            <td width="70%" class="tdn"><textarea name="msg" rows="9" cols="60" class="input"><?php if ( isset( $_POST['msg'] ) ) echo $_POST['msg']; ?></textarea></td>
        </tr>
        <tr>
            <td width="30%" class="tdn"></td>
            <td class="tdn">
                <input type="submit" class="input" value="Enviar">
            </td>
        </tr>
</table>
<?php require 'include/tpl/footer.php'; ?>
