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

$user_id = isset( $_GET['id'] ) ? $_GET['id'] : 0;
$user = user_information( $user_id );
?>
<center>
<?php if( $user ): ?>
    <h1><a href="register.php?ref=<?php echo $user['id']; ?>">Click here to Register</a></h1>
<?php else: ?>
    <h1><a href="register.php">Click here to Register</a></h1>
<?php endif; ?>
</center>
<?php require 'include/tpl/footer.php';?>