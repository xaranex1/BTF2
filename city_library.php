<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

 
/**
 * BiteFight
 * Fixed by: iTzRaul
 * Version: 1.1.1
 * Revised: 2013/03/024
*/


require 'include/config.php';
require 'include/tpl/top.php';

$user = user_information( $_SESSION['id'] );

$price = ceil( $user['stat_prey'] * 0.1 );

if ( @$_GET['stat'] == 'send' ) {
    $name = @$_POST['name'];
    if ( strlen( $name ) < 4 || strlen( $name ) > 16 ) {
        $msg = 'O nome deve conter 4 a 16 caracteres.';
    } else if ( user_information_by_name( $name ) ) {
        $msg = 'Este nome ja estar em uso.';
    } else {
        if ( @$_POST['method'] == 1 ) {
            if ( $price > 1 && $user['gold'] >= $price ) {
                user_change_name( $user, $name );
            } else {
                $msg = "Ouro insuficiente.";
            }
        } else {
            if ( $user['ignicit'] >= 10 ) {
                user_change_name( $user, $name, 2 );
            } else {
                $msg = "Pedras do Inferno insuficiente.";
            }
        }
    }
}
?>
<br><u>Welcome, <?php echo $user['name']; ?></u><br><br>
<p>Your Resources: <?php echo pretty_number( $user['gold'] ) ?><img src="img/res2.gif" alt="Ouro" align="absmiddle" border="0"> and <?php echo pretty_number( $user['ignicit'] ) ?><img src="img/res3.gif" alt="Pedras do Inferno" align="absmiddle" border="0"></p>
<p class="buildingDesc">
    <img src="img/npc/0_3.jpg" align="left" />
    <table cellpadding="2" cellspacing="2" border="0">
        <tr>
            <td class="tdn">
You don't like your name?<br>
You are too popular and you don't want this?<br>
You have a lot of enemies?<br>
Any situation would be, I can help you change your Name, but you will have to pay me!
            </td>
        </tr>
    </table>
</p>
<br />
<table cellpadding="2" cellspacing="2" border="0" width="80%">
    <tr>
        <td colspan="2" class="tdh">What you need?</td>
    </tr>
    <tr>
        <td class="tdn">
            <table border="0" cellpadding="2" cellspacing="2">
                <?php if ( isset( $msg ) ): ?><tr><td id="msg" style="color: yellow;"><b><?php echo $msg; ?></b></td></tr><?php endif; ?>
                <form action="city_library.php?stat=send" method="post">
                    <tr>
                        <td>
                            <input type="radio" name="method" value="1" checked>
                            <b>New Documents</b> (Cost: 10% of Total Rob, <?php echo pretty_number( $price ); ?> <img src="img/res2.gif" alt="Gold" align="absmiddle" border="0">)
                            <p>You will get new documents for a small fee. This way, you will lose a little publicity.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="method" value="2">
                            <b>Rewrite Documents</b> (Custo: 10 <img src="img/res3.gif" alt="Pedras do Inferno" align="absmiddle" border="0">)
                            <p>Your documents are forged.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Type your new Name:</p>
                            <input type="text" name="name" /><input type="submit" class=input value="Rename">
                        </td>
                    </tr>
                </form>
            </table>
        </td>
    </tr>
</table>




<?php require 'include/tpl/footer.php'; ?>