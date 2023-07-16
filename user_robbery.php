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
$hunting_time = user_time_hunt_time_used( $user );
if ( $user['lord'] )
    $hunting_time_max = ( 24 - $hunting_time > 12 ) ? 12 : ( 24 - $hunting_time );
else
    $hunting_time_max = 12 - $hunting_time;

if ( isset( $_POST['time'] ) && !user_time_in_progress( $user ) ) {
    $_POST['time'] = (int) $_POST['time'];
    if ( $_POST['time'] >= 1 && $_POST['time'] <= 12 )
        user_time_hunt_start( $user, $_POST['time'] );
} else if ( isset( $_POST['opt'] ) && !user_time_in_progress( $user ) ) {
    if ( $_POST['opt'] == 1 || $_POST['opt'] == 2 )
        user_time_hunt_start( $user, $_POST['opt'] );
}

$timer = user_time_in_progress( $user );

if ( !$timer ): ?>
<h1>Apetite para caçar de <?php echo $user['name']; ?></h1>
Ouro: <?php echo pretty_number( $user['gold'] ); ?> <img src="img/res2.gif" alt="Ouro" align="absmiddle" border="0">
<br/><br/><span class="text">Estás sedento de uma bela dose de sangue. Escolhe agora o teu método de caça preferido para o ataque. Podes procurar ao calhas por <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?> e desafia-los para lutar, ou podes procurar por algum <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?> especifico caso saibas o nome dele!</span>
<br/>
<div>
    <form action="user_robbery.php" method="post">
	<div style="width:340px; float:right;">
            <img src="img/race2hunt0.jpg" alt="Caça ao humano"><br/><br/>
            <h2>Caçada humana (custa 10 de ouro)</h2><br/>
            <div class="tdi">Tempo de caça (já usando <?php echo user_time_hunt_time_used_pretty( $hunting_time ); ?>)<br /> 
<?php if ( ( $user['lord'] && $hunting_time < 24 ) || ( !$user['lord'] && $hunting_time < 12 ) ): ?>
                <select name="time" size="1" class="input">
                    <?php for ( $i = 1; $i <= $hunting_time_max; $i++ ): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?>0 minutos</option>
                    <?php endfor; ?>
                </select>
                <input type="submit" class=input value="OK!">
<?php else: ?>
                Você já usou todo o tempo disponivel.
<?php endif; ?>
            </div>
            <p>Escolha se você gostaria de caçar <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?> ou seres humanos. Cada dia é capaz de caçar durante quatro horas. Você pode reunir presa, ouro e/ou experiência depois de uma caçada bem sucedida; porém sua caça não é sempre bem sucedida! Durante a sua caça, você não pode fazer outra coisa.</p>
	</div>
    </form>

    <div style="border-left-color:#7d7572; border-left-width:1px; border-left-style:solid; width:20px; height:400px; float:right;"></div>
    <div style="width:340px;">
        <img src="img/race1hunt2.jpg" alt="Caça aos <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?>"><br/><br/>
        <h2>Caça aos <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?></h2>
        <form action="user_robbery.php" method="post">
            <p class="tdnp">Procurar por <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?> nos arredores (Custo: 1 Moeda de Ouro)</p>
            <div class="tdi">Opções de pesquisa:<br /> 
                <select name="opt" size="1" class="input">
                    <option value="1">normal</option>
                    <option value="2">procurar rivais do mesmo nível ou superior</option>
                </select>
                <input type="submit" class=input value="OK!" />
            </div>
        </form>	
        <form action="user_robbery.php" method="post">
            <h2>Procura por um <?php echo $user['race'] == 1 ? 'lobisomens' : 'vampiros'; ?> específico (Custo: 1 Moeda de Ouro)</h2>
            <div class="tdi">Nome:<br /> 
                <input class="input" type="text" name="name" size="30" value="" maxlenght="30">
                <input type="submit" class=input value="OK!">
            </div>
        </form>
    </div>
</div>
<?php
elseif ( $timer == 1 ):
    require 'include/tpl/timer_work.php';
elseif ( $timer == 3 ):
    require 'include/tpl/timer_hunt.php';
endif;
require 'include/tpl/footer.php';
?>