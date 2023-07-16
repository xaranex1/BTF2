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

if ( isset( $_POST['donation'] ) )
    clan_hideout_donation( $clan, $user, $_POST['donation'] );

if ( isset( $_GET['upgradecastle'] ) )
    clan_hideout_update( $clan, $user );
?>
<div>
    <h1>Clã</h1>
    <h2>Clã [<?php echo $clan["tag"]; ?>]</h2>
    <p>
    <table width="100%">
        <tr>
            <td rowspan="10"><a href="clan_logo.php"><img src="http://s1.br.bitefight.org/img/logo/0/tmp/<?php echo $clan["logo"]; ?>.png" border="0"></a></td>
        </tr>
        <tr>
            <td>Nome</td>
            <th><?php echo $clan["name"]; ?></th>
        </tr>
        <tr>
            <td>Página inicial</td>
            <th>
                <?php if ( $clan['site'] != "" && $clan['site'] != 'http://' ): ?>
                <a href="clan_homepage.php?site=<?php echo $clan['id']; ?>" target="_blank"><?php $clan['site']; ?></a> (<?php echo $clan["site_hits"]; ?> Visitantes)
                <?php else: ?>
                Página de clã indisponível
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <td>Roubo total</td>
            <th><?php echo pretty_number( $clan['total_prey'] ); ?> L/KG</th>
        </tr>
        <tr>
            <td>Membros</td>
            <th><a href="i_klan_memb.php?id=<?php echo $clan['id']; ?>"><?php echo clan_hideout_total_memb( $clan ); ?> / <?php echo clan_hideout_max_memb( $clan['castle'] ); ?> Membro</a></th>
        </tr>
        <tr>
            <td>Capital</td>
            <th><?php echo pretty_number( $clan['gold'] ); ?> <img src="img/res2.gif"  title="Ouro" align="absmiddle" border="0" /></th>
        </tr>
        <tr>
            <td>O seu rank</td>
            <th>Fundador</th>
        </tr>
    </table>
</p>
<br/>
<?php if ( $clan['user_id'] == $user['id'] ): ?>
    <h2>Configurações do Clã</h2>
    <p>
    <table width="100%">
        <tr>
            <th colspan=2><a href="clan_description.php" >Adicionar uma descrição</a></th>
        </tr>
        <tr>
            <th colspan=2><a href="clan_logo.php" >Editar o símbolo do Clã</a></th>
        </tr>
        <tr>
            <th colspan=2><a href="clan_homepage.php" >Definir Página Inicial</a></th>
        </tr>
        <tr>
            <th colspan=2><a href="clan_tag.php" >Mudar a TAG do Clã</a>&nbsp; | &nbsp; <a href="clan_name.php" >Mudar o nome do Clã</a></th>
        </tr>
    </table>
    </p>
    <br/>
<?php endif; ?>
<h2>Vista do esconderijo do Clã</h2>
<p>
    <table cellpadding='0' cellspacing='0' border='0' width='584' align='center'>
        <tr>
            <td style="background-image:url('img/clan/bg1.jpg'); background-repeat:no-repeat; background-position:center;" align="center">
                <img src="img/clan/stufe<?php echo $clan['castle']; ?>.gif" /><div style="position:relative; top:-50px;"></div>
            </td>
        </tr>
    </table>
</p>
<?php if ( $clan['user_id'] == $user['id'] ): ?>
    <h2>Esconderijo do Clã</h2>
    <p>
    <table width="100%">
        <tr>
            <th colspan="3">Capital: <?php echo $clan["gold"]; ?> <img src="img/res2.gif"  title="Ouro" align="absmiddle" border="0" /></th>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <?php if ( $clan['castle'] < 16 ): ?>
        <tr>
            <th align="right">Nível: <?php echo $clan['castle'] + 1; ?></th>
            <th align="right">Membros: <?php echo clan_hideout_max_memb( $clan['castle'] + 1 ); ?></th>
            <th align="center">
                <?php if ( $clan['gold'] >= clan_hideout_update_cost( $clan['castle'] ) && $user['id'] == $clan['user_id'] ): ?>
                <a href="?upgradecastle">Custo do próximo nível<br/><?php pretty_number( clan_hideout_update_cost( $clan['castle'] ) ); ?><img src="img/res2.gif" title="Ouro" align="absmiddle" border="0" />
                <?php else: ?>
                Custo do próximo nível<br/><?php echo pretty_number( clan_hideout_update_cost( $clan['castle'] ) ); ?><img src="img/res2.gif"  title="Ouro" align="absmiddle" border="0" />
                <?php endif; ?>
            </th>
        </tr>
        <?php endif; ?>
