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
 * Pega as informações do usuario a partir de seu ID
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   int         $user_id    ID do usuario
 * @return  bool|array              retorna falso caso não encontre o usuario
 */
function user_information( $user_id ) {
    // Verifica se o usuario existe
    db_query( "SELECT * FROM user WHERE id=?", $user_id );
    if ( !db_num_rows() )
        return false;
    
    // Obtem as informações do usuario
    $user = db_fetch();
    
    // Atualiza os timers
    user_time_update ( $user );
    
    $user['level'] = user_calculate_level( $user['exp'] );
    $user['exp_need'] = user_experience_necessary( $user['level'] );
    $user['exp_now'] = $user['exp'] - user_total_experience_necessary( $user['level'] );
    $user['hp_max'] = user_calculate_vitality( $user['level'] );
    
    $items = user_items( $user );
    $user['ab_s_dam'] = 0;
    $user['ab_s_block'] = 0;
    $user['ab_s_double'] = 0;
    $user['ab_s_chance_kick'] = 0;
    $user['ab_s_chance_blow'] = 0;
    foreach( $items as $item ) {
        $user['ab_pow'] += $item['pow'];
        $user['ab_def'] += $item['def'];
        $user['ab_agi'] += $item['agi'];
        $user['ab_chr'] += $item['chr'];
        $user['ab_stam'] += $item['stam'];
        $user['ab_s_dam'] += $item['s_dam'];
        $user['ab_s_block'] += $item['s_block'];
        $user['ab_s_double'] += $item['s_double'];
        $user['ab_s_chance_kick'] += $item['s_chance_kick'];
        $user['ab_s_chance_blow'] += $item['s_chance_blow'];
    }
    
    return $user;
}

/**
 * Pegas as informações de um usuario apartir de seu nome
 *
 * @author  ExtremsX
 * @since   1.1
 * @param type $name
 * @return boolean 
 */
function user_information_by_name( $name ) {
    $query = db_query( "SELECT id FROM user WHERE name='?'", $name );
    if ( !db_num_rows( $query ) )
        return false;
    
    $user = db_fetch();
    if ( $user['id'] > 1 )
        return user_information( $user['id'] );
    return false;
}

/**
 * Pega as informações de um usuario a partir de seu email
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   string  $email  E-mail do usuario
 * @return  boolean 
 */
function user_information_by_email( $email ) {
    db_query( "SELECT id FROM user WHERE email='?'", $email );
    if ( !db_num_rows() )
        return false;
    
    $user = db_fetch();
    return user_information( $user['id'] );
}

/**
 * Evolui um personagem depois de se obter as informações dele
 *
 * @param   array   $user   Informações do usuario
 */
function user_level_up( &$user ) {
    // Atualiza o nivel do personagem
    $user['level'] = user_calculate_level( $user['exp'] );
    
    // Envia uma mensagem
    $user_from = array( 'id' => 1 );
    $subject = 'Subiste de nível';
    $message = "Parabéns! Ganhou experiência suficiente para atingir o nível seguinte. O seu novo nível é: {$user_to['level']}";
    user_messages_send( $user_from, $user, $subject, $message );
}

/**
 * Cria uma nova conta com os dados passados
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   string  $name   Nome do usuario
 * @param   string  $pass           Senha do usuario
 * @param   string  $email      E-mail do usuario
 * @param   int     $race       ID da raça do usuario
 * @param   int     $referrer   ID do jogador que indicou   
 */
function user_register( $name, $pass, $email, $race, $referrer = null ) {
    $name = htmlentities( $name, ENT_QUOTES );
    $pass = md5( sha1( $pass ) );
    db_query( "INSERT INTO user (name, pass, email, race) VALUES ('?', '?', '?', '?')",
        $name,
        $pass,
        $email,
        $race
    );
    
    $referrer = user_information( $referrer );
    if ( $referrer )
        db_query( 'UPDATE user SET stat_victim=? WHERE id=?', ++$referrer['stat_victim'], $referrer['id'] );
}

/**
 * Realiza o login do usuario, criando uma sessão caso obtenha sucesso
 *
 * @author  ExtremsX
 * @since   1.1
 * @global  array   $_SESSION   Variavel de sessão
 * @param   string  $user       Nome do usuario
 * @param   string  $pass       Senha do usuario
 * @return  boolean
 */
function user_login( $user, $pass ) {
    global $_SESSION;
    $user = htmlentities( $user, ENT_QUOTES );
    $pass = md5( sha1( $pass ) );
    db_query( "SELECT id FROM user WHERE name='?' AND pass='?'", $user, $pass );
    if ( db_num_rows() ) {
        $user = db_fetch();
        $_SESSION['id'] = $user['id'];
        return true;
    } else {
        return false;
    }
}

/**
 * Retorna todos os itens de um usuario
 * 
 * @param   array   $user   Informações sobre o usuario
 * @return  array           Informações sobre os itens
 */
function user_items( $user ) {
    db_query( 'SELECT ui.id AS item_id, ui.stat, ui.vol, i.*  FROM item i JOIN user_item ui ON i.id=ui.item_id WHERE ui.user_id=?', $user['id'] );
    return db_fetch_all();
}


/**
 * Compra um item
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user       Informações do usuario
 * @param   int     $item_id    ID do item
 * @return  string              Mensagem de retorno
 */
