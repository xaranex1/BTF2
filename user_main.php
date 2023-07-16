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

$user = user_information( $_SESSION['id'] );
$item_id = isset( $_GET['item'] ) ? (int) $_GET['item'] : 0;

// Usa um item
if ( isset( $_GET["useItem"] ) )
    user_item_use( $user, $_GET["useItem"] );

// Equipa ou desequipa um item
if ( @$_GET['act'] == 'on' )
    user_item_equip( $user, $item_id );
if ( @$_GET['act'] == 'off' )
    user_item_unequip( $user, $item_id );

$hp_rec = 60 * ceil( $user['hp_max'] - $user['hp_now'] / ceil( $user['hp_max'] / 480 ) );
$items_string = '';
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

$items = user_items( $user['id'] );
foreach( $items as $item ) {
    if ( $item['stat'] ) {
        $items_string .= "        <tr>\n";
        $items_string .= "            <td width=\"300px\" class=\"active\"><img src=\"img/item/{$item['id']}.jpg\" alt=\"{$item['item']}\" ></td>\n";
        $items_string .= "            <td class=\"active\">\n";
        $items_string .= "                <strong>{$item['item']} (<a href=\"user_main.php?item={$item['item_id']}&act=off\" style=\"color:yellow\">Deaktivovat</a>)<br /><a href=\"market.php?sell={$item['item_id']}\" style=\"color:yellow\">Vender</a></strong>\n";
        $items_string .= "                <br />Tenho: {$item['vol']}<br />\n";

        if ( $item['pow'] )
            $items_string .= "Forcas +{$item['pow']}<br />";
        if ( $item['def'] )
            $items_string .= "Defesa +{$item['def']}<br />";
        if ( $item['agi'] )
            $items_string .= "Agilidade +{$item['agi']}<br />";
        if ( $item['stam'] )
            $items_string .= "Stamina +{$item['stam']}<br />";
        if ( $item['chr'] )
            $items_string .= "Carisma +{$item['chr']}<br />";
        if ( $item['s_double'] )
            $items_string .= "Ataque Duplo +{$item['s_double']}<br />";
        if ( $item['s_block'] )
            $items_string .= "Bloqueio +{$item['s_block']}<br>";
        if ( $item['s_chance_kick'] )
            $items_string .= "Chance de Fugir +{$item['s_chance_kick']}<br />";
        if ( $item['s_chance_blow'] )
            $items_string .= "Chance de Bloquear +{$item['s_chance_blow']}<br />";
        if ( $item['s_dam'] )
            $items_string .= "Damege +{$item['s_dam']}<br />";
        $items_string .= "Level Nescessario: {$item['lvl']}\n";
        $items_string .= "            </td>\n        </tr>\n";

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
    } else {
        $items_string.="<tr><td class='active' width=\"300px\"><img src='img/item/{$item['id']}.jpg' alt={$item['item']} ></td><td class='active'><strong>{$item['item']} (<a style=\"color:yellow\" href=\"user_main.php?item={$item['item_id']}&act=on\">Aktivovat</a>) <a style=\"color:yellow\" href=\"market.php?sell={$item['item_id']}\"><br />Prodat</a></strong><br>Tenho: {$item['vol']}<br />"; //äëÿ âûâîäà ñïèñêà âåùåé
        
        if ( $item['pow'] != 0 )
            $items_string .= "Forca +{$item['pow']}<br />";
        if ( $item['def'] != 0 )
            $items_string .= "Defesa +{$item['def']}<br />";
        if ( $item['agi'] != 0 )
            $items_string .= "Agilidade +{$item['agi']}<br />";
        if ( $item['stam'] != 0 )
            $items_string .= "Stamina +{$item['stam']}<br />";
        if ( $item['chr'] != 0 )
            $items_string .= "Carisma +{$item['chr']}<br />";
        if ( $item['s_double'] != 0 )
            $items_string .= "Ataque Duplo +{$item['s_double']}<br />";
        if ( $item['s_block'] != 0 )
            $items_string .= "Bloqueio +{$item['s_block']}<br />";
        if ( $item['s_chance_kick'] != 0 )
            $items_string .= "Chance de Fugir +{$item['s_chance_kick']}<br />";
        if ( $item['s_chance_blow'] != 0 )
            $items_string .= "Chance de Bloquear +{$item['s_chance_blow']}<br />";
        if ( $item['s_dam'] != 0 )
            $items_string .= "Damege +{$item['s_dam']}<br />";
            
        $items_string .= "Level Nescessario: " . $item['lvl'];
        $items_string .= "            </td>\n        </tr>\n";
    }
};

if ( @$user['pl_book_t'] > time() ) {
    $user['ab_pow'] = ceil( $user['ab_pow'] * 1.3 );
}
if ( @$user['pl_grg_t'] > time() ) {
    $user['ab_def'] = ceil( $user['ab_def'] * 1.3 );
}

db_query( "SET @i = 0" );
db_query( "SELECT r.rank FROM (SELECT @i:=@i+1 AS rank, id, name, exp FROM user ORDER BY exp DESC) AS r WHERE r.id=?", $user['id'] );
$u_ranking = db_fetch();