<?php endif; ?>
</table>
</p>
<h2>Doação para os cofres do Clã</h2>
<p>
    <form action="clan_information.php" method="post">
        <table width="50%" align="center">
            <tr>
                <th width="50%">O seu ouro:</th>
                <th align="right"><?php echo $user['gold']; ?> <img src="img/res2.gif"  title="Ouro" align="absmiddle" border="0" /></th>
            </tr>
            <tr>
                <th>Quanto esta disposto a gastar?</th>
                <th align="right">
                    <input type="text" name="donation" size="10" maxlength="10"> <img src="img/res2.gif"  title="Ouro" align="absmiddle" border="0" />
                </th>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" name="donate" value="doar"></th>
            </tr
        </table>
    </form>
</p>
<br/>
<h2>Descrição do Clã</h2>
<?php if ( empty( $clan['desc'] ) ): ?><p style="text-align: center">Sem descrição</p><?php else: ?><p style="text-align: center"><?php echo $clan['desc']; ?></p><?php endif; ?>
<br/>
<h2>Mensagens</h2>
<p>
    <table width="100%" cellpadding="3" cellspacing="2">
    <?php $menssages = clan_messages( $clan ); ?>
    <?php if ( $menssages ): ?>
        <tr>
            <th>Remetente</th>
            <th>Conteúdo</th>
        </tr>
        <?php foreach ( $menssages as $msg ): ?>
        <tr>
            <th>
                <a href="info_user.php?id=<?php echo $msg['user_id']; ?>"><?php echo $msg['from']; ?></a><br/>
                <?php echo date( 'd/m/Y - H:i:s', $msg['time'] ); ?>
            </th>
            <th><?php echo $msg['message']; ?></th>
        </tr>
        <tr>
            <th><a href="clan_message.php?opt=del&message_id=<?php echo $msg['id']; ?>">apagar</a></th>
        </tr>
        <tr>
            <td colspan="2"><hr style="color: #552222;"></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><th colspan="2">Sem mensagens</th></tr>
    <?php endif; ?>
    </table>
</p>
<?php if ( $clan['user_id'] == $user['id'] ): ?>
<h2>Nova mensagem (<span id="charcount" style="display: inline-block; margin-bottom: 0px;">2000</span> Carateres)</h2>
<p>
    <script language="JavaScript">
        function CheckLen( Target ) {
            var maxlength = 2000;
            StrLen = Target.value.length;
            if ( StrLen == 1 && Target.value.substring( 0, 1 ) == ' ' ) {
                Target.value = '';
                StrLen = 0;
            }
            if ( StrLen > maxlength ) {
                Target.value = Target.value.substring( 0, maxlength );
                CharsLeft = 0;
            } else {
                CharsLeft = maxlength - StrLen;
            }
            document.getElementById( 'charcount' ).innerHTML=CharsLeft;
        }
    </script>
    <table width="100%">
        <tr>
            <th colspan="2">
                <form action="clan_message.php?opt=add" method="post">
                    <textarea name="message" rows="6" cols="60" onkeydown="CheckLen(this)" onkeyup="CheckLen(this)" onfocus="CheckLen(this)" onchange="CheckLen(this)"></textarea>
                    <br/>
                    <input type="submit" value="inserir">
                </form>
            </th>
        </tr>
    </table>
</p>
<?php endif; ?>
<br/>
<?php
if ( $clan['user_id'] == $user['id'] ): ?>
<h2>Apagar o Clã</h2>
<p><a href="?clanleave">Apagar o Clã</a></p>
<?php else: ?>
<h2>Deixar o Clã</h2>
<p><a href="?clanleave">Deixar o Clã</a></p>
<?php endif;?>
</div>
<?php require 'include/tpl/footer.php'; ?>