function user_item_buy( &$user, $item_id ) {
    $item = item_information( $item_id );
    
    // Verifica se o item existe
    if ( $item ) {
        // Verifica se ele possui os requisitos
        if ( $user['gold'] >= $item['cost_gold'] && $user['ignicit'] >= $item['cost_ignicit'] && user_calculate_level( $user['exp'] ) >= $item['lvl'] ) {
            db_query( "SELECT * FROM user_item WHERE item_id=? AND user_id=?", $item['id'], $user['id'] );
            
            // Adiciona o item
            if ( !db_num_rows() )
                db_query( "INSERT INTO user_item (user_id, item_id) VALUES (?, ?)", $user['id'], $item['id'] );
            else
                db_query( "UPDATE user_item SET vol=vol+1 WHERE user_id=? AND item_id=?", $user['id'], $item['id'] );
            
            // Atualiza o personagem
            db_query( "UPDATE user SET gold=gold-?, ignicit=ignicit-? WHERE id=?", $item['cost_gold'], $item['cost_ignicit'], $user['id'] );
            $user['gold'] -= $item['cost_gold'];
            $user['ignicit'] -= $item['cost_ignicit'];
            $msg = "O item foi comprado com sucesso.";
        } else {
            $msg = "Você não tem dinheiro, ouro e/ou pedras do Inferno suficiente.";
        }
    } else {
        $msg = "O item não existe";
    }
    
    return "<div class=\"ainfo4\"><b>{$msg}</b></div><br><br>";
}

/**
 * Usa um item
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user       Informações do usuario
 * @param   int     $item_id    ID do item
 */
function user_item_use( &$user, $item_id ) {
    db_query( "SELECT vol FROM user_item WHERE user_id=", $user['id'] );
    $user_item = db_fetch();

    if ( $user_item["vol"] == 1 )
        db_query( "DELETE FROM user_item WHERE id=? AND user_id=?", $item_id, $user['id'] );
    else
        db_query( "UPDATE user_item SET vol=vol-1 WHERE id=? AND user_id=?", $item_id, $user['id'] );
}

/**
 * Equipa um item
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user       Informações do usuario
 * @param   int     $item_id    ID do item
 */
function user_item_equip( $user, $item_id ) {
    db_query( "UPDATE user_item SET stat=1 WHERE id=? AND user_id=?", $item_id, $user['id'] );
}

/**
 * Desequipa um item
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user       Informações do usuario
 * @param   int     $item_id    ID do item
 */
function user_item_unequip( $user, $item_id ) {
    db_query( "UPDATE user_item SET stat=0 WHERE id=? AND user_id=?", $item_id, $user['id'] );
}

/**
 * Retorna todas as mensagens de um usuario
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   string  $box    Tipo de caixa
 * @return  array           Todas as menssagens
 */
function user_messages( $user, $box ) {
    // Atualiza as mensagens como lidas
    db_query( 'UPDATE `user_mail` SET `read`=1 WHERE `id`=?', $user['id'] );
    
    if ( $box == 'in')
        db_query( 'SELECT u.id AS user_id, u.name, um.* FROM user_mail um LEFT JOIN `user` u ON u.id=um.from_id WHERE um.to_id=? ORDER BY um.id DESC LIMIT 20', $user['id'] );
    else
        db_query( 'SELECT u.id AS user_id, u.name, um.* FROM user_mail um LEFT JOIN `user` u ON u.id=um.from_id WHERE um.from_id=? ORDER BY um.id DESC LIMIT 20', $user['id'] );
    
    return db_fetch_all();
}

/**
 * Envia uma mensagem
 * 
 * @author  ExtremsX
 * @since   1.0
 * @param   array   $user_from  Informações do usuario remetende
 * @param   array   $user_to    Informações do usuario destinatario
 * @param   string  $subject    Assunto da mensagem
 * @param   string  $message    Corpo da mensagem
 * @param   boolean $xss        Aplicar filtro contro XSS
 */
function user_messages_send( $user_from, $user_to, $subject, $message, $xss = true ) {
    global $config;
    
    if ( $xss ) {
        $subject = htmlspecialchars( $subject, ENT_QUOTES );
        $message = htmlspecialchars( $message, ENT_QUOTES );
    }
    
    if ( $user_from === null ) {
        $user = user_information( $user_to['id'] );
        if ( $user['lord'] && user_messages_total( $user ) >= $config['game']['mail']['lord'] )
            user_messages_delete( $user, 'old' );
        else if ( user_messages_total( $user ) >= $config['game']['mail']['normal'] )
            user_messages_delete( $user, 'old' );
            
        db_query( "INSERT INTO user_mail (from_id, to_id, subj, msg) VALUES (?, ?, '?', '?')",
            $user_from['id'],
            $user_to['id'],
            $subject,
            $message
        );
    }
}

/**
 * Deleta todas as mensagens ou apenas as selecionadas
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   array   $user       Informações do usuario
 * @param   string  $action     Ação a ser realizada
 * @param   mixed   $messages   ID das mensagens
 */
function user_messages_delete( $user, $action, $messages = null ) {
    if ( is_array( $messages ) )
        $messages = implode( ',', $messages );
    
    if ( $action == 'all' )
        db_query( 'DELETE FROM user_mail WHERE to_id=?', $user['id'] );
    if ( $action == 'old' )
        db_query( 'DELETE FROM user_mail WHERE to_id=? ORDER BY date ASC LIMIT 1', $user['id'] );
    else if ( $action == 'selected' )
        db_query( 'DELETE FROM user_mail WHERE to_id=? AND id IN (?)', $user['id'], $messages );
    else if ( $action == 'unselected' )
        db_query( 'DELETE FROM user_mail WHERE to_id=? AND id NOT IN (?)', $user['id'], $messages );
}

