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

if ( isset( $_POST['create'] ) ):
    $tag = isset( $_POST['tag'] ) ? $_POST['tag'] : '';
    $name = isset( $_POST['name'] ) ? $_POST['name'] : '';
    
    if ( strlen( $tag ) < 2 )
        $msg = "TAG demasiado curta";
    else if ( strlen( $tag ) > 8 )
        $msg = "TAG demasiado longa";
    else if ( strlen( $name ) < 2 )
        $msg = "O nome do Clã está muito curto";
    else if ( strlen( $name ) > 35 )
        $msg = "O nome do Clã está muito longo";
    else if ( clan_tag_in_use( $tag ) )
        $msg = "TAG em uso";
    else if ( clan_name_in_use( $name ) )
        $msg = "Nome em uso";
    else {
        clan_create( $user, $tag, $name );
        $msg = "O teu clã será fundado brevemente";
    }
?>
    <div>
        <h1>Clã | <a href="clan_new.php">regressar</a></h1>
        <h2>clan fundado</h2>
        <p>
            <table width="100%" border="0">
                <tr>
                    <td><?php echo $msg; ?></td>
                </tr>
            </table>
        </p>
    </div>
<?php else: ?>
    <div>
        <h1>Clã | <a href="clan.php">regressar</a></h1>
        <h2>clan fundado</h2>
        <form action="clan_new.php"  method="post">
            <p>
            <table width="100%" border="0">
                <tr>
                    <th>Clã-Tag do Clã (2..8 carateres)</th>
                    <td><center><input type="text" name="tag" maxlength="8" size="8" value=""></center></td>
                </tr>
                <tr>
                    <th>Clã-Nome (2..35 carateres)</th>
                    <td><center><input type="text" name="name" maxlength="35" size="20" value=""></center></td>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" name="create" value="fundar"></th>
                </tr>
            </table>
            </p>
        </form>
    </div>
<?php
endif;
require 'include/tpl/footer.php';
?>