db_query( "SET @i = 0" );
db_query( "SELECT clan_id FROM clan_user WHERE user_id=?", $user['id'] );
if ( db_num_rows() ) {
    $u_klan_id = db_fetch();
    
    db_query( "SET @i = 0" );
    db_query( "SELECT rk.rank FROM (SELECT @i:=@i+1 AS rank, r.id FROM (SELECT u.id, u.exp FROM user u LEFT JOIN clan_user k ON u.id=k.user_id WHERE k.clan_id={$u_klan_id['clan_id']} ORDER BY u.exp DESC) AS r) AS rk WHERE rk.id=?", $user['id'] );
    $k_ranking = db_fetch();
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<center><h2>General View</h2></center>
<table>
    <tr>
        <th valign="top">
            <a href="user_avatar.php" ><img src="<?php echo $user['avatar']; ?>" border=0 width=170><br/>Edit Image</a>
        </th>
        <th>
    <div id="keyinfo">
        <h2><?php echo $user['race'] == 1 ? "Vampire" : "Werewolf"; ?> <b><font color=yellow><?php echo $user['name']; ?></font></b></h2>
        <table cellpadding="2" cellspacing="2" width="100%" border=0 bordercolor=red>
            <tr>
                <td>Gold:</td>
                <td><?php echo pretty_number( $user['gold'] ); ?> <img src="img/res2.gif" alt="Gold" align="absmiddle" border="0"></td>
            </tr>
            <tr>
                <td><a href="city_ignicit.php">Stones of Hell</a>:</td>
                <td><?php echo pretty_number( $user['ignicit'] ); ?> <img src="img/res3.gif" alt="Pedras do Inferno" align="absmiddle" border="0"></td>
            </tr>
            <tr>
                <td>Classification:</td>
                <td><?php echo pretty_number( $u_ranking['rank'] ); ?></td>
            </tr>
            <tr>
                <td>Clan Classification:</td>
                <td><?php echo isset( $k_ranking ) ? pretty_number( $k_ranking['rank'] ) : 'You are not in a clan'; ?></td>
            </tr>
            <?php if ( $hp_rec != '' || $hp_rec != 0 ) { ?>
                <tr>
                    <td><script type="text/javascript">v=new Date();var bx0=document.getElementById('bx0');function tbx0(){n=new Date();s=<?php echo $hp_rec; ?>-Math.round((n.getTime()-v.getTime())/1000.);m=0;h=0;if(s<0){bx0.innerHTML='---';document.location=document.location;}else{if(s>59){m=Math.floor(s/60); s=s-m*60}if(m>59){h=Math.floor(m/60);m=m-h*60} if(s<10){s="0"+s}if(m<10){m="0"+m}bx0.innerHTML=" "+h+":"+m+":"+s+'';document.title=h+':'+m+':'+s+' BiteFight';window.setTimeout("tbx0();",999);}}tbx0();</script></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div id="bitelink">
        <h2>Your link for hunting across the internet:</h2>
        <table width="100%" border=0 bordercolor=red>
            <tr><td><p><?php echo $config['url']['server']; ?>c.php?id=<?php echo $user['id']; ?></p></td></tr>
            <tr><td><p>Tip: You can add this link to your forum signature or homepage, or give it to your friends. Not intended to use for spamming forums, books or visitors in chat rooms. Players caught doing so will be deleted without notice. If someone clicks on your link, it will be bitten and you'll receive blood and gold!</p></td></tr>
        </table>
    </div>
</th>
</tr>
</table>
<div id="skills">
    <h2>Skills</h2>
    <table cellpadding="2" cellspacing="2" width="100%" border=0 bordercolor=red>
        <tr>
            <td>Level:</td>
            <td><?php echo user_calculate_level( $user['exp'] ); ?></td>
        </tr>
        <?php $max = max( array( $user['ab_pow'] + $pow, $user['ab_def'] + $def, $user['ab_agi'] + $agi, $user['ab_stam'] + $stam, $user['ab_chr'] + $chr ) ); ?>
        <tr>
            <td>Power:</td><td valign="top"><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ( $user["ab_pow"] + $pow ) * 200 / $max; ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo pretty_number( $user['ab_pow'] + $pow ); ?>)</span></td>
        </tr>
        <tr>
            <td>Defense:</td><td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ( $user["ab_def"] + $def ) * 200 / $max; ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo pretty_number( $user['ab_def'] + $def ); ?>)</span></td>
        </tr>
        <tr>
            <td>Skill:</td><td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ( $user["ab_agi"] + $agi ) * 200 / $max; ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo pretty_number( $user['ab_agi'] + $agi ); ?>)</span></td>
        </tr>
        <tr>
            <td>Resistance:</td><td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ( $user["ab_stam"] + $stam ) * 200 / $max; ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo pretty_number( $user['ab_stam'] + $stam ); ?>)</span></td>
        </tr>
        <tr>
            <td>Carisma:</td><td><img src="img/b1.gif" alt="" ><img src="img/b2.gif" alt="" height="12" width="<?php echo ( $user["ab_chr"] + $chr ) * 200 / $max; ?>"><img src="img/b3.gif" alt="" > <span class="fontsmall">(<?php echo pretty_number( $user['ab_chr'] + $chr ); ?>)</span></td>
        </tr>
        <tr>
            <td>Experience:</td>
            <td>
                <img src="img/b1.gif" alt=""><?php echo bar_skill( $user['exp_now'], $user['exp_need'] ); ?> <span class="fontsmall">(<?php echo $user['exp_now']; ?>/<?php echo $user['exp_need']; ?>)</span>
            </td>
        </tr>
        <tr>
            <td>Energy:</td>
            <td>
                <img src="img/b1.gif" alt=""><?php echo bar_skill( $user['hp_now'], $user['hp_max'] ); ?> <span class="fontsmall">(<?php echo $user['hp_now']; ?>/<?php echo $user['hp_max']; ?>)</span>
            </td>
        </tr>
    </table>
    <h2>Special Skills</h2>
    <table cellpadding="2" cellspacing="2" width="100%" border=0 bordercolor=red>
        <tr>
            <td>Golpe Duplo:</td>
            <td><?php echo $s_double; ?></td>
        </tr>
        <tr>
            <td>Bloqueio de Golpe:</td>
            <td><?php echo $s_block; ?></td>
        </tr>
        <tr>
            <td>Oportunidade de Golpe:</td>
            <td><?php echo $s_chance_kick ?></td>
        </tr>
        <tr>
            <td>Oportunidade de Fuga:</td>
            <td><?php echo $s_chance_blow; ?></td>
        </tr>
        <tr>
            <td>Weapon Damage:</td>
            <td><?php echo $s_dam; ?></td>
        </tr>
    </table>


    <a href="user_training.php" class="buttonlink">Train</a>
