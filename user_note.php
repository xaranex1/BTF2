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

if ( isset( $_POST['note'] ) )
    user_update_note( $user, $_POST['note'] );
?>
<form action="user_note.php" method="post">
    <div>
        <h2>Bloco de Notas</h2>
        <p><textarea name="note" rows="15" cols="75" style="text-align: center;"><?php echo $user['note']; ?></textarea></p>
        <center><input name="update" type="submit" value="Salvar"></center>
    </div>
</form>
<?php require 'include/tpl/footer.php'; ?>