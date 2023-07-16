<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

require 'include/config.php';
require 'include/tpl/top_2.php';

if ( isset( $_POST['name'] ) && isset( $_POST['pass'] ) && isset( $_POST['email'] ) && isset( $_GET['race'] ) ) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $race = $_GET['race'] == 1 ? 1 : 2;
    $ref = isset( $_GET['ref'] ) ? $_GET['ref'] : null;
    
    if ( @$_POST['agree'] == 'ok' ) {
        if ( strlen( $name ) < 4 || strlen( $name ) > 16 ) {
            $msg = 'Deve conter entre 4 a 16 caracteres.<br/>';
        } else if ( user_information_by_name( $name ) ) {
            $msg = 'Este nome já esta em uso.<br/>';
        } else if ( strlen( $pass ) < 4 || strlen( $pass ) > 16 ) {
            $msg = 'Deve conter 4 a 16 caracteres.<br/>';
        } else if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $msg = 'O e-mail não é valido.<br/>';
        } else if ( user_information_by_email( $email ) ) {
            $msg = 'Este email ja estar em uso.<br/>';
        } else {
            user_register( $name, $pass, $email, $race, $ref );
            unset( $name );
            unset( $pass );
            unset( $email );
            $msg = 'O seu registro foi concluido com sucesso.<br/>';
        }
    } else {
        $msg = 'Você deve aceitar os termos de uso.<br/>';
    }
    
}

if ( !isset( $_GET['race'] ) ): ?>
    <script language="JavaScript">
        p1 = new Image();  p1.src = "img/race1logintr.gif";
        p1x = new Image(); p1x.src = "img/race1loginhovertr.gif";
        p2 = new Image();  p2.src = "img/race2logintr.gif";
        p2x = new Image(); p2x.src = "img/race2loginhovertr.gif";
    </script>
    <br>
    <center>
        <img src="img/1.png" alt="Vampiro" align="absmiddle" width = "70px" height= "70px" >
        Volba rasy
        <img src="img/2.png" alt="Lobisomem" align="absmiddle" width = "70px" height= "70px">
        <br/><br/>
        <table cellpadding="0" cellspacing="0" border="0" width="90%">
            <tr>
                <td width="50%" align="left"><a href="register.php?race=1<?php if ( isset( $_GET['ref'] ) ) echo "&ref={$_GET['ref']}"; ?>" onfocus="if(this.blur)this.blur()" target="_top" onmouseover="document.pic1.src = p1x.src" onmouseout="document.pic1.src = p1.src"><img src="img/17.gif" alt="Vampiro" name="pic1" border="0"></a></td>
                <td width="50%" align="right"><a href="register.php?race=2<?php if ( isset( $_GET['ref'] ) ) echo "&ref={$_GET['ref']}"; ?>" onfocus="if(this.blur)this.blur()" target="_top" onmouseover="document.pic2.src = p2x.src" onmouseout="document.pic2.src = p2.src"><img src="img/un.gif" alt="Lobisomem" name="pic2" border="0"></a></td>
            </tr>
        </table>
        <br><br>
    </center>
<?php else: ?>
    <form action="register.php?race=<?php echo @$_GET['race'] == 1 ? 1 : 2; ?><?php if ( isset( $_GET['ref'] ) ) echo "&ref={$_GET['ref']}"; ?>" method="post">
        <br/>
       
        <br/>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <?php if ( isset( $msg ) ): ?>
            <tr>
                <td colspan="2" align="center" style="color: yellow;"><?php echo $msg; ?><br/><br/></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td align="center" valign="top"><img src="img/race<?php echo @$_GET['race'] == 1 ? 1 : 2; ?>.gif" alt="<?php echo @$_GET['race'] == 1 ? 'Vampiro' : 'Lobisomen'; ?>" ></td>
                <td valign="top">
                    <table cellpadding="2" cellspacing="2" border="0" width="100%">
                        <tr><td>Jméno:</td><td><input class="input" type="text" name="name" size="30" MAXLENGTH="30" value="<?php if ( isset( $name ) ) echo $name; ?>"></td></tr>
                        <tr><td>Heslo:</td><td><input class="input" type="password" name="pass" size="20" MAXLENGTH="20"  value="<?php if ( isset( $pass ) ) echo $pass; ?>"></td></tr>
                        <tr><td>E-mail:</td><td><input class="input" type="text" name="email" size="30" MAXLENGTH="120" value="<?php if ( isset( $email ) ) echo $email; ?>"></td></tr>
                        <tr><td></td><td> </td></tr>
                        <tr><td colspan="2"><span class="fontsmall"><input type="checkbox" name="agree" value="ok">Zaškrtněte pro souhlas s podmínkami!</span></td></tr>
                        <tr><td align="center" colspan="2"><br><input type="submit" class="input" value="    Registrovat    "></td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
<?php endif; ?>
<?php require 'include/tpl/footer.php'; ?>