/**
 * Verifica quantas mensagens um personagem possui
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   array   $user   Informações do usuario 
 * @return  int             Total de mensagens
 */
function user_messages_total( $user ) {
    db_query( "SELECT COUNT(*) AS total FROM user_mail WHERE to_id=?", $user['id'] );
    if ( db_num_rows() ) {
        $total = db_fetch();
        return $total['total'];
    }
    return 0;    
}

/**
 * Verifica quantas mensagens não lidas um personagem possui
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   array   $user   Informações do usuario 
 * @return  int             Total de mensagens
 */
function user_messages_total_unread( $user ) {
    db_query( "SELECT COUNT(*) AS total FROM user_mail WHERE to_id=? AND `read`=0", $user['id'] );
    if ( db_num_rows() ) {
        $total = db_fetch();
        return $total['total'];
    }
    return 0;    
}

/**
 * Cria a url da imagem do personagem
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   int|array   $u  ID do usuario|Array com as informações do usuario
 * @return  string          URL da imagem do persoagem
 */
function user_logo( $u ) {
    global $config;
    
    if ( is_numeric( $u ) )
        $u = user_information( $u );
    
    // {SEXO}-{CORPO}-{COR|PELE}-{OLHOS}-{BONUS}-{COR|CABELO}-{CABELO}-{BONUS2}
    if ( !$u['logo_body'] )         $u['logo_body'] = 2;
    if ( !$u['logo_body_color'] )   $u['logo_body_color'] = 2;
    if ( !$u['logo_eye'] )          $u['logo_eye'] = 5;
    if ( !$u['logo_bonus'] )        $u['logo_bonus'] = 10;
    if ( !$u['logo_hair_color'] )   $u['logo_hair_color'] = 4;
    if ( !$u['logo_hair'] )         $u['logo_hair'] = 4;
    if ( !$u['logo_bonus2'] )       $u['logo_bonus2'] = 0;
    
    if ( is_array( $config['url']['character'] ) ) {
        foreach( $config['url']['character'] as $url ) {
            $logo_url = "{$url}/{$u['race']}/tmp/{$u['gender']}-{$u['logo_body']}-{$u['logo_body_color']}-{$u['logo_eye']}-{$u['logo_bonus']}-{$u['logo_hair_color']}-{$u['logo_hair']}-{$u['logo_bonus2']}.png";
            if ( url_exists( $logo_url ) )
                return $logo_url;
        }
    }
    return "img/logo/{$u['race']}/{$u['gender']}-{$u['logo_body']}-{$u['logo_body_color']}-{$u['logo_eye']}-{$u['logo_bonus']}-{$u['logo_hair_color']}-{$u['logo_hair']}-{$u['logo_bonus2']}.png";

}

/**
 * Salva no banco de dados as alterações a respeito da aparencia do usuario
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   int     $u_id   Informacoes do usuario
 * @param   int     $mask   ID do tipo
 * @param   int     $id     Novo ID do tipo
 * @return  null 
 */
function user_logo_save( &$user, $mask, $id ) {
    switch ( $mask ) {
        case 1:  // rosto
            if ( $id < 1 || $id > 5 ) return;
            db_query( "UPDATE user SET logo_body=? WHERE id=?", $id, $user['id'] );
            $user['logo_body'] = $id;
            break;
        case 2:  // cor da pele
            if ( $id < 1 || $id > 5 ) return;
            db_query( "UPDATE user SET logo_body_color=? WHERE id=?", $id, $user['id'] );
            $user['logo_body_color'] = $id;
            break;
        case 3:  // olho
            if ( $id < 1 || $id > 5 ) return;
            db_query( "UPDATE user SET logo_eye=? WHERE id=?", $id, $user['id'] );
            $user['logo_eye'] = $id;
            break;
        case 4:  // bonus
            if ( $id < 1 || $id > 17 ) return;
            db_query( "UPDATE user SET logo_bonus=? WHERE id=?", $id, $user['id'] );
            $user['logo_bonus'] = $id;
            break;
        case 5:  // cor do cabelo
            if ( $id < 1 || $id > 6 ) return;
            db_query( "UPDATE user SET logo_hair_color=? WHERE id=?", $id, $user['id'] );
            $user['logo_hair_color'] = $id;
            break;
        case 6:  // cabelo
            if ( $id < 1 || $id > 5 ) return;
            db_query( "UPDATE user SET logo_hair=? WHERE id=?", $id, $user['id'] );
            $user['logo_hair'] = $id;
            break;
    }
}

function user_gender_change( &$user, $gender ) {
    db_query( "UPDATE user SET gender='?' WHERE id=?", $gender, $user['id'] );
    $user['gender'] = $gender;
}

/**
 * Calcula a quantidade maxima de vida do personagem baseado no nivel atual
 *
 * @author  ExtremsX
 * @since   1.0
 * @see     http://board.bitefight.com.pt/board223-arquivos/board225-arquivo-o-jogo/13516-f%C3%B3rmulas-conhecidas/
 * @param   int $lvl    Nivel do personagem
 * @return  int         Vida maxima do personagem
 */
function user_calculate_vitality( $lvl ) {
    $lvl--;
    return 100 + ( $lvl * 5 + round( $lvl / 4 ) );
}

