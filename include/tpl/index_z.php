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
                            <a href="user_main.php" target="_top">General View</a>
                            <a href="user_message.php" target="_top">Messages</a>
                            <a href="user_hideout.php" target="_top">Hideout</a>
                            <a href="city.php" target="_top">City</a>
                            <a href="aukce2.php" target="_top">Aukce</a>
                            <a href="hospoda.php" target="_top">Hospoda</a>
                            <a href="user_robbery.php" target="_top">Rob</a>
                            <br />
                            <a href="city_ignicit.php" target="_top" class="newmessage">VooDoo Shop</a>
                            <a href="clan.php" target="_top">Clan</a>
                            <a href="user_friends.php" target="_top">Friends</a>
                            <a href="user_note.php" target="_top">Notes</a>
                            <a href="user_settings.php" target="_top">Configurations</a>
                            <br />
                            <a href="<?php echo $config['url']['forum']; ?>" target="_blank">Forum</a>
                            <a href="ranking.php" target="_top">Ranking</a>
                            <a href="user_search.php" target="_top">Search</a>
                            <a href="faq.php" target="_top">Help</a>
                            <a href="logout.php" target="_top">Logout</a>
                            <br />
                            <center style="font-size: 0.7em;"><?php echo date( 'd/m/Y H:i:s', time() ); ?></center>