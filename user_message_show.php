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
$_GET['box'] = @$_GET['box'] == 'in' ? 'in' : 'out';

if ( isset( $_POST['action'] ) ) {
    if ( $_POST['action'] == 1 )
        user_messages_delete( $user, 'all' );
    else if ( $_POST['action'] == 2 )
        user_messages_delete( $user, 'selected', @$_POST['msg'] );
    else if ( $_POST['action'] == 3 )
        user_messages_delete( $user, 'unselected', @$_POST['msg'] );
}
?>
<div id="mail">
    <?php if ( $_GET['box'] == 'in' ): ?>
    <form action="?box=in" method="post">
        <table width=100%>
            <tr>
                <td class="tdh" align="center" colspan="3">Caixa de Entrada </td>
            </tr>
            <tr>
                <td align="center" class="tdn" colspan="3">
                    <select class="input" name="action" size=1>
                        <option value="1">todas as mensagens</option>
                        <option value="2">mensagens marcadas</option>
                        <option value="3">mensagens nao marcadas</option>
                    </select>
                    <input type=submit class="input" value="Deletar" />
                </td>
            </tr>
        </table>
        <table cellpadding="2" cellspacing="2" border="0" width="100%">
            <tr>
                <td class="tdn"></td>
                <td class="tdn"><center>Remetente</center></td>
                <td class="tdn"><center>Assunto</center></td>
                <td class="tdn"><center>Mensagem</center></td>
            </tr>
            <?php $msgs = user_messages( $user['id'], 'in' ); ?>
            <?php foreach( $msgs as $msg ): ?>
            <tr>
                <td class="tdn"><input type="checkbox" value="<?php echo $msg['id']; ?>" name="msg[]"/></td>
                <td class="tdn"><center><?php echo !empty( $msg['user_id'] ) ? "<a href=\"c.php?id={$msg['user_id']}\">{$msg['name']}</a>" : "<a href=\"#\">Sistema</a>"; ?></center></td>
                <td class="tdn"><?php echo $msg['subj']; ?></td>
                <td class="tdn"><?php echo htmlspecialchars_decode( $msg['msg'], ENT_QUOTES ); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </form>
    <?php elseif ( $_GET['box'] == 'out' ): ?>
    <table width=100%>
        <tr>
            <td class="tdh" align="center" colspan=3>Caixa de saida</td>
        </tr>
    </table>
    <table cellpadding="2" cellspacing="2" border="0" width="100%">
        <tr>
            <td class="tdn"><center>Destinatario</center></td>
            <td class="tdn"><center>Assunto</center></td>
            <td class="tdn"><center>Mensagem</center></td>
        </tr>
        <?php $msgs = user_messages( $user['id'], 'out' ); ?>
        <?php foreach( $msgs as $msg ): ?>
        <tr>
            <td class="tdn"><center><a href="c.php?id=<?php echo $msg['user_id']; ?>"><?php echo $msg['name']; ?></a></center></td>
            <td class="tdn"><?php echo $msg['subj']; ?></td>
            <td class="tdn"><?php echo $msg['msg']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
    <br />
</div>
<?php require 'include/tpl/footer.php'; ?>