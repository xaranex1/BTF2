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

if ( $clan['user_id'] != $user['id'] ) {
    echo "<script type=\"text/javascript\">window.location = 'clan_information.php'; </script>";
    exit;
}

if ( @$_GET['opt'] == 'add' && isset( $_POST['message'] ) && !empty( $_POST['message'] ) && strlen( $_POST['message'] ) <= 2000 )
    clan_messages_create( $clan, $user, $_POST['message'] );

if ( @$_GET["opt"] == 'del' && isset( $_GET['message_id'] ) )
    clan_messages_delete( $clan, $_GET['message_id'] );

echo "<script type=\"text/javascript\">window.location = 'clan_information.php'; </script>";