/**
 * Calcula a quantidade experiencia necessaria para evoluir para o proximo nivel
 * baseado no nivel atual
 *
 * @author  ExtremsX
 * @since   1.0
 * @see     http://board.bitefight.com.pt/board223-arquivos/board225-arquivo-o-jogo/13516-f%C3%B3rmulas-conhecidas/
 * @param   int $lvl    Nivel do personagem
 * @return  int         Experiencia necessaria
 */
function user_experience_necessary( $lvl ) {
    return ( 2 * $lvl - 1 ) * 5;
}

/**
 * Retorna a soma de toda experiencia necessaria apartir do nivel 1 basenado-se
 * no nivel atual
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   int $lvl    Nivel do personagem
 * @return  int         Experiencia necessaria
 */
function user_total_experience_necessary( $lvl ) {
    return pow( --$lvl, 2 ) * 5;
}

/**
 * Calcula o nivel do personagem baseado na quantidade atual de experiencia
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   int $exp    Experiencia do personagem
 * @return  int         Nivel do personagem
 */
function user_calculate_level( $exp ) {
    return floor( sqrt( $exp / 5 ) ) + 1;
}

/**
 * Calcula o preço necessario para evoluir uma abilidade
 *
 * @author  ExtremsX
 * @since   1.0
 * @see     http://board.bite-fight.us/board263-bitefight-community/board32-guides-faqs/board427-advanced-help/31556-formulas-new-battle-system/
 * @see     http://board.bitefight.org/board422-bitefight/board433-general-discussions/45258-formulas-and-other-useful-info/
 * @param   int $stat   Nivel atual
 * @return  int         Preço para o proximo nivel
 */
function user_training_cost( $stat, $type ) {
    // Formula velha
    if ( $type == 'pow' )
        $pow = 2.6;
    else if ( $type == 'def' || $type == 'chr' ) 
        $pow = 2.5;
    else if ( $type == 'agi' || $type == 'stam' ) 
        $pow = 2.3;
    
    return floor( pow( $stat - 4, $pow ) );
    
    // Formula nova
    //return floor( pow( $stat - 4, 2.4 ) );
}

/**
 * Calcula o valor do preço para atualização da casa, muro, estrada e fundo
 *
 * @author  ExtremsX
 * @since   1.0
 * @see     http://board.bite-fight.us/board263-bitefight-community/board32-guides-faqs/board426-goods-and-hideout/31345-hideout/
 * @param   int     $stat   Nivel atual
 * @param   string  $type   Tipo a ser atualizado
 * @return  int             Preço para o proximo nivel
 */
function user_hideout_update_cost( $stat, $type ) {
    $stat++;
    switch ( $type ) {
        case 'house': return pow( 4, $stat );
        case 'fence': return pow( 10, $stat );
        case 'road': return pow( 9, $stat );
        case 'nbh': return pow( 8, $stat );
    }
}

/**
 * Autualiza uma parte do esconderijo do personagem
 *
 * @author  ExtremsX
 * @since   1.0
 * @param   array   $user   Informações do usuario
 * @param   string  $update Tipo de update
 */
function user_hideout_update( &$user, $update ) {
    $house_cost = user_hideout_update_cost( $user['pl_house'], 'house' );
    $fence_cost = user_hideout_update_cost( $user['pl_fence'], 'fence' );
    $road_cost  = user_hideout_update_cost( $user['pl_road'] , 'road' );
    $nbh_cost   = user_hideout_update_cost( $user['pl_nbh']  , 'nbh' );
    
    if ( $update == 1 && $user['pl_house'] < 11 && $user['gold'] >= $house_cost ) {
        db_query( 'UPDATE user SET pl_house=pl_house+1, gold=gold-? WHERE id=?', $house_cost, $user['id'] );
        $user['gold'] -= $house_cost;
        $user['pl_house']++;
    } else if ( $update == 2 && $user['pl_fence'] < 6 && $user['gold'] >= $fence_cost && $user['pl_house'] > $user['pl_fence'] ) {
        db_query( 'UPDATE user SET pl_fence=pl_fence+1, gold=gold-? WHERE id=?', $fence_cost, $user['id'] );
        $user['gold'] -= $fence_cost;
        $user['pl_fence']++;
    } else if ( $update == 3 && $user['pl_road'] < 6 && $user['gold'] >= $road_cost && $user['pl_house'] > $user['pl_road'] ) {
        db_query( 'UPDATE user SET pl_road=pl_road+1, gold=gold-? WHERE id=?', $road_cost, $user['id'] );
        $user['gold'] -= $road_cost;
        $user['pl_road']++;
    } else if ( $update == 4 && $user['pl_nbh'] < 6 && $user['gold'] >= $nbh_cost && $user['pl_house'] > $user['pl_nbh'] ) {
        db_query( 'UPDATE user SET pl_nbh=pl_nbh+1, gold=gold-? WHERE id=?', $nbh_cost, $user['id'] );
        $user['gold'] -= $nbh_cost;
        $user['pl_nbh']++;
    } else if ( $update == 5 && $user['ignicit'] >= 20 && !$user['pl_chest_t'] ) {
        $time = time() + 2419200; // 4 semandas
        db_query( 'UPDATE user SET pl_chest_t=?, ignicit=ignicit-20 WHERE id=?', $time, $user['id'] );
        $user['ignicit'] -= 20;
        $user['pl_chest_t'] = $time;
    } else if ( $update == 6 && $user['ignicit'] >= 20 && !$user['pl_grg_t'] ) {
        $time = time() + 2419200; // 4 semandas
        db_query( 'UPDATE user SET pl_grg_t=?, ignicit=ignicit-20 WHERE id=?', $time, $user['id'] );
        $user['ignicit'] -= 20;
        $user['pl_grg_t'] = $time;
    } else if ( $update == 7 && $user['ignicit'] >= 20 && !$user['pl_book_t'] ) {
        $time = time() + 2419200; // 4 semandas
        db_query( 'UPDATE user SET pl_book_t=?, ignicit=ignicit-20 WHERE id=?', $time, $user['id'] );
        $user['ignicit'] -= 20;
        $user['pl_book_t'] = $time;
    }
}

