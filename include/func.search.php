<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

if ( !isset( $config ) )
    exit( 'Não é permitido o acesso direto aos scritps' );

/**
 * Procura um usuario pelo nome
 * 
 * @param   string  $user_name  Nome a ser procurado
 * @param   boolean $exact      Pesquisa exata
 * @return  array               Usuarios encontrados
 */
function search_user_by_name( $user_name, $exact ) {
    if ( $exact )
        db_query( "SELECT u.id, u.name, u.race, stat_prey, stat_win, stat_loss, c.id AS clan_id, c.name AS clan_name FROM user u LEFT JOIN clan_user cu ON cu.user_id=u.id LEFT JOIN clan c ON c.id=cu.clan_id WHERE u.name='?' LIMIT 25", $user_name );
    else
        db_query( "SELECT u.id, u.name, u.race, stat_prey, stat_win, stat_loss, c.id AS clan_id, c.name AS clan_name FROM user u LEFT JOIN clan_user cu ON cu.user_id=u.id LEFT JOIN clan c ON c.id=cu.clan_id WHERE u.name LIKE '%?%' LIMIT 25", $user_name );
    return db_fetch_all();
}

/**
 * Procura um clã pelo nome
 * 
 * @param   string  $clan_name  Nome a ser procurado
 * @param   boolean $exact      Pesquisa exata
 * @return  array               Clãs encontrados
 */
function search_clan_by_name( $clan_name, $exact ) {
    if ( $exact )
        db_query( "SELECT id, name, castle, (SELECT race FROM user WHERE id=c.user_id) AS race, (SELECT COUNT(*) FROM clan WHERE id=c.id) AS total_user, (SELECT SUM(stat_prey) FROM `user` u JOIN clan_user cu ON u.id=cu.user_id WHERE cu.clan_id=c.id) AS total_prey FROM clan c WHERE c.name='?' LIMIT 25", $clan_name );
    else
        db_query( "SELECT id, name, castle, (SELECT race FROM user WHERE id=c.user_id) AS race, (SELECT COUNT(*) FROM clan WHERE id=c.id) AS total_user, (SELECT SUM(stat_prey) FROM `user` u JOIN clan_user cu ON u.id=cu.user_id WHERE cu.clan_id=c.id) AS total_prey FROM clan c WHERE c.name LIKE '%?%' LIMIT 25", $clan_name );
    return db_fetch_all();
}

/**
 * Procura um clã pela TAG
 * 
 * @param   string  $tag_name   TAG a ser procurado
 * @param   boolean $exact      Pesquisa exata
 * @return  array               Clãs encontrados
 */
function search_clan_by_tag( $tag_name, $exact ) {
    if ( $exact )
        db_query( "SELECT id, name, tag, castle, (SELECT race FROM user WHERE id=c.user_id) AS race, (SELECT COUNT(*) FROM clan WHERE id=c.id) AS total_user, (SELECT SUM(stat_prey) FROM `user` u JOIN clan_user cu ON u.id=cu.user_id WHERE cu.clan_id=c.id) AS total_prey FROM clan c WHERE c.tag='?' LIMIT 25", $tag_name );
    else
        db_query( "SELECT id, name, tag, castle, (SELECT race FROM user WHERE id=c.user_id) AS race, (SELECT COUNT(*) FROM clan WHERE id=c.id) AS total_user, (SELECT SUM(stat_prey) FROM `user` u JOIN clan_user cu ON u.id=cu.user_id WHERE cu.clan_id=c.id) AS total_prey FROM clan c WHERE c.tag LIKE '%?%' LIMIT 25", $tag_name );
    return db_fetch_all();
}