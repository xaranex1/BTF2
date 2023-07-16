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
$user_info = user_information( (int) $_GET['id'] );
if ( !$user_info || $_GET['id'] == 1 ) {
    echo "<script type=\"text/javascript\">window.location = 'ranking.php'; </script>";
    exit;
}

$clan = clan_information( $user_info['id'] );

$pow = 0;
$def = 0;
$agi = 0;
$stam = 0;
$chr = 0;
$s_double = 0;
$s_block = 0;
$s_chance_kick = 0;
$s_chance_blow = 0;
$s_dam = 0;

$items = user_items( $user_info['id'] );
foreach ( $items as $item ) {
    if ( $item['stat'] == 'on' ) {
        $pow += $item['pow'];
        $def += $item['def'];
        $agi += $item['agi'];
        $stam += $item['stam'];
        $chr += $item['chr'];
        $s_double += $item['s_double'];
        $s_block += $item['s_block'];
        $s_chance_kick += $item['s_chance_kick'];
        $s_chance_blow += $item['s_chance_blow'];
        $s_dam += $item['s_dam'];
    }
}

if ( $user_info['pl_book_t'] > time() )
    $user_info['ab_pow'] = ceil( $user_info['ab_pow'] * 1.3 );

if ( $user_info['pl_grg_t'] > time() )
    $user_info['ab_pow'] = ceil( $user_info['ab_pow'] * 1.3 );

$max = max( array ( $user_info['ab_pow'] + $pow, $user_info['ab_def'] + $def, $user_info['ab_agi'] + $agi, $user_info['ab_stam'] + $stam, $user_info['ab_chr'] + $chr ) );

?>
<center>
    <br /><br />
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center" valign="top">
                <table>
                    <tr><td align="center" valign="top"><img src="<?php echo user_logo( $user_info ); ?>" border="0" width="170"></td></tr>
<?php if ( isset( $clan['k_id'] ) ): ?>
                    <tr><td align="center" valign="top"><a href="i_klan.php?id=<?php echo $clan['k_id']; ?>" ><img src="clanlogo/<?php echo file_exists( "logo/" . $clan['k_id'] . ".gif" ) ? $clan['k_id'] :  "un"; ?>.gif" border=0></a></td></tr>
<?php endif; ?>
                </table>
                <p align="center" valign="center" />
            </td>
            <td width="10">&nbsp;</td>
            <td valign="top">
                <table cellpadding="2" cellspacing="2" border="0" bordercolor=red width="100%">
                    <tr><td class="tdh" colspan="2" align="center"><?php echo $user_info['race'] == 1 ? 'Vampiro' : 'Lobisomen'; ?> <?php echo $user_info['name']; ?></td></tr>
                    <tr><td class="tdn">Saque:</td><td class="tdn"><?php echo $user_info['stat_prey']; ?></td></tr>
<?php if ( isset( $clan['k_id'] ) ): ?>
                    <tr><td class="tdn">Clã:</td><td class="tdn"><a href="info_user.php?id=<?php echo $clan['k_id']; ?>" ><?php echo $clan['k_name']; ?></a></td></tr>
                    <tr><td class="tdn">Estatística:</td><td class="tdn"><?php echo $clan['m_stat']; ?></td></tr>
<?php endif; ?>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td class="tdh" colspan="2" align="center">Descrição do personagem</td></tr>
                    <tr><td class="tdn" colspan="2" style="text-align:justify"><div style="overflow:hidden; width:100%;" align="center"><?php echo $user_info['desc']; ?></div></td></tr>
                    <tr><td colspan="2" align="center">&nbsp;</td></tr>
                    <tr><td colspan="2" class="tdh" align="center">Personagem <?php echo $user_info['name']; ?></td></tr>
                    <tr><td class="tdn">Nivel:</td><td class="tdn"><?php echo $user_info['level']; ?></td></tr>
                    <tr><td class="tdn">Força:</td><td class="tdn"><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( ( $user_info['ab_pow'] + $pow ) / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user_info['ab_pow'] + $pow; ?>)</span></td></tr>
                    <tr><td class="tdn">Defesa:</td><td class="tdn"><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( ( $user_info['ab_def'] + $def ) / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user_info['ab_def'] + $def; ?>)</span></td></tr>
                    <tr><td class="tdn">Destreza:</td><td class="tdn"><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( ( $user_info['ab_agi'] + $agi ) / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user_info['ab_agi'] + $agi; ?>)</span></td></tr>
                    <tr><td class="tdn">Resistencia:</td><td class="tdn"><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( ( $user_info['ab_stam'] + $stam ) / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user_info['ab_stam'] + $stam; ?>)</span></td></tr>
                    <tr><td class="tdn">Carisma:</td><td class="tdn"><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( ( $user_info['ab_chr'] + $chr ) / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user_info['ab_chr'] + $chr; ?>)</span></td></tr>
                    <tr>
                        <td colspan="2">
                            <table border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <table width="151" height="43" style="background-image:url('img/button.gif')">
                                            <tr>
                                                <td align="center"><a href="user_friend.php?add=<?php echo $user_info['id']; ?>" >+Amigo</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <?php if ( $user['race'] != $user_info['race'] ): ?>
                                    <td align="center">
                                        <table width="151" height="43" style="background-image:url('img/button.gif')">
                                            <tr>
                                                <td align="center"><a href="user_fight.php?to=<?php echo $user_info['id']; ?>" >Atacar</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <?php endif; ?>
                                    <td align="center">
                                        <table width="151" height="43" style="background-image:url('img/button.gif')">
                                            <tr>
                                                <td align="center"><a href="user_message_new.php?to=<?php echo $user_info['id']; ?>" >Enviar Mensagem</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td class="tdh" colspan="2" align="center">Estatisticas</td></tr>
                    <tr><td class="tdn">Vitimas Mordidas (link):</td><td class="tdn"><?php echo $user_info['stat_victim']; ?></td></tr>
                    <tr><td class="tdn">Total Roubado (Sangue/Carne):</td><td class="tdn"><?php echo $user_info['stat_prey']; ?></td></tr>
                    <tr><td class="tdn">Lutas:</td><td class="tdn"><?php echo $user_info['stat_battle']; ?></td></tr>
                    <tr><td class="tdn">Vitorias:</td><td class="tdn"><?php echo $user_info['stat_win']; ?></td></tr>
                    <tr><td class="tdn">Derrotas:</td><td class="tdn"><?php echo $user_info['stat_loss']; ?></td></tr>
                    <tr><td class="tdn">Empate:</td><td class="tdn"><?php echo $user_info['stat_draw']; ?></td></tr>
                    <tr><td class="tdn">Ouro Capturado:</td><td class="tdn"><?php echo $user_info['stat_gold_p']; ?> <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0"></td></tr>
                    <tr><td class="tdn">Ouro Perdido:</td><td class="tdn"><?php echo $user_info['stat_gold_m']; ?> <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0"></td></tr>
                    <tr><td class="tdn">Dano Causado:</td><td class="tdn"><?php echo $user_info['stat_dam_p']; ?></td></tr>
                    <tr><td class="tdn">Dano Sofrido:</td><td class="tdn"><?php echo $user_info['stat_dam_m']; ?></td></tr>
                </table>
            </td>
        </tr>
    </table>
</center>
<?php require 'include/tpl/footer.php'; ?>