</div>
<div id="stats">
    <h2>Statistics:</h2>
    <table cellpadding="2" cellspacing="2" width="100%" border="0" bordercolor="red">
        <tr>
            <td>Victim Bites (link):</td><td><?php echo $user['stat_victim']; ?></td>
        </tr>
        <tr>
            <td>Total Stolen (Blood / Meat):</td><td><?php echo $user['stat_prey']; ?></td>
        </tr>
        <tr>
            <td>Total Battles:</td><td><?php echo $user['stat_battle']; ?></td>
        </tr>
        <tr>
            <td>Wins:</td><td><?php echo $user['stat_win']; ?></td>
        </tr>
        <tr>
            <td>Losses:</td><td><?php echo $user['stat_loss']; ?></td>
        </tr>
        <tr>
            <td>Draws:</td><td><?php echo $user['stat_draw']; ?></td>
        </tr>
        <tr>
            <td>Gold Won:</td>
            <td><?php echo $user['stat_gold_p']; ?> <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0"></td>
        </tr>
        <tr>
            <td>Gold Lost:</td>
            <td><?php echo $user['stat_gold_m']; ?> <img src="img/res2.gif" alt="çîëîòî" align="absmiddle" border="0">
            </td>
        </tr>
        <tr>
            <td>Damage Done:</td><td><?php echo $user['stat_dam_p']; ?></td>
        </tr>
        <tr>
            <td>Life Points Lost:</td><td><?php echo $user['stat_dam_m']; ?></td>
        </tr>
    </table>
</div>

<?php
function get_random_item($user_level) {

    $random_model = rand(1, 6);  // Generate random number between 1 and 6
    
    $result = mysql_query("SELECT * FROM item WHERE lvl = $user_level AND model = {$random_model}");
    $item = mysql_fetch_assoc($result);


    return $item;
  }
  
      
    echo "<form method='POST'>";
    echo "<button type='submit' id='generate_item'>Generate Item</button>";
    echo "</form>";
  
  
  function generate_item_submit() {
    $user = user_information( $_SESSION['id'] );
    $user_level = $user['level'];
    
    $item = get_random_item((float) $user_level); 
    
    echo "<div id='modal' class='modal'>";
    echo "<div class='modal-content'>";
    echo "<img src='img/item/{$item['id']}.jpg' alt='{$item['item']}'>";
    echo "<p>{$item['item']}</p>";
    echo "<p>{$item['cost_gold']}</p>";
    echo "<button id='close'>Close</button>"; 
    echo "</div>";
    echo "</div>";
    
    echo "<script>
    var modal = document.getElementById('modal');
    modal.style.display = 'block';
    
    var close = document.getElementById('close');
    close.addEventListener('click', function() {
      modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(e) {
      if (e.target == modal) {
        modal.style.display = 'none'; 
      }
    });
    </script>";

  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    generate_item_submit(); 
  } else {
   
  }
  ?>




<div id="items">
    <table cellpadding="2" cellspacing="2"  width="100%" border=0 bordercolor=red>
        <tr>
            <td colspan="2" align="center"><h2>Items</h2></td>
        </tr>
        <?php echo $items_string; ?>
    </table>
</div>
<?php require 'include/tpl/footer.php'; ?>