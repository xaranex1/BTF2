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

if ( isset( $_POST['design'][1] ) )
    clan_logo( $clan, (int) key( $_POST["design"][1] ), 1 );

if ( isset( $_POST['design'][2] ) )
    clan_logo( $clan, (int) key( $_POST["design"][2] ), 2 );
?>
<div>
    <h1>Clã | <a href="k_info.php" >regressar</a></h1>
    <h2>Editar o símbolo do Clã</h2>
    <p>
        <table width="100%">
            <form action="clan_logo.php?opt=<?php echo @$_GET['opt'] == 1 ? 1 : 2; ?>" method="post">
                <tr>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th align="center"><img src="http://s1.br.bitefight.org/img/logo/0/tmp/<?php echo $clan['logo']; ?>.png" border="0"></th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th>
                        <table width="100%">
                            <tr>
                                <th align="center">
                                    <a href="?opt=1" >Imagem de fundo</a>&nbsp;
                                    <a href="?opt=2" >Símbolo</a>
                                </th>
                            </tr>
                            <tr>
                                <th align="center">
                                    <?php if ( @$_GET["opt"] == 1 ): ?>
                                    <table cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td><input type="image" src='img/clan/logo/1_9.png' name="design[1][9]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_8.png' name="design[1][8]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_5.png' name="design[1][5]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_10.png' name="design[1][10]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_3.png' name="design[1][3]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_2.png' name="design[1][2]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_7.png' name="design[1][7]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_4.png' name="design[1][4]" value="" width="60" height="60" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="image" src='img/clan/logo/1_6.png' name="design[1][6]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/1_1.png' name="design[1][1]" value="" width="60" height="60" border="0"></td>
                                        </tr>
                                    </table>
                                    <?php else: ?>
                                    <table cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td><input type="image" src='img/clan/logo/2_6.png' name="design[2][6]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_23.png' name="design[2][23]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_9.png' name="design[2][9]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_1.png' name="design[2][1]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_10.png' name="design[2][10]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_13.png' name="design[2][13]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_11.png' name="design[2][11]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_8.png' name="design[2][8]" value="" width="60" height="60" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="image" src='img/clan/logo/2_16.png' name="design[2][16]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_5.png' name="design[2][5]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_20.png' name="design[2][20]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_4.png' name="design[2][4]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_3.png' name="design[2][3]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_7.png' name="design[2][7]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_17.png' name="design[2][17]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_2.png' name="design[2][2]" value="" width="60" height="60" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="image" src='img/clan/logo/2_22.png' name="design[2][22]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_12.png' name="design[2][12]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_21.png' name="design[2][21]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_14.png' name="design[2][14]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_15.png' name="design[2][15]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_19.png' name="design[2][19]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_18.png' name="design[2][18]" value="" width="60" height="60" border="0"></td>
                                            <td><input type="image" src='img/clan/logo/2_24.png' name="design[2][24]" value="" width="60" height="60" border="0"></td>
                                        </tr>
                                    </table>
                                    <?php endif; ?>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                </tr>
            </form>
        </table>
    </p>
</div>
<?php require 'include/tpl/footer.php'; ?>