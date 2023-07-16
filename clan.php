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

if ( clan_information( $user ) ) {
    echo "<script type=\"text/javascript\">window.location = 'clan_information.php'; </script>";
    exit;
}
?>
    <h1>Clã</h1>
    <h2><center>Clã</center></h2>
    <div id="settings">
        <table  cellpadding="2" cellspacing="2" border="0" width="100%">
            <tr>
                <td class="ntd"><a href=clan_new.php">clan fundado</a></td>
            </tr>
            <tr>
                <td><a href="user_search.php" >Procurar Clans</a></td>
            </tr>
        </table>

    </div>
<?php require 'include/tpl/footer.php'; ?>