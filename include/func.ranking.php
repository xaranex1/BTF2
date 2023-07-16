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
 * Retorna as estatisticas de cada raça
 * 
 * @return type
 */
function ranking_race_statistics() {
    $stats = array( 'vampire' => array(), 'werewolf' => array() );
    
    db_query( 'SELECT SUM(stat_prey) AS stat_prey, COUNT(*) AS total, SUM(gold) AS gold, SUM(stat_win) AS stat_win, SUM(stat_victim) AS stat_victim FROM user WHERE race=1' );
    $stats['vampire'] = db_fetch();
    
    db_query( 'SELECT SUM(stat_prey) AS stat_prey, COUNT(*) AS total, SUM(gold) AS gold, SUM(stat_win) AS stat_win, SUM(stat_victim) AS stat_victim FROM user WHERE race=2' );
    $stats['werewolf'] = db_fetch();
    
    return $stats;
}

/**
 * Retorna o ranking de experiencia
 * 
 * @param   type    $start  Offset de inicio
 * @return  array           Informações dos jogadores
 */
function ranking( $start ) {
    db_query( "SELECT * FROM user WHERE id>1 ORDER BY exp DESC LIMIT {$start},10" );
    return db_fetch_all();
}

/**
 * Retorna a quantidade total de jogadores
 * 
 * @return  int Total de jogadores
 */
function ranking_total_users() {
    db_query( 'SELECT COUNT(*) AS total FROM user' );
    $total = db_fetch();
    return $total['total'];
}