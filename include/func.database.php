<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */
error_reporting(E_ALL ^ E_DEPRECATED);
if ( !isset( $config ) )
    exit( 'Não é permitido o acesso direto aos scritps' );

/**
 * Variavel onde fica guardado as consultas 
 *
 * @author  ExtremsX
 * @since   1.1
 * @var     resource    $__db_query Variavel que guardará o resultado da consulta
 */
$__db_query = null;

/**
 * Cria uma conexão com o banco de dados
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   string  $server     Ip do servidor
 * @param   string  $database   Nome do banco de dados
 * @param   string  $username   Usuario do banco de dados
 * @param   string  $password   Senha do usuario
 */
function db_connect( $server, $database, $username, $password ) {
    mysql_connect( $server, $username, $password );
    mysql_select_db( $database );
    mysql_set_charset( 'utf8' );
}

/**
 * Realiza uma consulta ao banco de dados
 *
 * @author  ExtremsX
 * @since   1.1
 * @global  resource    $__db_query Variavel que guardará o resultado da consulta
 * @param   string      $sql        SQL para consulta
 * @return  resource                Retorna a resource da query caso seja necessario
 */
function db_query( $sql ) {
    global $__db_query;
    
    // Verifica se existe argumentos, caso contrario executa a query
    if ( strpos( $sql, '?' ) === FALSE)
        $__db_query = mysql_query( $sql );
    
    // Obtem os argumentos
    $args = func_get_args();
    unset( $args[0] );
    
    // Divide o SQL
    $seg = explode( '?', $sql );

    // Cria e executa a query
    $result = $seg[0];
    $i = 0;
    foreach ( $args as $arg ) {
        if ( $arg === null )
            $result .= 'NULL';
        else if ( is_numeric( $arg ) )
            $result .= (int) $arg;
        else 
            $result .= mysql_real_escape_string( $arg );
        
        if ( isset( $seg[$i + 1] ) )
            $result .= $seg[++$i];
    }
    
    $__db_query = mysql_query( $result );
    return $__db_query;
}

/**
 * Retorna um valor da consulta
 *
 * @author  ExtremsX
 * @since   1.1
 * @global  resource    $__db_query Variavel que guarda o resultado da consulta
 * @param   recource    $query      Variavel que guarda o resultado da consulta
 * @return  array                   Array com os resultados
 */
function db_fetch( $query = null ) {
    global $__db_query;
    if ( $query )
        return mysql_fetch_assoc( $query );
    else
        return mysql_fetch_assoc( $__db_query );
}

/**
 * Retorna uma array com todos os valores
 *
 * @author  ExtremsX
 * @since   1.1
 * @global  resource    $__db_query Variavel que guardará o resultado da consulta
 * @param   recource    $query      Variavel que guarda o resultado da consulta
 * @return  array                   Array com os resultados
 */
function db_fetch_all( $query = null ) {
    global $__db_query;
    $result = array();
    
    if ( $query )
        while( $row = mysql_fetch_assoc( $query ) )
            $result[] = $row;
    else
        while( $row = mysql_fetch_assoc( $__db_query ) )
            $result[] = $row;
    
    return $result;    
}

/**
 * Retorna o total de linha de uma consulta
 * 
 * @author  ExtremsX
 * @since   1.1
 * @global  resource    $__db_query Variavel que guardará o resultado da consulta
 * @param   recource    $query      Variavel que guarda o resultado da consulta
 * @return  int                     Total de linhas
 */
function db_num_rows( $query = null ) {
    global $__db_query;
    
    if ( $query )
        return mysql_num_rows( $query );
    else
        return mysql_num_rows( $__db_query );
}

/**
 * Retorna o ultimo ID inserido
 * 
 * @author  ExtremsX
 * @since   1.1
 * @global  resource    $__db_query Variavel que guardará o resultado da consulta
 * @param   recource    $query      Variavel que guarda o resultado da consulta
 * @return  int                     Ultimo ID inserido
 */
function db_insert_id( $query = null ) {
    global $__db_query;
    
    if ( $query )
        return mysql_insert_id( $query );
    else
        return mysql_insert_id();
}