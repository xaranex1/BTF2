<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

require 'include/config.php';
require 'include/tpl/top.php';

$to = isset( $_GET['to'] ) ? $_GET['to'] : 0;

$attacker = user_information( $_SESSION['id'] );
$defender = user_information( $to );

if ( $attacker['id'] == $defender['id'] )
    $msg = 'Este usuário já foi atacado recentemente';
else if ( $attacker['hp_now'] <= $config['game']['hp_min'] )
    $msg = 'Sua vida está muito baixa para atacar esse usuário';
else if ( $defender['hp_now'] <= $config['game']['hp_min'] )
    $msg = 'A vida do adversario está muito baixa para ser atacado';
else if ( $defender['time_attack'] > time() )
    $msg = 'Este usuário já foi atacado recentemente';
else if ( $attacker['race'] == $defender['race'] )
    $msg = 'Você não pode atacar jogadores da sua raça';

if ( !isset( $msg ) ) {
    user_attack( $attacker, $defender );
    echo "<script type=\"text/javascript\">window.location = 'user_message.php?box=in'; </script>";
    exit;
}
?>
<div>
    <h2>Não foi possivel atacar o jogador</h2>
    <p><?php echo $msg; ?></p>
</div>
<?php require 'include/tpl/footer.php'; ?>