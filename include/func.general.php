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
 * Obtem as informações de um item retornando falso caso não exista
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   int         $item_id    ID do item 
 * @return  bool|array              false|Informações do item
 */
function item_information( $item_id ) {
    db_query( "SELECT * FROM item WHERE id=?", $item_id );
    if ( db_num_rows() )
        return db_fetch();
    return false;
}

/**
 * Formata o numero para sair como 1.000.000
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   int     $int    Numero a ser formatado
 * @return  string          Numero formatado
 */ 
function pretty_number( $int ) {
    return number_format( $int, 0, '', '.' );
}

/**
 * Rretorna o tempo restando em dias, horas, minutos ou segundos
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   int     $int    Tempo em segundos restantes
 * @return  string
 */
function pretty_timer_regressive( $time ) {
    if ( $time > 86400 ) // 1 dia
        return "Ativo ainda por " . date( 'j', $time - 86400) . " dia(s)";
    else if ( $time > 3600 ) // 1 hora
        return "Ativo ainda por " . date( 'G', $time - 3600 ) . " hora(s) e " . date( 'i', $time ) . " minuto(s)";
    else if ( $time > 60 ) // 1 minuto
        return "Ativo ainda por " . date( 'i', $time - 60 ) . " minuto(s) e " . date( 's', $time ) . " segundo(s)";
    else // segundos
        return "Ativo ainda por " . date( 's', $time ) . " segundo(s)";
}

/**
 * Cria a barra de habilidade
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   int     $min    Menor valor
 * @param   int     $max    Maior valor
 * @return  string          HTML da barra
 */
function bar_skill( $min, $max ) {
    $bar_red = ( $min * 200 ) / $max;
    if ( $bar_red < 200 ) {
        $bar_gray = 200 - $bar_red;
        return '<img src="img/b2.gif" alt="" width="' . $bar_red . '" height="12"><img src="img/b4.gif" alt="" width="' . $bar_gray . '" height="12"><img src="img/b5.gif" alt="">';
    } else {
        return '<img src="img/b2.gif" alt="" width="' . $bar_red . '" height="12"><img src="img/b3.gif" alt="">';
    }
}

/**
 * Verifica se a url existe
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   string  $url    URL a ser verificada
 * @return boolean 
 */
function url_exists( $url ) {
    $headers = @get_headers( $url );
    if ( preg_match( "|200|", $headers[0] ) )
        return true;
    return false;
}

/**
 * Obtem os itens de um determinado modelo a venda no mercado 
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   int     $model ID do modelo
 * @return  array
 */
function market_items( $model = 7 ) {
    db_query( 'SELECT i.*, m.id AS m_id, m.cost FROM item i RIGHT JOIN market m ON i.id=m.item_id WHERE i.model=?', $model );
    return db_fetch_all();
}

/**
 * Obtem as informações de um item na mercado
 * 
 * @param   int     $item_id    ID do item
 * @return  array               Informações do item
 */
function market_item_information( $item_id ) {
    db_query( 'SELECT i.*, m.id AS m_id, m.cost, m.user_id FROM item i LEFT JOIN market m ON i.id=m.item_id WHERE m.id=?', $item_id );
    return db_num_rows() ? db_fetch() : false;
}

/**
 * Obtem um relatorio de luta
 * 
 * @param   int     $fight_id   ID do relatorio
 * @return  array               Informações do relatorio
 */
function fight_report( $fight_id ) {
    db_query( 'SELECT * FROM user_fight WHERE id=?', $fight_id );
    return db_num_rows() ? db_fetch() : false;
}