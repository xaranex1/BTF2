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
$clan = clan_information( $user );

if ( !$clan ) {
    echo "<script type=\"text/javascript\">window.location = 'clan.php'; </script>";
    exit;
}

if ( $clan['user_id'] != $user['id'] ) {
    echo "<script type=\"text/javascript\">window.location = 'clan_information.php'; </script>";
    exit;
}

if ( isset( $_POST['name'] ) ) {
    if ( strlen( $_POST['name'] ) < 2 || strlen( $_POST['name'] ) > 35 )
        $msg = '<tr><td colspan="2" align="center" style="color:yellow">O nome deve conter entre 2 e 25 caracteres.</td></tr>';
    else if ( clan_name_in_use( $_POST['name'] ) )
        $msg = '<tr><td colspan="2" align="center" style="color:yellow">Nome já está em uso.</td></tr>';
    else
        clan_name( $clan, $_POST['name'] );
}
?>
<div>
    <h1>Clã | <a href="clan_information.php" >voltar</a></h1>
    <h2>Mudar a Nome do Clã</h2>
    <p>
        <table width="100%">
            <form action="clan_name.php" method="post">
                <?php if ( isset( $msg ) ) echo $msg; ?>
                <tr>
                    <th>Nome do Clã:</th>
                    <th><?php echo $clan['name']; ?></th>
                </tr>
                <tr>
                    <th>Novo nome do clã:</th>
                    <th><input type="text" name="name" value="<?php if ( isset( $_POST['name'] ) ) echo $_POST['name']; ?>" size="35" maxlength="35"></th>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" value="salvar"></th>
                </tr>
            </form>
        </table>
    </p>
</div>
<?php require 'include/tpl/footer.php'; ?>