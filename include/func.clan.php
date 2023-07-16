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
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array $user
 * @return  bool|array
 */
function clan_information( $user ) {
    db_query( 'SELECT c.*, u.stat, u.inv FROM clan c LEFT JOIN clan_user u ON c.id=u.clan_id WHERE u.user_id=?', $user['id'] );
    
    if ( db_num_rows() ) {
        $clan = db_fetch();
        
        db_query( 'SELECT SUM(u.stat_prey) AS total FROM user u LEFT JOIN clan_user k ON u.id=k.user_id WHERE k.clan_id=?', $clan['id'] );
        $stat_prey = db_fetch();
        $clan['total_prey'] = $stat_prey['total'];
        
        return $clan;
    }
    return false;
}

function clan_information_by_id( $clan_id ) {
    db_query( 'SELECT * FROM clan WHERE id=?', $clan_id );
    
    if ( db_num_rows() ) {
        $clan = db_fetch();
        
        db_query( 'SELECT SUM(u.stat_prey) AS total_prey, COUNT(cu.clan_id) AS total_users FROM user u LEFT JOIN clan_user cu ON u.id=cu.user_id WHERE cu.clan_id=?', $clan['id'] );
        $stat = db_fetch();
        $clan['total_prey'] = $stat['total_prey'];
        $clan['total_users'] = $stat['total_users'];
        
        return $clan;
    }
    return false;
}

/**
 * Retorna todos os membros de um clã
 * 
 * @param type $clan
 * @param type $start
 * @return type
 */
function clan_users( $clan, $start ) {
    db_query( 'SELECT u.id, u.name, u.race, u.exp, u.stat_prey, u.stat_victim, u.stat_win, u.stat_loss, u.stat_gold_p  FROM `user` u JOIN clan_user cu ON u.id=cu.user_id WHERE cu.clan_id=? LIMIT ?,25', $clan['id'], $start );
    return db_fetch_all();
}

/**
 * Retorna o total de usuario de uma guild
 * 
 * @param   array   $clan   Informações do clã
 * @return  int             Total de usuairo no clã
 */
function clan_users_total( $clan ) {
    db_query( 'SELECT COUNT(*) AS total FROM clan_user WHERE clan_id=?', $clan['id'] );
    $retorno = db_fetch();
    return $retorno['total'];
}

/**
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   type $user 
 */
function clan_user_ranking_position( $user ) {
    
}


/**
 * Faz uma doação para o clã
 * 
 * @author  ExtremsX
 * @since   1.0
 * @param   int    $c_id        ID do clã
 * @param   int    $u_id        ID do personagem
 * @param   int    $donation    Ouro a ser doado
 */
function clan_hideout_donation( &$clan, &$user, $donation ) {
    if ( $donation > 0 && $user["gold"] >= $donation  ) {
        db_query( "UPDATE user SET gold=gold-? WHERE id=?", $user['id'] );
        db_query( "UPDATE clan SET gold=gold+? WHERE id=?", $clan['id'] );
        $user['gold'] -= $donation;
        $clan['gold'] += $donation;
    }
}

/**
 * Calcula a quantidade maxima de membros baseando-se no nivel atual
 * 
 * @author  ExtremsX
 * @since   1.0
 * @param   int $lvl    Nivel atual
 * @return  int         Quantidade maxima
 */
function clan_hideout_max_memb( $lvl ) {
    return !$lvl ? 1 : $lvl * 3;
}

/**
 * Obtem o tatal de membros de um clã
 * 
 * @author  ExtremsX
 * @since   1.0
 * @param   int $c_id   ID do clã
 * @return  int         Total de membros
 */
function clan_hideout_total_memb( $clan ) {
    db_query( "SELECT COUNT(*) AS total FROM clan_user WHERE clan_id=?", $clan['id'] );
    $clan = db_fetch();
    return $clan['total'];
}

/**
 * Calcula o preço para atualização do esconderijo do clã
 *  
 * @author  ExtremsX
 * @since   1.0
 * @param type $lvl
 * @return int 
 */
function clan_hideout_update_cost( $clan ) {
    switch ( $clan["castle"] ) {
        case 0: return 3;
        case 1: return 296;
        case 2: return 4130;
        case 3: return 26796;
        case 4: return 114283;
        case 5: return 375818;
        case 6: return 1018158;
        case 7: return 2425286;
        case 8: return 5215001;
        case 9: return 10343751;
        case 10: return 19218989;
        case 11: return 33834222;
        case 12: return 56925897;
        case 13: return 92153181;
        case 14: return 144301645;
        case 15: return 219511858;
        case 16: return 325533800;
        case 17: return 472008025;
    }
}

/**
 * Evolui o esconderijo do clã
 * 
 * @author  ExtremsX
 * @since   1.0
 * @param   int    $c_id    ID do clã
 * @param   int    $u_id    ID do dono do clã
 */
function clan_hideout_update( &$clan, &$user ) {    
    if ( $clan['user_id'] == $user['id'] ) {
        $gold_need = clan_hideout_update_cost( $clan['castle'] );

        if ( $clan['gold'] >= $gold_need ) {
            db_query( 'UPDATE clan SET gold=gold-?, castle=castle+1 WHERE id=?', $gold_need, $clan['id'] );
            $clan['gold'] -= $gold_need;
            $clan['castle']++;
        }
    }
}