/**
 * Calcula a capacidade de armazenamento
 *
 * @author  ExtremsX
 * @since   1.0
 * @see     http://board.bite-fight.us/board263-bitefight-community/board32-guides-faqs/board426-goods-and-hideout/31345-hideout/#post238805
 * @param   int $stat   Nivel atual
 * @return  int         Capacidade de armazenamento
 */
function user_hideout_chest_capacity( $user ) {
    return user_calculate_level( $user['exp'] ) * 1200;
}

/**
 * Compra um item do mercado
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Imformações do usuario
 * @param   type    $item   Informações do Items
 */
function user_market_item_buy( &$user, $item ) {    
    db_query( 'SELECT * FROM user_item WHERE user_id=? AND item_id=?', $user['id'], $item['id'] );

    // Comprador
    if ( !db_num_rows() )
        db_query( 'INSERT INTO user_item (user_id, item_id) VALUES (?, ?)', $user['id'], $item['id'] );
    else
        db_query( 'UPDATE user_item SET vol=vol+1 WHERE user_id=? AND item_id=?', $user['id'], $item['id'] );
    db_query( 'UPDATE user SET gold=gold-? WHERE id=?', $item['cost'], $user['id'] ); 
    $user['gold'] -= $item['cost'];
    
    // Vendedor
    db_query( 'UPDATE user SET gold=gold+? WHERE id=?', $item['cost'], $item['user_id'] );    
    
    // Mercador
    db_query( 'DELETE FROM market WHERE id=?', $item['m_id'] );
}

/**
 * Altera o nome do usuario
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   type    $user   Informações do usuario
 * @param   type    $name   Novo nome
 * @param   type    $method Metodo de alteração
 */
function user_change_name( &$user, $name, $method = 1 ) {
    $name = htmlentities( $name, ENT_QUOTES );
    if ( $method == 1 ) {
        $price = ceil( $user['stat_prey'] * 0.1 );
        $user['gold'] -= $price;
        db_query( "UPDATE user SET name='?', gold=gold-? WHERE id=?", $name, $price, $user['id'] );
    } else {
        $user['ignicit'] -= 10;
        db_query( "UPDATE user SET name='?', ignicit=ignicit-10 WHERE id=?", $name, $user['id'] );        
    }
    $user['name'] = $name;
}

/**
 * Treina as habilidades do usuario
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   int     $type   Habilidade a ser treinada
 * @param   int     $cost   Custo para o treieno
 */
function user_training( &$user, $type, &$cost ) {
    $new_cost = 0;
    switch ( $type ) {
        case 1:
            $field = 'ab_pow';
            $new_cost = user_training_cost( $user['ab_pow'] + 1, 'pow' );
            break;
        case 2:
            $field = 'ab_def';
            $new_cost = user_training_cost( $user['ab_def'] + 1, 'def' );
            break;
        case 3:
            $field = 'ab_agi';

            $new_cost = user_training_cost( $user['ab_agi'] + 1, 'agi' );
            break;
        case 4:
            $field = 'ab_stam';
            $new_cost = user_training_cost( $user['ab_stam'] + 1, 'stam' );
            break;
        case 5:
            $field = 'ab_chr';
            $new_cost = user_training_cost( $user['ab_chr'] + 1, 'chr' );
            break;
    }
    
    if ( isset( $field ) ) {
        db_query( "UPDATE user SET {$field}={$field}+1, gold=gold-? WHERE id=?", $cost, $user['id'] );
        $user[$field]++;
        $user['gold'] -= $cost;
        $cost = $new_cost;
    }
}

/**
 * Obtem a lsita de amigos do usuario
 * 
 * @param   array   $user   Informações do usuario
 * @return  array           ID e nome dos amigos
 */
function user_friends( $user ) {
    db_query( 'SELECT u.id, u.name FROM user u JOIN user_friend uf ON u.id=uf.friend_id WHERE uf.user_id=?', $user['id'] );
    return db_fetch_all();
}

/**
 * Verifica se o usuario é amigo de outro usuario
 * 
 * @param   array   $user   Informações do usuario
 * @param   array   $user   Informações do amigo
 * @return  bool
 */
function user_friend_already( $user, $friend ) {
    db_query( 'SELECT * FROM user_friend WHERE user_id=? AND friend_id=?', $user['id'], $friend['id'] );
    return db_num_rows() ? true : false;
}

/**
 * Adiciona um amigo a lista de amigos
 * 
 * @param   array   $user   Informações do usuario
 * @param   array   $user   Informações do amigo
 */
function user_friend_add( $user, $friend ) {
    db_query( 'INSERT INTO user_friend VALUES (?, ?)', $user['id'], $friend['id'] );
}

/**
 * Remove um amigo da lista de amigos
 * 
 * @param   array   $user   Informações do usuario
 * @param   array   $user   Informações do amigo
 */
function user_friend_delete( $user, $friend ) {
    db_query( 'DELETE FROM user_friend WHERE user_id=? AND friend_id=?', $user['id'], $friend['id'] );
}

