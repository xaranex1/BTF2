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

if ( isset( $_POST['workDuration'] ) && !user_time_in_progress( $user ) ) {
    $_POST['workDuration'] = (int) $_POST['workDuration'];
    if ( $_POST['workDuration'] >= 9 && $_POST['workDuration'] <= 12 && $user['lord'] )
        user_time_work_start( $user, $_POST['workDuration'] );
    else if ( $_POST['workDuration'] >= 1 && $_POST['workDuration'] <= 8 )
        user_time_work_start( $user, $_POST['workDuration'] );
}

if ( isset( $_POST['abort'] ) ) {
    $action = user_time( $user, 1 );
    if ( $action )
        user_time_work_end( $user, $action );
}

$timer = user_time_in_progress( $user );

if ( !$timer ): // Verifica se tem algum time ativado ?>
<h2>Graveyard</h2>
<p class="buildingDesc">
    <img src="img/npc/0_2.jpg" align="left" />
    <table cellpadding="2" cellspacing="2" border="0">
        <tr>
            <td colspan="2" height="61" class="tdn">
                <p>Welcome, <?php echo $user['name']; ?></p>
                <p>You don't have enough gold? In the cemetery you can work as a gardener for the cemetery and you will get <?php echo user_time_work_gold_earn( $user['level'] ); ?> <img src="img/res2.gif" alt="Gold" align="absmiddle" border="0"> gold in 60 minutes.</p>
                <p>Working as: <?php echo user_time_work_name( $user['level'] ); ?></p>
            </td>
        </tr>
        <tr>
            <td class="tdn">Working Time</td>
            <td class="tdn">
                <form action="city_cemetery.php" method="post">
                    <select name="workDuration" size="1" class="input">
                        <option value="1">1:00:00 h</option>
                        <option value="2">2:00:00 h</option>
                        <option value="3">3:00:00 h</option>
                        <option value="4">4:00:00 h</option>
                        <option value="5">5:00:00 h</option>
                        <option value="6">6:00:00 h</option>
                        <option value="7">7:00:00 h</option>
                        <option value="8">8:00:00 h</option>
                        <?php if ( $user['lord'] ): ?>
                        <option value="9">9:00:00 h</option>
                        <option value="10">10:00:00 h</option>
                        <option value="11">11:00:00 h</option>
                        <option value="12">12:00:00 h</option>
                        <?php endif;?>
                    </select>
                    <input type="submit" class=input value="Work">
                </form>
            </td>
        </tr>
    </table>
</p>
<?php
elseif ( $timer == 1 ):
    require 'include/tpl/timer_work.php';
elseif ( $timer == 3 ):
    require 'include/tpl/timer_hunt.php';
endif;
require 'include/tpl/footer.php';
?>