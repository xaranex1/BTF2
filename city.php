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
?>
<script type="text/javascript" language="javascript">
    var tips = new Array();
    tips[3] = '<center><table cellspacing=2 cellpadding=2 border=0 valign=middle><tr><td align=center><img src="img/symbol_market.gif" alt="" border="0"></td><td align=left style=\'font-size: 20pt\'>Mercado</td></tr></table></center>';
    tips[4] = '<center><table cellspacing=2 cellpadding=2 border=0 valign=middle><tr><td align=center><img src="img/symbol_library.gif" alt="" border="0"></td><td align=left style=\'font-size: 20pt\'>Livraria</td></tr></table></center>';
    tips[5] = '<center><table cellspacing=2 cellpadding=2 border=0 valign=middle><tr><td align=center><img src="img/symbol_shop.gif" alt="" border="0"></td><td align=left style=\'font-size: 20pt\'>Shop</td></tr></table></center>';
    tips[6] = '<center><table cellspacing=2 cellpadding=2 border=0 valign=middle><tr><td align=center><img src="img/symbol_grotte.gif" alt="" border="0"></td><td align=left style=\'font-size: 20pt\'>Caverna</td></tr></table></center>';
    tips[7] = '<center><table cellspacing=2 cellpadding=2 border=0 valign=middle><tr><td align=center><img src="img/symbol_voodoo.gif" alt="" border="0"></td><td align=left style=\'font-size: 20pt\'>Loja VooDoo</td></tr></table></center>';
    tips[8] = '<center><table cellspacing=2 cellpadding=2 border=0 valign=middle><tr><td align=center><img src="img/symbol_graveyard.gif" alt="" border="0"></td><td align=left style=\'font-size: 20pt\'>Cemiterio</td></tr></table></center>';
    function show_light(ele) {
        if (document.getElementById( 'light' + ele ).style.display == 'none' ) {
            document.getElementById( 'light' + ele ).style.display = '';
            document.getElementById( 'tipbox' ).innerHTML = tips[ele];
            document.getElementById( 'tipbox' ).style.display = '';
        }
    }
    function hide_light(ele) {
        if ( document.getElementById( 'light' + ele ).style.display == '' ) {
            document.getElementById( 'light' + ele ).style.display = 'none';
            document.getElementById( 'tipbox' ).innerHTML = '';
            document.getElementById( 'tipbox' ).style.display = 'none';
        }
    }
</script>