/**
 * Atualiza o bloco de notas
 * 
 * @param   array   $user   Informações do usuario
 * @param   string  $note   Texto a ser salvo
 */
function user_update_note( &$user, $note ) {
    $user['note'] = htmlspecialchars( $note, ENT_QUOTES );
    db_query( "UPDATE user SET note='?' WHERE id=?", $user['note'], $user['id'] );
}

/**
 * Atualiza as cnfigurações do usuario
 * 
 * @param   array   $user           Informações do usuario
 * @param   string  $email          Novo email a ser salvo
 * @param   string  $description    Nova descrição a ser salva
 * @param   string  $catch          Nova mensagem a ser salva
 */
function user_update_settings( &$user, $email, $description, $catch ) {
    $user['email'] = $email;
    $user['desc'] = htmlspecialchars( $description, ENT_QUOTES );
    $user['catch'] = htmlspecialchars( $catch, ENT_QUOTES );
    db_query( "UPDATE user SET email='?', desc='?', catch='?' WHERE id=?", $user['email'], $user['desc'], $user['catch'], $user['id'] );
}

/**
 * Obtem um usuario randomicamente para ser atacado
 * 
 * @param   array       $user   Informações do usuario
 * @param   int         $opt    Tipo de procura, 1 = normal e 2 = mais fortes
 * @return  array|bool          Informações do usuario
 */
function user_random_defender( $user, $opt ) {
    global $config;
    
    if ( $opt == 1 ) {
        db_query( 'SELECT id FROM `user` WHERE id!=? AND hp_now>=? AND race!=? AND timer<=? AND `exp` BETWEEN ? AND ? ORDER BY RAND() LIMIT 1',
                $user['id'], $config['game']['hp_min'], $user['race'], time(), $user['exp'] * 0.75, $user['exp'] * 1.1 );
    } else {
        db_query( 'SELECT id FROM `user` WHERE id!=? AND hp_now>=? AND race!=? AND timer<=? AND `exp` BETWEEN ? AND ? ORDER BY RAND() LIMIT 1',
                $user['id'], $config['game']['hp_min'], $user['race'], time(), $user['exp'] * 0.9, $user['exp'] * 1.25 );
    }
    
    if ( db_num_rows() ) {
        $return = db_fetch();
        return user_information( $return['id'] );
    } else {
        return false;
    }
}

/**
 * Ataca um usuario
 * 
 * @param   array   $attacker Informações do usuario que está atacando
 * @param   array   $defender Informações do usuario que está sendo atacado
 */
