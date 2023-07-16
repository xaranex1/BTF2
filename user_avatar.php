<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

require 'include/config.php';
require 'include/tpl/top.php';
$user2 = $_SESSION['id'];
$user = user_information( $_SESSION['id'] );
$mask = isset( $_GET['mask'] ) ? (int) $_GET['mask'] : 1;

// Verifica se o personagem ainda é um Lord das Sobras
if ( isset( $_POST['edit'] ) && $user['lord'] ) {
    $mask = (int) key( @$_POST['edit'] );
    $id = (int) key( @$_POST['edit'][$mask] );
    user_logo_save( $user, $mask, $id );
}

// Altera o sexo do personagem
if ( isset( $_GET['sex'] ) ) {
    $gender = $_GET['sex'] == 'm' ? 'm' : 'f';
    user_gender_change( $user, $gender );
}
?>
<div class="table-wrap">
    <h2>Editar a imagem do personagem</h2>
    <table width="100%" border="0">
        <tr>
            <th align="center"><img src="<?php echo user_logo( $user ); ?>" border="0" width="168" alt="playerlogo"></th>
			<tr>
  </center>
</tr>

            <th align="center">
        <table>
            <tr>
                <th align="left">
                    Sexo
                    <select size="1" onchange="location = this.options[this.selectedIndex].value;">
                        <option value="user_avatar.php?sex=m" <?php if ( $user['gender'] == 'm' ) echo 'selected'; ?>>Masculino
                        <option value="user_avatar.php?sex=f" <?php if ( $user['gender'] == 'f' ) echo 'selected'; ?>>Feminino
                    </select>
                </th>
            </tr>
            <tr><th align="left"><a href="user_avatar.php?mask=1">Corpo</a></th></tr>
            <tr><th align="left"><a href="user_avatar.php?mask=2">Cor de pele</a></th></tr>
            <tr><th align="left"><a href="user_avatar.php?mask=3">Olhos</a></th></tr>
            <tr><th align="left"><a href="user_avatar.php?mask=4">Bônus</a></th></tr>
            <tr><th align="left"><a href="user_avatar.php?mask=5">Cor de cabelo</a></th></tr>
            <tr><th align="left"><a href="user_avatar.php?mask=6">Cabelo</a></th></tr>
        </table>
        </th>
        </tr>
        <tr><th colspan="2">&nbsp;</th></tr>
        <tr>
            <th colspan="2" align="center">
        <form action="user_avatar.php"  method="POST">
            <?php if ( $mask == 2 ): ?>
                <table cellpadding="2" cellspacing="2" class="noBackground">
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_2_1.jpg" name="edit[2][1]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_2_2.jpg" name="edit[2][2]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_2_3.jpg" name="edit[2][3]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_2_4.jpg" name="edit[2][4]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_2_5.jpg" name="edit[2][5]" value="" width="60" height="60" border="0"></td>
                    </tr>
                </table>
            <?php elseif ( $mask == 3 ): ?>
                <table cellpadding="2" cellspacing="2" class="noBackground">
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_3_1.jpg" name="edit[3][1]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_3_2.jpg" name="edit[3][2]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_3_3.jpg" name="edit[3][3]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_3_4.jpg" name="edit[3][4]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_3_5.jpg" name="edit[3][5]" value="" width="60" height="60" border="0"></td>
                    </tr>
                </table>
            <?php elseif ( $mask == 4 ): ?>
                <table cellpadding="2" cellspacing="2" class="noBackground">
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_1.jpg" name="edit[4][1]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_2.jpg" name="edit[4][2]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_3.jpg" name="edit[4][3]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_4.jpg" name="edit[4][4]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_5.jpg" name="edit[4][5]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_6.jpg" name="edit[4][6]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_7.jpg" name="edit[4][7]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/<?php echo $user['race']; ?>/icons/<?php echo $user['gender']; ?>_4_8.jpg" name="edit[4][8]" value="" width="60" height="60" border="0"></td>
                    </tr>
                    <?php if ( $user['race'] == 1 ): ?>
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_9.jpg" name="edit[4][9]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_10.jpg" name="edit[4][10]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_11.jpg" name="edit[4][11]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_12.jpg" name="edit[4][12]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_13.jpg" name="edit[4][13]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_14.jpg" name="edit[4][14]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_15.jpg" name="edit[4][15]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_16.jpg" name="edit[4][16]" value="" width="60" height="60" border="0"></td>
                    </tr>
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_4_17.jpg" name="edit[4][17]" value="" width="60" height="60" border="0"></td>
                    </tr>
                    <?php endif; ?>
                </table>
            <?php elseif ( $mask == 5 ): ?>
                <table cellpadding="2" cellspacing="2" class="noBackground">
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_5_1.jpg" name="edit[5][1]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_5_2.jpg" name="edit[5][2]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_5_3.jpg" name="edit[5][3]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_5_4.jpg" name="edit[5][4]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_5_5.jpg" name="edit[5][5]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/x_5_6.jpg" name="edit[5][6]" value="" width="60" height="60" border="0"></td>
                    </tr>
                </table>
            <?php elseif ( $mask == 6 ): ?>
                <table cellpadding="2" cellspacing="2" class="noBackground">
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_6_1.jpg" name="edit[6][1]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_6_2.jpg" name="edit[6][2]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_6_3.jpg" name="edit[6][3]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_6_4.jpg" name="edit[6][4]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_6_5.jpg" name="edit[6][5]" value="" width="60" height="60" border="0"></td>
                    </tr>
                </table>
				
				<?php elseif ($mask == 7): ?>
  <table cellpadding="2" cellspacing="2" class="noBackground">
    <tr>
      <td>
        <form action="upload_logo.php" method="POST" enctype="multipart/form-data">
          <input type="file" name="custom_logo">
          <input type="submit" name="upload" value="Nahrát">
        </form>
      </td>
    </tr>
  </table>

            <?php else: ?>
                <table cellpadding="2" cellspacing="2" class="noBackground">
                    <tr>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_1_1.jpg" name="edit[1][1]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_1_2.jpg" name="edit[1][2]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_1_3.jpg" name="edit[1][3]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_1_4.jpg" name="edit[1][4]" value="" width="60" height="60" border="0"></td>
                        <td><input style="margin:5px;" type="image" src="img/logo/1/icons/<?php echo $user['gender']; ?>_1_5.jpg" name="edit[1][5]" value="" width="60" height="60" border="0"></td>
                    </tr>
                </table>
            <?php endif; ?>
        </form>
        </th>
        </tr>
    </table>
</div>



<form method="POST" enctype="multipart/form-data">
  <input type="file" name="avatar">
  <button type="submit">Upload Avatar</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  upload_avatar($user2); 
}
?>






<?php require 'include/tpl/footer.php'; ?>
