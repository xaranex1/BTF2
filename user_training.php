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

$cost[1] = user_training_cost( $user['ab_pow'], 'pow' );
$cost[2] = user_training_cost( $user['ab_def'], 'def' );
$cost[3] = user_training_cost( $user['ab_agi'], 'agi' );
$cost[4] = user_training_cost( $user['ab_stam'], 'stam' );
$cost[5] = user_training_cost( $user['ab_chr'], 'chr' );

if ( isset( $_GET['b'] ) && isset( $cost[$_GET['b']] ) && $user['gold'] >= $cost[$_GET['b']] )
    user_training( $user, $_GET['b'], $cost[$_GET['b']] );

$max = max( array( $user['ab_pow'], $user['ab_def'], $user['ab_agi'], $user['ab_stam'], $user['ab_chr'] ) ); 
?>
<h2><center>Aqui poderá treinar as suas habilidades para se tornar mais forte e mais bem sucedido.</center></h2>
<div id="training">
    <h2>Treinamento</h2>
    <table cellpadding="2" cellspacing="2" width="100%" border="0" bordercolor="red">
        <tr>
            <td>Ouro:</td>
            <td><?php echo pretty_number( $user['gold'] ); ?> <img src="img/res2.gif" alt="Ouro" align="absmiddle" border="0"></td>
        </tr>
    </table>
    <h2>Competências</h2>
    <table cellpadding="2" cellspacing="2" width="100%" border="0" bordercolor="red">
        <tr>
            <td>Força:</td>
            <td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( $user['ab_pow'] / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user['ab_pow']; ?>)</span></td>
            <td>
                <?php if ( $user['gold'] >= $cost[1] ): ?>
                <a href="user_training.php?b=1" target="_top" class="headlines">Custo do treino <?php echo pretty_number( $cost[1] ); ?><img src="img/res2.gif" alt="Força" align="absmiddle" border="0"></a>
                <?php else: ?>
                Custo do treino <?php echo pretty_number( $cost[1] ); ?><img src="img/res2.gif" alt="Força" align="absmiddle" border="0">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Defesa:</td>
            <td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( $user['ab_def'] / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user['ab_def']; ?>)</span></td>
            <td>
                <?php if ( $user['gold'] >= $cost[2] ): ?>
                <a href="user_training.php?b=2" target="_top" class="headlines">Custo do treino <?php echo pretty_number( $cost[2] ); ?><img src="img/res2.gif" alt="Defesa" align="absmiddle" border="0"></a>
                <?php else: ?>
                Custo do treino <?php echo pretty_number( $cost[2] ); ?><img src="img/res2.gif" alt="Defesa" align="absmiddle" border="0">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Destreza:</td>
            <td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( $user['ab_agi'] / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user['ab_agi']; ?>)</span></td>
            <td>
                <?php if ( $user['gold'] >= $cost[3] ): ?>
                <a href="user_training.php?b=3" target="_top" class="headlines">Custo do treino <?php echo pretty_number( $cost[3] ); ?> <img src="img/res2.gif" alt="Destreza" align="absmiddle" border="0"></a>
                <?php else: ?>
                Custo do treino <?php echo pretty_number( $cost[3] ); ?> <img src="img/res2.gif" alt="Destreza" align="absmiddle" border="0">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Resistência:</td>
            <td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( $user['ab_stam'] / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user['ab_stam']; ?>)</span></td>
            <td>
                <?php if ( $user['gold'] >= $cost[4] ): ?>
                <a href="user_training.php?b=4" target="_top" class="headlines">Custo do treino <?php echo pretty_number( $cost[4] ); ?> <img src="img/res2.gif" alt="Resistência" align="absmiddle" border="0"></a>
                <?php else: ?>
                Custo do treino <?php echo pretty_number( $cost[4] ); ?> <img src="img/res2.gif" alt="Resistência" align="absmiddle" border="0">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Carisma:</td>
            <td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ceil( $user['ab_chr'] / $max * 200 ); ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo $user['ab_chr']; ?>)</span></td>
            <td>
                <?php if ( $user['gold'] >= $cost[5] ): ?>
                <a href="user_training.php?b=5" target="_top" class="headlines">Custo do treino <?php echo pretty_number( $cost[5] ); ?> <img src="img/res2.gif" alt="Carisma" align="absmiddle" border="0"></a>
                <?php else: ?>
                Custo do treino <?php echo pretty_number( $cost[5] ); ?> <img src="img/res2.gif" alt="Carisma" align="absmiddle" border="0">
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<?php require 'include/tpl/footer.php'; ?>