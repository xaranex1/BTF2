<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

require 'include/config.php';
require 'include/tpl/top_2.php';

if ( isset( $_POST['name'] ) && isset( $_POST['name'] ) ) {
    if ( user_login( $_POST['name'], $_POST['pass'] ) ) {
        header( 'Location: user_main.php' );
        exit;
    } else {
        $msg = "<tr><td align=\"center\" colspan=\"3\" class=\"tdn\"><b>Nome do jogador ou senha incorretos.</b><br></td></tr>";
    }
}
?>
<form action="login.php" method="post">
    <center>
        <br><br>
        <table cellpadding="0" cellspacing="0" border="0" width="50%">
            <?php if ( isset( $msg ) ) echo $msg; ?>
            <tr>
                <td width="50%" align="center" valign="top"><table cellpadding="2" cellspacing="2" border="0" width="50%">
                        <tr>
                            <td>Usuario:</td>
                            <td><input class="input" type="text" name="name" size="30" maxlength="16" value="<?php if ( isset( $_POST['name'] ) ) echo $_POST['name']; ?>"></td>
                        </tr>
                        <tr>
                            <td>Senha:</td>
                            <td><input class="input" type="password" name="pass" size="30" maxlength="16" value="<?php if ( isset( $_POST['name'] ) ) echo $_POST['pass']; ?>"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2" class="fontsmall">Logando aceitar&aacute; os termos e condi&ccedil;&otilde;es..</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="input" value="Login"></td>
                        </tr>
                    </table>
                    <table width="482" border="0" cellspacing="0" cellpadding="0"></table>
                    <a href="?lostpw" target="_top" class="headlines">Esqueceu senha?</a><br />
                </td>
            </tr>
            <tr><td align="center" colspan="3"></td></tr>
        </table>
    </center>
</form>
<?php require 'include/tpl/footer.php'; ?>