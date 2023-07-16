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
<h1>Hunt Humans</h1>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
    <tr>
        <td class="tdh">Hunt</td>
    </tr>
    <tr>
        <td class="tdn">
            Are you still hunting! Once you get back you will see what you were able to capture.
            <br/><br/>
            Good Luck!
            <br/><br/>
            Remaining Time: <span id="graveyardCount" ></span> minutos
            <br/><br/>
            <form action="user_robbery.php"  method="post">
                <div class="btn-left center">
                    <input type="submit" class="btn" name="abort" value="Quit">
                </div>
            </form>
        </td>
    </tr>
    <tr><td class="tdh">&nbsp;</td></tr>
</table>
<script type="text/javascript">
    $(function () {
        $("#graveyardCount").countdown({until: +<?php echo user_time_in_progress_remainder( $user ); ?>, compact: true, compactLabels: ['y', 'm', 'w', 'd'],
            description: '',onExpiry: redirectUser,onTick: titleCountdown});
    });
    function redirectUser() {
        setTimeout('window.location = "user_robbery.php"', 3000);
    }
        function twoDigits(value) {
        return (value < 10 ? '0' : '') + value;
    }
    function titleCountdown(periods) {
        var days = '';
        if (periods[3] > 0) {
            days = periods[3]+'d ';
        }
        document.title =  days+periods[4] + ':' + twoDigits(periods[5]) + ':' + twoDigits(periods[6])+' BiteFight';
    }
</script>