function user_attack( &$attacker, $defender ) {
    global $config;
    
    $report = array();
    $report['rounds'] = array();
    
    $report['atk'] = array(
        'id' => $attacker['id'],
        'name' => $attacker['name'],
        'level' => $attacker['level'], 
        'hp_now' => $attacker['hp_now'], 
        'hp_max' => $attacker['hp_max'], 
        'ab_pow' => $attacker['ab_pow'],
        'ab_def' => $attacker['ab_def'],
        'ab_agi' => $attacker['ab_agi'],
        'ab_stam' => $attacker['ab_stam'],
        'ab_chr' => $attacker['ab_chr'],
        'items' => user_attack_items( $attacker ),
        'damage' => 0
    );
    
    $report['def'] = array(
        'id' => $defender['id'],
        'name' => $defender['name'],
        'level' => $defender['level'], 
        'hp_now' => $defender['hp_now'], 
        'hp_max' => $defender['hp_max'],
        'ab_pow' => $defender['ab_pow'],
        'ab_def' => $defender['ab_def'],
        'ab_agi' => $defender['ab_agi'],
        'ab_stam' => $defender['ab_stam'],
        'ab_chr' => $defender['ab_chr'],
        'items' => user_attack_items( $defender ),
        'damage' => 0
    );
    
    for ( $round = 0; $round < 4; $round++ ) {
        $atk = user_attack_calculate( $attacker, $defender );
        $def = user_attack_calculate( $defender, $attacker );
        
        /*
         * Vez do atacante, ele tem a chance de atacar, se a vitima não se 
         * esquivar e revidar, ele ataca
         */
        if ( $atk['hit'] ) {
            if ( !$def['dodge'] ) { // Ataca
                $defender['hp_now'] -= $atk['damage'];
                $report['atk']['damage'] += $atk['damage'];
                $report['rounds'][] = user_attack_log( $attacker['name'], $defender['name'], $atk['damage'] );
            } else { // Revida
                $tmp = user_attack_calculate( $defender, $attacker );
                $attacker['hp_now'] -= $tmp['damage'];
                $report['def']['damage'] += $tmp['damage'];
                $report['rounds'][] = user_attack_log( $defender['name'], $attacker['name'], $tmp['damage'] );
            }
        } else { // Defende
            $report['rounds'][] = user_attack_log( $attacker['name'], $defender['name'], 0 );
        }
        
        /*
         * Vez da vitima, ela tem a chance de atacar, se o atacante não se
         * esquivar e revidar, ela ataca
         */
        if ( $def['hit'] ) {
            if ( !$atk['dodge'] ) { // Ataca
                $attacker['hp_now'] -= $def['damage'];
                $report['def']['damage'] += $def['damage'];
                $report['rounds'][] = user_attack_log( $defender['name'], $attacker['name'], $def['damage'] );
            } else { // Revida
                $tmp = user_attack_calculate( $defender, $attacker );
                $defender['hp_now'] -= $tmp['damage'];
                $report['atk']['damage'] += $tmp['damage'];
                $report['rounds'][] = user_attack_log( $attacker['name'], $defender['name'], $tmp['damage'] );
            }
        } else { // Defende
            $report['rounds'][] = user_attack_log( $defender['name'], $attacker['name'], 0 );
        }
        
        if ( $attacker['hp_now'] <= $config['game']['hp_min'] || $defender['hp_now'] <= $config['game']['hp_min'] )
            break;
    }
    
    if ( $def['damage'] >= $atk['damage'] ) { // O atacante perdeu
        $gold = ceil( $attacker['gold'] * 0.1 );
        $exp = rand( 2, 6 );
        $attacker['gold'] -= $gold;
        $attacker['stat_gold_p'] -= $gold;
        $attacker['stat_dam_p'] += $report['atk']['damage'];
        $defender['gold'] += $gold;
        $defender['stat_gold_p'] += $gold;
        $defender['stat_dam_p'] += $report['atk']['damage'];
        $defender['exp'] += $exp;
        $defender['time_attack'] = time() + 3600;
        
        $winner = json_encode( array( 'name' => $defender['name'], 'gold' => $gold, 'exp' => $exp ) );
        
        db_query( "INSERT INTO user_fight (attacker, defender, winner, time, report) VALUES ('?', '?', '?', '?', '?')", json_encode( $report['atk'] ), json_encode( $report['def'] ), $winner, time(), json_encode( $report['rounds'] ) );
        $fight_id = db_insert_id();
        
        user_messages_send( null, $attacker, "Você atacou", "<a target=\"_top\" href=\"user_fight_report.php?id={$fight_id}\">Você atacou {$defender['name']} e perdeu.</a>" );
        user_messages_send( null, $defender, "Você foi atacado", "<a target=\"_top\" href=\"user_fight_report.php?id={$fight_id}\">Você foi atacad por {$attacker['name']} e ganhou.</a>" );
        
        db_query( 'UPDATE user SET gold=?, hp_now=?, stat_gold_p=?, stat_dam_p=?, stat_loss=stat_loss+1, stat_battle=stat_battle+1 WHERE id=?',
            $attacker['gold'],
            $attacker['hp_now'],
            $attacker['stat_gold_p'],
            $attacker['stat_dam_p'],
            $attacker['id']
        );
        db_query( 'UPDATE user SET gold=?, exp=?, hp_now=?, time_attack=?, stat_gold_p=?, stat_dam_p=?, stat_prey=stat_prey+3, stat_win=stat_win+1, stat_battle=stat_battle+1 WHERE id=?',
            $defender['gold'],
            $defender['exp'],
            $defender['hp_now'],
            $defender['time_attack'],
            $defender['stat_gold_p'],
            $defender['stat_dam_p'],
            $defender['id']
        );
        
        return 'Você não conseguiu resistir a luta e acabou perdendo.';
    } else { // O atacante ganhou
        $gold = ceil( $defender['gold'] * 0.1 );
        $exp = rand( 2, 6 );
        $attacker['exp'] += $exp;
        $attacker['gold'] += $gold;
        $attacker['stat_dam_p'] += $report['atk']['damage'];
        $attacker['stat_gold_p'] += $gold;
        $defender['gold'] -= $gold;
        $defender['time_attack'] = time() + 3600;
        
        $winner = json_encode( array( 'name' => $defender['name'], 'gold' => $gold, 'exp' => $exp ) );
        
        db_query( "INSERT INTO user_fight (attacker, defender, winner, time, report) VALUES ('?', '?', '?', ?, '?')", json_encode( $report['atk'] ), json_encode( $report['def'] ), $winner, time(), json_encode( $report['rounds'] ) );
        $fight_id = db_insert_id();
        
        user_messages_send( null, $attacker, "Você atacou", "<a target=\"_top\" href=\"user_fight_report.php?id={$fight_id}\">Você atacou {$defender['name']} e ganhou.</a>" );
        user_messages_send( null, $defender, "Você foi atacado", "<a target=\"_top\" href=\"user_fight_report.php?id={$fight_id}\">Você foi atacado por {$attacker['name']} e perdeu.</a>" );
        
        db_query( 'UPDATE user SET gold=?, exp=?, hp_now=?, stat_gold_p=?, stat_dam_p=?, stat_prey=stat_prey+3, stat_win=stat_win+1, stat_battle=stat_battle+1 WHERE id=?',
            $attacker['gold'],
            $attacker['exp'],
            $attacker['hp_now'],
            $attacker['stat_gold_p'],
            $attacker['stat_dam_p'],
            $attacker['id']
        );
        db_query( 'UPDATE user SET gold=?, hp_now=?, time_attack=?, stat_gold_p=?, stat_dam_p=?, stat_win=stat_loss+1, stat_battle=stat_battle+1 WHERE id=?',
            $defender['gold'],
            $defender['hp_now'],
            $defender['time_attack'],
            $defender['stat_gold_p'] - $gold,
            $defender['stat_dam_p'] + $report['atk']['damage'],
            $defender['id']
        );
    }
}

/**
 * Cria um ataque
 * 
 * @see http://browiki.org/wiki/Atributos
 * @param   array   $attacker   Informações do usuario que está atacando
 * @param   array   $defender   Informações do usuario que está sendo atacado
 * @return  array               Informações do ataque
 */
