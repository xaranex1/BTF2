<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */
require 'include/config.php';
require 'include/tpl/top.php';

$clan = clan_information_by_id( (int) $_GET['id'] );
if ( !$clan ) {
    echo "<script type=\"text/javascript\">window.location = 'clan_information.php'; </script>";
    exit;
}
?>
<div>
    <h2>Clã [<?php echo $clan['name'] ?>]</h2>
    <p>
        <table width="100%">
            <tr>
                <td rowspan="10" align="center">
                    <img src="http://s1.br.bitefight.org/img/logo/0/tmp/<?php echo $clan["logo"]; ?>.png" border=0>
                </td>
            </tr>
            <tr><td>Nome</th><th><?php echo $clan['name'] ?></th></tr>
            <tr>
                <td>Site
                <th><?php echo $clan['site'] ?></th>
            </tr>
            <tr>
                <td>Total Roubado</th>
                <th><?php echo $clan['total_prey']; ?></th>
            </tr>
            <tr>
                <td>Membros</th>
                <th><a href="info_clan_members.php?id=<?php echo $clan['id']; ?>" ><?php echo $clan['total_users']; ?></a></th>
            </tr>
            <tr>
                <td>Ouro
                <th><?php echo $clan['gold'] ?> <img src="img/res2.gif" alt="Ouro" align="absmiddle" border="0"></th>
            </tr>
            <tr>
                <td>Experiência
                <th><?php echo $clan['exp'] ?></th>
            </tr>
        </table>
    </p>
    <br/>
    <h2>Vista do esconderijo do Clã</h2>
    <p>
        <table width="100%">
            <tr style="background-image:url('img/clan/bg1.jpg'); background-repeat:no-repeat; background-position:center;" align="center">
                <th align="center"><img src="img/clan/stufe<?php echo $clan['castle'] ?>.gif" alt="�����" align="absmiddle" border="0"> </th>
            </tr>
            <tr>
                <th align="center">Nível do Castelo do Clã: <?php echo $clan['castle'] ?>
                </th>
            </tr>
        </table>
    </p>
    <br/>
    <h2>Descriçaõ do Clã</h2>
    <p style="text-align:center">
    <?php echo $clan['desc'] ?></p>
</div>
<?php require 'include/tpl/footer.php'; ?>