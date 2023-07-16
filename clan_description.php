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
$clan = clan_information( $user );

if ( !$clan ) {
    echo "<script type=\"text/javascript\">window.location = 'clan.php'; </script>";
    exit;
}

if ( $clan['user_id'] != $user['id'] ) {
    echo "<script type=\"text/javascript\">window.location = 'clan_information.php'; </script>";
    exit;
}

if ( isset( $_POST['delete'] ) )
    clan_description( $clan, '' );
else if ( isset( $_POST['description'] ) && !empty( $_POST['description'] ) && strlen( $_POST['description'] ) <= 4000 )
    clan_description( $clan, $_POST['description'] );
?>
<div>
    <h1>Clã | <a href="clan_information.php" >voltar</a></h1>
    <h2>Aqui você pode descrever o teu Clã e os seus objetivos</h2>
    <p>
    <form action="clan_description.php" name="allydesc" method="post">
            <table width="100%">
                <tr>
                    <th>Descrição (<span id="charcount">4000</span> Carateres)</th>
                </tr>
                <tr>
                    <th>
                        <textarea name="description" cols="70" rows="20" onkeydown="CheckLen(this)" onkeyup="CheckLen(this)" onfocus="CheckLen(this)" onchange="CheckLen(this)"><?php echo $clan['desc']; ?></textarea>
                    </th>
                </tr>
                <tr>
                    <th>
                        <input type="submit" value="salvar">
                        <input type="submit" name="delete" value="apagar">
                    </th>
                </tr>
            </table>
        </form>
        <script language="JavaScript">
            function init() {
                var description = document.getElementsByName( 'description' )[1];
                CheckLen( description );
            }

            function CheckLen( Target ) {
                var maxlength = 4000;
                StrLen = Target.value.replace( /\r\n?/g, "\n" ).length;
                if (StrLen == 1 && Target.value.substring( 0, 1 ) == " " )
                {
                    Target.value = "";
                    StrLen = 0;
                }
                if ( StrLen > maxlength )
                {
                    Target.value = Target.value.substring( 0, maxlength );
                    CharsLeft=0;
                } else {
                    CharsLeft = maxlength - StrLen;
                }
                document.getElementById( 'charcount' ).innerHTML = CharsLeft;
            }
        </script>
    </p>
</div>
<?php require 'include/tpl/footer.php'; ?>