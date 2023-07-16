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

if ( !isset( $config ) )
    exit( 'Não é permitido o acesso direto aos scritps' );
?>
                            <a href="faq.php" target="_top">FAQ</a> <a href="register.php" target="_top">Registrovat</a>
                            <a href="login.php" target="_top">Přihlásit se</a> <a href="ranking.php" target="_top">Statistika</a>
                            <a href="<?php echo $config['url']['forum']; ?>" target="_blank">Forum</a>
                            <center style="font-size: 0.7em;"><?php echo date( 'd/m/Y H:i:s', time() ); ?></center>