<br/>
<h2>The city is filled with the smell of blood!</h2>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
    <tr>
        <td class="tdh" align="center">Central City</td>
    </tr>
    <tr>
        <td class="tdn" style="text-align:justify">
				In town you can buy objects or weapons to improve their abilities to combat its enemies. You can also find work in the graveyard to earn some gold! Choose a location below:
        </td>
    </tr>
    <tr>
        <td class="tdn" align="center">
            <div style="width:700px; height:400px; position:relative; top:0px; left:0px;">
                <div style="z-index:100; position:absolute;top:-1px;left:0px;"><img src="img/city/city.jpg" alt="" border="0"></div>
                <div style="z-index:101; position:absolute;top:0px;left:0px;">
                    <img src="img/city/8_over.gif" alt="" border="0" id="light8" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_graveyard.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>Graveyard</td></tr></table>')">
                    <img src="img/city/3_over.gif" alt="" border="0" id="light3" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_market.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>Shop</td></tr></table>')">
                    <img src="img/city/4_over.gif" alt="" border="0" id="light4" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_library.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>Library</td></tr></table>')">
                    <img src="img/city/5_over.gif" alt="" border="0" id="light5" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_shop.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>Merchant</td></tr></table>')">
                    <img src="img/city/6_over.gif" alt="" border="0" id="light6" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_grotte.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>Grotto</td></tr></table>')">
                    <img src="img/city/7_over.gif" alt="" border="0" id="light7" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_voodoo.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>VooDoo Shop</td></tr></table>')">
                    <img src="img/city/9_over.gif" alt="" border="0" id="light9" style="display:none;" onMouseOver="return escape('<table width=250 cellspacing=0 cellpadding=0 height=100 valign=middle style=\'background:111\'><tr><td align=right><img src=\'img/symbol_church.gif\' alt=\'\' border=\'0\'></td><td align=center style=\'font-size: 20pt\'>Church</td></tr></table>')">
                </div>
                <div style="z-index:102; position:absolute;top:0px;left:0px;">
                    <img src="img/city/0.gif" alt="" border="0" usemap="#city_Map" />
                    <map name="city_Map">
                        <area shape="poly" style="z-index:150;" alt="" title="" coords="546,252,548,289,538,298,546,310,567,308,579,318,599,322,585,343,536,349,500,344,471,323,456,298,460,274,474,260,519,252" href="city_cemetery.php" onMouseOver="show_light('8');" onMouseOut="hide_light('8');">
                        <area shape="poly" style="z-index:150;" alt="" title="" coords="354,330,302,291,228,280,140,294,119,304,99,319,128,372,109,390,110,398,314,398" href="city_market.php" onMouseOver="show_light('3');" onMouseOut="hide_light('3');">
                        <area shape="poly" style="z-index:150;" alt="" title="" coords="184,253,187,206,159,155,121,147,118,127,93,130,92,142,80,165,91,287" href="city_library.php" onMouseOver="show_light('4');" onMouseOut="hide_light('4');">
                        <area shape="poly" style="z-index:150;" alt="" title="" coords="375,236,375,209,393,207,391,183,346,123,322,107,314,85,312,121,278,173,290,197,290,226,309,244" href="city_shop.php" onMouseOver="show_light('5');" onMouseOut="hide_light('5');">
                        <area shape="poly" style="z-index:150;" alt="" title="" coords="615,380,577,353,599,324,645,316,672,339,691,367,659,376" href="city_grot.php" onMouseOver="show_light('6');" onMouseOut="hide_light('6');">
                        <area shape="poly" style="z-index:150;" alt="" title="" coords="3,7,21,16,45,56,78,93,93,300,77,274,3,305" href="city_ignicit.php" onMouseOver="show_light('7');" onMouseOut="hide_light('7');">
                    </map>
                </div>
                <div id="tipbox" style="display:none;z-index:103; position:absolute;top:5px;left:0px;height:80px;width:700px;vertical-align:middle;text-align:center;"></div>
            </div>
        </td>
    </tr>
    <tr><td class="tdh" align="center">Locations</td></tr>
    <tr>
        <td class="tdn">
            <table cellpadding="2" cellspacing="2" border="0" bordercolor=red width="100%" align="center">
                <tr>
                    <td><img src="img/symbol_shop.gif" alt="" border="0"></td>
                    <td><a href="city_shop.php" target="_top" >Shop</a></td>
                    <td>Here you will find everything you need. Weapons, equipment and potions are always available. Please check your money. The store owner never gives discount or credit. </td>
                </tr>
                <tr>
                    <td><img src="img/symbol_graveyard.gif" alt="" border="0"> </td>
                    <td><a href="city_cemetery.php" target="_top" >Graveyard</a></td>
                    <td>Gold can be earned by working at the cemetery. The place is yours as long as you decide to work hard. Your salary will be delivered at the end of the work. It also gives you some extra experience points. </td>
                </tr>
                <tr>
                    <td><img src="img/symbol_grotte.gif" alt="" border="0"> </td>
                    <td><a href="city_grot.php" target="_top" >Cavern</a></td>
                    <td>It is the entrance to a deep and mysterious cave. There are many rumors surrounding this cave, and everyone who entered in the vavern didn't returned to tell the tale. It is said that is the entrance to Hell.</td>
                </tr>
                <tr>
                    <td><img src="img/symbol_market.gif" alt="" border="0"> </td>
                    <td><a href="city_market.php" target="_top" >Merchant</a></td>
                    <td>Here you can change flesh, blood and souls for gold.</td>
                </tr>
                <tr>
                    <td><img src="img/symbol_library.gif" alt="" border="0"> </td>
                    <td><a href="city_library.php" target="_top" >Library</a></td>
                    <td>With the help of these talented counterfeiters, you have the opportunity to change your name. Obviously, you have to pay them because artists needs to be paid.</td>
                </tr>
                <tr>
                    <td><img src="img/symbol_voodoo.gif" alt="" border="0"> </td>
                    <td><a href="city_ignicit.php" target="_top" >VooDoo Shop</a></td>
                    <td>The VooDoo Shop exudes a strange magical energy. It is said that only in this store you can buy the mysterious stones of Hell.</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php require 'include/tpl/footer.php'; ?>
