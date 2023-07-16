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

if ( isset( $_POST['email'] ) && isset( $_POST['desc'] ) && isset( $_POST['catch'] ) ) {
    if ( !empty( $_POST['email'] ) && !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
        $err = "O e-mail não é valido.";
    } else if ( strlen( $_POST['desc'] ) > 4000 ) {
        $err = "A descrição não pode conter mais de 4000 caracteres";
    } else if ( strlen( $_POST['catch'] ) > 2000 ) {
        $err = "A mensagem não pode conter mais de 2000 caracteres";
    } else {
        user_update_settings( $user, $_POST['email'], $_POST['desc'], $_POST['catch'] );
        $err = 'As configurações foram alteradas com sucesso';
    }
}
?>
<form action="user_settings.php" method="POST">
    <div id="settings">
        <h2>Configuracoes</h2>
        <div>
            <h2>E-mail</h2>
            <table cellpadding="2" cellspacing="2" border="0" width="100%">
                <colgroup>
                    <col width="300">
                </colgroup>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="text" name="email" size="50" value="<?php echo $user['email']; ?>" maxlength="120"></td></tr>
            </table>
        </div>
        <div>
            <script language="JavaScript">
                function CheckLen(Target)
                {
                    var maxlength = "4000"; //die maximale Zeichenl�nge
                    StrLen = Target.value.length;
                    if ( StrLen == 1 && Target.value.substring( 0, 1 ) == " " ) {
                        Target.value = "";
                        StrLen = 0;
                    }
                    if ( StrLen > maxlength ) {
                        Target.value = Target.value.substring( 0, maxlength );
                        CharsLeft = 0;
                    } else {
                        CharsLeft = maxlength-StrLen;
                    }
                    document.getElementById( 'charcount1' ).innerHTML = CharsLeft;
                }
            </script>
            <h2>Descrição do seu personagem (4000 caracteres)</h2>
            <p><textarea name="desc" rows="15" cols="75" style="text-align:center" onkeydown="CheckLen(this)" onkeyup="CheckLen(this)" onfocus="CheckLen(this)" onchange="CheckLen(this)"><?php echo $user['desc']; ?></textarea></p>
        </div>
        <div>
            <script language="JavaScript">
                function CheckLen2(Target) {
                    var maxlength = "2000"; //die maximale Zeichenl�nge
                    StrLen = Target.value.length;
                    if ( StrLen == 1 && Target.value.substring( 0, 1 ) == " " ) {
                        Target.value = "";
                        StrLen = 0;
                    }
                    if ( StrLen > maxlength ) {
                        Target.value = Target.value.substring( 0, maxlength );
                        CharsLeft = 0;
                    } else {
                        CharsLeft = maxlength - StrLen;
                    }
                    document.getElementById( 'charcount2' ).innerHTML=CharsLeft;
                }
            </script>
            <h2>Digite uma mensagem, que irá recebe-lo mordido pela vitima (2000 caracteres)</h2>
            <p><textarea  name="catch" rows="5" cols="75" style="text-align:center" onkeydown="CheckLen2(this)" onkeyup="CheckLen2(this)" onfocus="CheckLen2(this)" onchange="CheckLen2(this)"><?php echo $user['catch']; ?></textarea></p>
        </div>
        <input type=submit value="Salvar">
        </form>
<?php require 'include/tpl/footer.php'; ?>