function user_attack_calculate( $attacker, $defender ) {
    $return = array();
    
     // Multiplicador do turno
    $multiplier = '0.' . rand();
    
    // Chance da atacar
    $hit = 85 + ( ( $attacker['ab_chr'] / 4 ) + ( $attacker['ab_agi'] / 3 ) ) * 0.3;
    $return['hit'] = rand( 0, 100 ) < $hit ? true : false;
    
    // Possibilidade de revidar
    $dodge = 3 + ( ( $defender['ab_chr'] / 5 ) + ( $defender['ab_agi'] / 4 ) ) * 0.2;
    $return['dodge'] = rand( 0, 100 ) < $dodge ? true : false;
    
    // Calcula o dano causado
    $atk = ( $attacker['ab_pow'] * 1.2 ) + ( $attacker['ab_agi'] / 5 ) + ( $attacker['ab_chr'] / 3 ) + ( $attacker['level'] / 4 );
    $def = ( $defender['ab_def'] / 2 ) + ( $defender['ab_agi'] / 5 ) + ( $defender['ab_pow'] / 5 ) + ( $defender['level'] / 6 );
    $return['damage'] = rand( $def, $atk + ( $atk * $multiplier ) );
    
    // Dano critico
    if ( rand( 1, 100 ) <= ( $attacker['ab_chr'] / 4 ) * 0.3 )
        $return['damage'] *= 1.4;    
    
    return $return;
}

/**
 * Obtem as IDs dos itens usado no ataque por um usuario
 * 
 * @param   array   $user   Informações do usuario
 * @return  array           IDs dos itens
 */
function user_attack_items( $user ) {
    $items = array();
    $user_items = user_items( $user );
    
    foreach ( $user_items as $item )
        $items[] = $item['id'];
    
    return $items;
}

/**
 * Retorna uma mensagem aleatoria para uma luta
 * 
 * @param   array   $attacker   Informações do usuario que está atacando
 * @param   array   $defender   Informações do usuario que está defendendo
 * @param   int     $damage     Dano causado
 * @return  string              Menssagem aleatoria
 */
function user_attack_log( $attacker, $defender, $damage ) {
    $str = array();
    
    if ( $damage == 0 ) {
        $str[0] = "<p><b>{$attacker}</b> tenta acertar <b>{$defender}</b>. Mas <b>{$defender}</b> defende com sucesso o ataque. (0)</p>";
        $str[1] = "<p><b>{$attacker}</b> cai sobre <b>{$defender}</b>. Mas <b>{$defender}</b> consegue interceptar o ataque. (0)</p>";
        $str[2] = "<p><b>{$attacker}</b> começa a correr rápido contra <b>{$defender}</b>. E <b>{$defender}</b> defende com sucesso o ataque. (0)</p>";
    } else {
        $str[0] = "<p><b>{$attacker}</b> cai sobre <b>{$defender}</b>. E <b>{$defender}</b> leva um soco na testa. ({$damage})</p>";
        $str[1] = "<p><b>{$attacker}</b> começa a correr r&aacute;pido contra <b>{$defender}</b>. E <b>{$defender}</b> recebe um forte impacto na cabe&ccedil;a. ({$damage})</p>";
        $str[2] = "<p><b>{$attacker}</b> começa a correr r&aacute;pido contra <b>{$defender}</b>. E <b>{$defender}</b> leva uma dentada no bra&ccedil;o. ({$damage})</p>";
        $str[3] = "<p><b>{$attacker}</b> tenta acertar em <b>{$defender}</b>. E <b>{$defender}</b> leva uma dentada no bra&ccedil;o. ({$damage})</p>";
    }

    return $str[rand( 0, count( $str ) - 1 )];
}

/**
 * Ativa o Lorde das Sombras para um usuário
 * 
 * @param   array   $user   Informações do usuario
 */
function user_buy_shadowlord( &$user ) {
    $user['ignicit'] -= 15;
    
    if ( $user['lord'] )
        $user['lord'] += 604800; // 14 dias
    else
        $user['lord'] = time() + 604800; // 14 dias
    
    db_query( 'UPDATE user SET ignicit=?, lord=? WHERE id=?', $user['ignicit'], $user['lord'], $user['id'] );
}

function is_valid_filename($filename) {
  $allowed_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789._-';
  for ($i = 0; $i < strlen($filename); $i++) {
    if (strpos($allowed_chars, $filename[$i]) === false) {
      return false;
    }
  }
  return true;
}


function sanitize_filename($filename) {
  $filename = strip_tags($filename);
  $filename = preg_replace('/[\s-]+/', '_', $filename);
  $filename = strtolower($filename);
  $filename = preg_replace('/[^A-Za-z0-9_.]/', '', $filename);
  return $filename;
}



function upload_avatar($user2) {
  $allowed_exts = ['jpg', 'jpeg', 'png'];
  
  if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $avatar_name = basename(sanitize_filename($avatar['name']));
    $avatar_tmp_name = $avatar['tmp_name'];
    $avatar_ext = pathinfo($avatar_name, PATHINFO_EXTENSION);
    
    if (is_valid_filename($avatar_name) && in_array($avatar_ext, $allowed_exts)) {
      $avatar_path = "uploads/avatars/$avatar_name";
      if (is_uploaded_file($avatar_tmp_name)) {
        if (move_uploaded_file($avatar_tmp_name, $avatar_path)) {
          // Update user avatar path in database
          $avatar_path = mysql_real_escape_string($avatar_path);
          db_query("UPDATE user SET avatar='?' WHERE id=?", $avatar_path, $user2);
        } else {
          die('Error moving uploaded file!'); 
        } 
      } else {
        die('File not uploaded properly!'); 
      }
    } else {
      die('Invalid filename or file type!'); 
    }
  }
}