/**
 * Verifica se uma TAG já está sendo usada
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   string  $tag    TAG a ser verificada
 * @return  boolean
 */
function clan_tag_in_use( $tag ) {
    $tag = htmlentities( $tag, ENT_QUOTES );
    db_query( "SELECT * FROM clan WHERE tag='?'", $tag );
    return db_num_rows() ? true : false;
}

/**
 * Verifica se o nome do clã já está em uso
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   string  $name   Nome a ser verificada
 * @return  boolean
 */
function clan_name_in_use( $name ) {
    $name = htmlentities( $name, ENT_QUOTES );
    db_query( "SELECT * FROM clan WHERE name='?'", $name );
    return db_num_rows() ? true : false;
}

/**
 * Cria um clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   string  $tag    TAG do clã
 * @param   string  $name   Nome do clã
 */
function clan_create( $user, $tag, $name ) {
    db_query( "INSERT INTO clan (user_id, name, tag) VALUES (?, '?', '?')", $user['id'], $name, $tag );
    db_query( "INSERT INTO clan_user (clan_id, user_id) VALUES (?, ?)", db_insert_id(), $user['id'] );
}

/**
 * Retorna as mensagens do clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $clan   Informações do clã
 * @return  boolean
 */
function clan_messages( $clan ) {
    db_query( 'SELECT cm.*, u.name AS `from` FROM clan_message cm JOIN user u ON u.id=cm.user_id WHERE cm.clan_id=?', $clan['id'] );
    
    if ( db_num_rows() )
        return db_fetch_all();
    return false;
}

/**
 * Posta uma mensagem no mural do clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $clan       Informações do clã
 * @param   array   $user       Informações do usuario
 * @param   string  $message    Mensagem a ser postada
 */
function clan_messages_create( $clan, $user, $message ) {
    db_query( "INSERT INTO clan_message (clan_id, user_id, time, message) VALUES (?, ?, ?, '?')",
        $clan['id'],
        $user['id'],
        time(),
        htmlentities( $message, ENT_QUOTES )
    );
}

/**
 * Deleta uma mensagem do mural do clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $clan       Informações do clã
 * @param   int     $message_id ID da mensagem
 */
function clan_messages_delete( $clan, $message_id ) {
    db_query( 'DELETE FROM clan_message WHERE id=? AND clan_id=?', $message_id, $clan['id'] );
}

/**
 * Atualiza a descrição do Clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $clan           Informações do clã
 * @param   string  $description    Nova descrição do clã
 */
function clan_description( &$clan, $description ) {
    $description = htmlentities( $description, ENT_QUOTES );
    
    db_query( "UPDATE clan SET `desc`='?' WHERE id=?",
        $description,
        $clan['id']
    );
    
    $clan['desc'] = $description;
}

/**
 * Deixa um clã, caso seja o dono, deleta todas as informações do clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $clan   Informações do clã
 * @param   array   $user   Informações do usuario
 */
function clan_leave( $clan, $user ) {
    if ( $clan['user_id'] == $user['id'] ) {
        db_query( 'DELETE FROM clan_user WHERE clan_id=?', $clan['id'] );
        db_query( 'DELETE FROM clan_message WHERE clan_id=?', $clan['id'] );
        db_query( 'DELETE FROM clan_message WHERE clan_id=?', $clan['id'] );
        db_query( 'DELETE FROM clan WHERE id=?', $clan['id'] );
    } else {
        db_query( 'DELETE FROM clan_user WHERE user_id=?', $user['id'] );
    }
}

/**
 * Altera o logotipo do clã
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param array $clan
 * @param type $logo
 * @param type $type
 * @return type
 */
function clan_logo( &$clan, $logo, $type ) {
    $clan_logo = explode( '-', $clan['logo'] );
    
    if ( $type == 1 ) {
        if ( $logo < 1 || $logo > 10 ) // Fundo
            return;
        $clan_logo[0] = $logo;
    } else {
        if ( $logo < 1 || $logo > 24 ) // Simbulo
            return;
        $clan_logo[1] = $logo;
    }
    
    $clan_logo = implode( '-', $clan_logo );
    
    db_query( "UPDATE clan SET logo='?' WHERE id=?",
        $clan_logo,
        $clan['id']
    );
    
    $clan['logo'] = $clan_logo;
}

function clan_homepage( &$clan, $homepage ) {
    $homepage = htmlentities( $homepage, ENT_QUOTES );
    
    db_query( "UPDATE clan SET `site`='?' WHERE id=?",
        $homepage,
        $clan['id']
    );
    
    $clan['site'] = $homepage;
}

function clan_homepage_hit( $clan_id ) {
    db_query( 'SELECT * FROM clan WHERE id=?', $clan_id );
    if ( db_num_rows() ) {
        $info = db_fetch();
        db_query( 'UPDATE clan SET site_hits=site_hits+1 WHERE id=?', $clan_id );
        return $info['site'];
    } else {
        return false;
    }
}

function clan_tag( &$clan, $tag ) {
    $tag = htmlentities( $tag, ENT_QUOTES );
    db_query( "UPDATE clan SET tag='?' WHERE id=?", $tag, $clan['id'] );
    $clan['tag'] = $tag;
}

function clan_name( &$clan, $name ) {
    $name = htmlentities( $name, ENT_QUOTES );
    db_query( "UPDATE clan SET `name`='?' WHERE id=?", $name, $clan['id'] );
    $clan['name'] = $name;
}