<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */
error_reporting(E_ALL ^ E_DEPRECATED);
require 'include/config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>BiteFight</title>
        <link rel="stylesheet" type="text/css" href="game.css" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            .advertising *{margin:0 auto;}
            .advertising {text-align:center;}
        </style>
    </head>
    <body bgcolor="#220202" >
        <div id="container" style="padding-top:48px; margin-top:20px;">
            <img src="img/home_head.jpg" width="1035" height="48" style="position:absolute; left:-37px; top:0px;" alt="Bite Fight" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width:20px; background-image:url(img/border.gif); background-repeat:repeat-y; background-position:right;">&nbsp;</td>
                    <td style="width:156px; background-image:url(img/sidebg.jpg); background-repeat:repeat-y; background-position:left; vertical-align:top;">
                        <div id="menu" style="width:156px; background-image:url(img/menubg.jpg); background-repeat:repeat-y; background-position:left;">
                            <?php require $config['path'] . '/include/tpl/index_m.php'; ?>
                        </div>
                        <img src="img/menudivider.gif" width="156" height="17" alt="" />
                    </td>
                    <td style="width:16px; background-image:url(img/border.gif); background-repeat:repeat-y;">&nbsp;</td>
                    <td style="background-color:#000000; vertical-align:top; text-align:center;">
                        <div id="#content" style="position:relative;">
                            <img src="img/home_splash.jpg" alt="bitefight" width="784" height="415" border="0" usemap="#Map" />
                            <map name="Map">
                                <area shape="poly" coords="120,292,234,243" href="#">
                                <area shape="poly" coords="1,388,226,265,167,148,91,60,1,27" href="register.php?race=2" target="_top" title="Lobisomen">
                                <area shape="poly" coords="779,3,706,3,624,53,585,170,658,375,780,367" href="register.php?race=1" target="_top" title="Vampiro">
                            </map>
                            <table width="630" cellpadding="0" cellspacing="0" style="font-size:10px; position:absolute; top:380px; left:70px; z-index:3; text-align:center;">
                                <tr>
                                    <td style="width:210px; padding:0 20px;">
                                        Anda pela cidade<br>a procura de novas vitimas.
                                        <img src="img/home_thumb01.jpg" width="170" height="86" alt=""></td>
                                    <td style="width:210px; padding:0 20px;">
                                        Equipe-se para derrotar<br>os seus inimigos.
                                        <img src="img/home_thumb02.jpg" width="170" height="86" alt="">
                                    </td>
                                    <td style="width:210px; padding:0 20px;">
                                        Constrói um lugar seguro<br>com os seus amigos.
                                        <img src="img/home_thumb03.jpg" width="170" height="86" alt="">
                                    </td>
                                </tr>
                            </table>
                            <br><br><br>
                            <p style="position:absolute; top:230px; left:190px; display:block; width:400px; text-align:center; color:#f28900; font:bold 12px Verdana, Arial, Helvetica, sans-serif; line-height:24px; text-transform:uppercase; z-index:3;">
                                
                            </p>
                            <p align="center">
                                <a href="register.php" style="position:absolute; top:300px; left:180px; display:block; width:400px; height:72px; background:center center no-repeat url(img/home_redcloud.jpg); text-align:center; color:#fe6d6d; font:bold 18px Verdana, Arial, Helvetica, sans-serif; line-height:70px; text-decoration:underline;" target="_top">Jogue agora grátis!</a>
                            </p>
                        </div>
                        </div>
                    </td>
                    <td style="width:22px; background-image:url(img/border.gif); background-repeat:repeat-y; background-position:left;">&nbsp;</td>
                </tr>
            </table>
            <div class="fontsmall" style="position:absolute; width:800px; bottom:14px; right:30px;" ><b>Versão: 1.1 - © <?php echo date('Y'); ?> por ExtremsX</b></div>
            <img src="img/footer.jpg" width="998" height="92" style="display:block;" alt="" />
        </div>
    </body>
</html>
