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

if ( isset( $_POST['time'] ) && !user_time_in_progress( $user ) ) {
    $_POST['time'] = (int) $_POST['time'];
    if ( $_POST['time'] >= 1 && $_POST['time'] <= 3 )
        user_time_mission_start( $user, $_POST['time'] );
}

$timer = user_time_in_progress( $user );

if ( !$timer ): // Verifica se tem algum time ativado ?>
<h2>Go into the underworld, <?php echo $user['name']; ?></h2>
<p class="tdn">Gold: <?php echo pretty_number( $user['gold'] ); ?> <img src="img/res2.gif" alt="Gold" align="absmiddle" border="0"></p>
<p class="buildingDesc">
    <img src="img/npc/0_4.jpg" align="left" />
<table cellpadding="2" cellspacing="2" border="0">
    <tr>
        <td class="tdn">
             The entrance looks like a wound in the earth.
			 Thorny bushes surround the entrance and the wind whistles a tune demonic.
             Looks like invisible eyes watching you from this black hole, and feel hatred welling up the opening.
        </td>
    </tr>
</table>
</p>
<table cellpadding="2" cellspacing="2" border="0" width="76%">
    <tr>
        <td class="tdh" align="center">Hunting Demons (Cost: 10 Gold)</td>
    </tr>
    <tr>
        <td class="tdn" align="center">
            Time of Hunt (Used 00:00:00.)<br/>
            <form action="city_grot.php" method="post">
                <input type="radio" name="time" value="1" checked>Duration: 00:10:00<br/>
                <input type="radio" name="time" value="2">Duration: 00:20:00<br/>
                <input type="radio" name="time" value="3">Duration: 00:30:00<br/>
                <br/>
                <input type="submit" class="input" value="Hunt" ><br />
            </form>
        </td>
    </tr>
    <tr>
        <td class="tdn">
			 Every day, you can hunt up to two hours.
             You can succeed in the hunt and get gold and experience, but you will not always successful in your hunts.
			 Durring the hunt, you can't do anything else.
        </td>
    </tr>
</table>
<?php
elseif ( $timer == 1 ):
    require 'include/tpl/timer_work.php';
elseif ( $timer == 3 ):
    require 'include/tpl/timer_hunt.php';
endif;
require 'include/tpl/footer.php';
?>