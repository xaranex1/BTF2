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
 * Obtem informações sobre um trabalho
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array       $user   Informações do trabalho
 * @param   int         $action Tipo de timer
 * @return  bool|array 
 */
function user_time( $user, $action ) {
    db_query( 'SELECT * FROM action WHERE user_id=? AND model=?', $user['id'], $action );
    return db_num_rows() ? db_fetch() : false;
}

/**
 * Verifica se o usuario está com algum timer ativado, retornando o tipo de
 * timer ativado
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   int         $user   Informações do usuario
 * @return  bool|int
 */
function user_time_in_progress( $user ) {
    db_query( 'SELECT * FROM action WHERE user_id=?', $user['id'] );
    
    while( $action = db_fetch() )
        if ( $action['timer'] ) return $action['model'];
    
    return false;            
}

/**
 * Retorna o tempo restante em segundos do timer ativado
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array       $user   Informações do usuario
 * @return  bool|int
 */
function user_time_in_progress_remainder( $user ) {
    $now = time();
    db_query( 'SELECT * FROM action WHERE user_id=?', $user['id'] );
    
    while( $action = db_fetch() )
        if ( $action['timer'] ) return $action['timer'] - $now;
    
    return false;            
}

/**
 * Atualiza todos os timers do usuario
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 */
function user_time_update( &$user ) {
    $date = getdate();
    
    // Timer do Livro dos Mortos
    if ( $user['pl_book_t'] && $date[0] >= $user['pl_book_t'] ) {
        db_query( 'UPDATE user SET pl_book_t=0 WHERE id=?', $user['id'] );
        $user['pl_book_t'] = 0;
    }
    
    // Timer do Gárgula Guardiã
    if ( $user['pl_grg_t'] && $date[0] >= $user['pl_grg_t'] ) {
        db_query( 'UPDATE user SET pl_grg_t=0 WHERE id=?', $user['id'] );
        $user['pl_grg_t'] = 0;
    }
    
    // Timer do Baú do Tesouro
    if ( $user['pl_chest_t'] && $date[0] >= $user['pl_chest_t'] ) {
        db_query( 'UPDATE user SET pl_chest_t=0 WHERE id=?', $user['id'] );
        $user['pl_chest_t'] = 0;
    }
    
    // Timer de ações
    $now = getdate();
    $today = mktime( 0, 0, 0, $now['mon'], $now['mday'], $now['year'] );
    
    db_query( 'SELECT * FROM action WHERE user_id=?', $user['id'] );
    $actions = db_fetch_all();
    if ( count( $actions ) ) {        
        foreach ( $actions as $action ) {
            // Verifica se o timer está ativado e se ele já terminou
            if ( $action['timer'] > 0 && time() >= $action['timer'] ) {
                switch ( $action['model'] ) {
                    case 1: user_time_work_end( $user, $action ); break;
                    case 2: user_time_mission_end( $user, $action ); break;
                    case 3: user_time_hunt_end( $user, $action );
                }
            }
            
            if ( $today > $action['timer_last'] ) // Reseta o dia
                db_query( 'UPDATE action SET speed=0 WHERE id=?', $action['id'] );
        }
    }    
}

/**
 * Inicializa um trabalho
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   array   $speed  Tempo a ser trabalhado
 */
function user_time_work_start( &$user, $speed ) {
    $action = user_time( $user, 1 );
    $now = time();
    $time = $now + $speed * 3600;
    
    // Verifica se o timer anterior já terminou
    if ( $action && $now >= $action['timer'] )
        db_query( 'UPDATE action SET speed=?, timer=? WHERE user_id=? AND model=1', $speed, $time, $user['id'] );
    else
        db_query( 'INSERT INTO action (user_id, model, speed, timer) VALUES (?, 1, ?, ?)', $user['id'], $speed, $time );
}

/**
 * Finaliza o trabalho
 *
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   array   $action Informações do trabalho
 */
function user_time_work_end( &$user, $action ) {
    global $config;
    
    // Verifica se o timer está ativado
    if ( $action['timer'] > 0 ) {
        // Verifica se ele terminou
        if ( time() >= $action['timer'] ) {
            $user['level'] = user_calculate_level( $user['exp'] );
            $earn_gold = user_time_work_gold_earn( $user['level'] ) * $action['speed'];
            $earn_exp = ceil( $user['level'] * $action['speed'] / 8 );

            // Atualiza o usuario
            $user['gold'] += $earn_gold * $config['game']['rate']['gold'];
            $user['exp'] += $earn_exp * $config['game']['rate']['exp'];

            // Atualiza o banco de dados
            db_query( 'UPDATE action SET timer=0 WHERE id=?', $action['id'] );
            db_query( 'UPDATE user SET gold=?, exp=? WHERE id=?', $user['gold'], $user['exp'], $action['id'] );
            
            // Verfica se o usuario evoluiu
            if ( user_calculate_level( $user['exp'] ) > $user['level'] )
                user_level_up( $user );
            
            // Envia as mensagens
            $subject = 'Trabalho terminado';
            $name = user_time_work_name( $user['level'] );
            $message = "Após concluir o seu trabalho como {$name}, recebe alguns {$earn_gold} <img src=\"img/res2.gif\" alt=\"Ouro\" align=\"absmiddle\" border=\"0\"> e {$earn_exp} pontos de experiência!";
            user_messages_send( null, $user, $subject, $message, false );
            
        } else {
            // Ou apenas desabilita
            db_query( 'UPDATE action SET timer=0 WHERE id=?', $action['id'] );
        }
    }
}

/**
 * Retorna o ouro ganho no trabalho por hora baseando-se no nivel
 * 
 * @author  ExtremsX
 * @since   1.1
 * @see     http://board.bite-fight.us/board263-bitefight-community/board32-guides-faqs/board427-advanced-help/31431-graveyard-and-treasure-chest-gold-amounts/?s=85b7d4e9dbe27b08fbc0192465afd25b708c4646#post230728
 * @param   int $lvl    Nivel do personagem
 * @return  int         Ouro ganho por hora
 */
function user_time_work_gold_earn( $level ) {
    $i = 1;
    $pow = 0;
    
    while ( $i < $level ) {
        $i *= 2;
        $pow++;
    }
    
    return $level <= 2 ? 40 : pow( 2, $pow ) * 20;
}

/**
 * Retorna o nome do trabalho basendo-se no nivel do mesmo
 *
 * @author  ExtremsX
 * @since   1.1
 * @see     http://board.bite-fight.us/board263-bitefight-community/board32-guides-faqs/board427-advanced-help/31431-graveyard-and-treasure-chest-gold-amounts/?s=85b7d4e9dbe27b08fbc0192465afd25b708c4646#post230728
 * @param   int     $lvl    Nivel do personagem
 * @return  string 
 */
function user_time_work_name( $lvl ) {
    if ( $lvl < 3 )
        return 'Coveiro';
    else if ( $lvl < 7 )
        return 'Jardineiro do Cemitério';
    else if ( $lvl < 15 )
        return 'Preparador de Cadáveres';
    else if ( $lvl < 31 )
        return 'Guarda do Cemitério';
    else if ( $lvl < 63 )
        return 'Gerente de Empregados';
    else if ( $lvl < 127 )
        return 'Designer de Lápides';
    else if ( $lvl < 255 )
        return 'Designer de Criptas';
    else if ( $lvl < 511 )
        return 'Gerente do Cemitério';
}

/**
 * Inicia uma missão
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   int     $speed  Velocidade 
 */
function user_time_mission_start( &$user, $speed ) {
    $speed_max = $user['lord'] ? 24 : 12; // 4 horas ou 2 horas
    
    $action = user_time( $user, 2 );
    $now = getdate();
    $time = $now[0] + $speed * 600; // * 10 minutos
    
    if ( $action ) {
        $today = mktime( 0, 0, 0, $now['mon'], $now['mday'], $now['year'] );
        
        // Verifica se o timer anterior já terminou
        if ( $now[0] >= $action['timer'] ) {
            if ( $today > $action['timer'] ) { // Dia novo, zera tudo
                db_query( 'UPDATE action SET speed=?, timer=? WHERE user_id=? AND model=1', $speed, $time, $user['id'] );
                db_query( 'UPDATE user SET gold=gold-10 WHERE id=?', $user['id'] );
                $user['gold'] -= 10;
            } else if ( $speed + $action['speed'] <= $speed_max ) { // Dia atual, soma o total de minutos usado
                db_query( 'UPDATE action SET speed=speed+?, timer=? WHERE user_id=? AND model=1', $speed, $time, $user['id'] );
                db_query( 'UPDATE user SET gold=gold-10 WHERE id=?', $user['id'] );
                $user['gold'] -= 10;
            }
        }
    } else {
        db_query( 'INSERT INTO action (user_id, model, speed, timer) VALUES (?, 1, ?, ?)', $user['id'], $speed, $time );
        db_query( 'UPDATE user SET gold=gold-10 WHERE id=?', $user['id'] );
        $user['gold'] -= 10;
    }
}

/**
 * Inicia uma caçada
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações sobre o usuario
 * @param   int     $speed  Tempo de caça
 */
function user_time_hunt_start( &$user, $speed ) {
    $speed_max = $user['lord'] ? 24 : 12; // 4 horas
    
    $action = user_time( $user, 3 );
    $now = getdate();
    $time = $now[0] + $speed * 600; // * 10 minutos
    
    if ( $action ) {
        $today = mktime( 0, 0, 0, $now['mon'], $now['mday'], $now['year'] );
        
        // Verifica se o timer anterior já terminou
        if ( $now[0] >= $action['timer'] ) {
            if ( $today > $action['timer_last'] ) { // Dia novo, zera tudo
                db_query( 'UPDATE action SET speed=?, timer=? WHERE id=?', $speed, $time, $action['id'] );
                db_query( 'UPDATE user SET gold=gold-10 WHERE id=?', $user['id'] );
                $user['gold'] -= 10;
            } else if ( $speed + $action['speed'] <= $speed_max ) { // Dia atual, soma o total de minutos usado
                db_query( 'UPDATE action SET speed=speed+?, timer=? WHERE id=?', $speed, $time, $action['id'] );
                db_query( 'UPDATE user SET gold=gold-10 WHERE id=?', $user['id'] );
                $user['gold'] -= 10;
            }
        }
    } else {
        db_query( 'INSERT INTO action (user_id, model, speed, timer) VALUES (?, 3, ?, ?)', $user['id'], $speed, $time );
        db_query( 'UPDATE user SET gold=gold-10 WHERE id=?', $user['id'] );
        $user['gold'] -= 10;
    }    
}

/**
 * Retorna o tempo de caça já usado
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações sobre o usuario
 * @return  int             Tempo de caça já usado
 */
function user_time_hunt_time_used( &$user ) {
    $action = user_time( $user, 3 );
    return $action ? $action['speed'] : 0;
}

/**
 * Retorna o tempo já usado no formato 00:00:00
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações sobre usuario
 * @return  string          Tempo usado formatado
 */
function user_time_hunt_time_used_pretty( $speed ) {    
    if ( $speed ) { // Verifica se é maior que 0
        $pretty = '';
        if ( $speed / 6 > 0 ) { // Verifica se usou mais de uma hora
            $time = floor( $speed / 6 );
            $pretty .= "0{$time}:";
        } else {
            $pretty = '00:';
        }
        
        $time = $speed % 6 * 10; // Calcula os minutos restantes
        $pretty .= $time ? "{$time}:" : '00:';
        
        return "{$pretty}00";
    } else {
        return '00:00:00';
    }
}

/**
 * Finaliza uma caçada
 * 
 * @author  ExtremsX
 * @since   1.1
 * @param   array   $user   Informações do usuario
 * @param   array   $action Informações da ação
 */
function user_time_hunt_end( &$user, $action ) {
    global $config;
    
    // Verifica se o timer está ativado
    if ( $action['timer'] > 0 ) {
        // Verifica se ele terminou
        if ( time() >= $action['timer'] ) {
            $user['level'] = user_calculate_level( $user['exp'] );
            $earn_gold = rand( 600, 1000 );
            $earn_exp = rand( $user['level'] * 0.75, $user['level'] * 1.25 );

            // Atualiza o usuario
            $user['gold'] += $earn_gold * $config['game']['rate']['gold'];
            $user['exp'] += $earn_exp * $config['game']['rate']['exp'];

            // Atualiza o banco de dados
            db_query( 'UPDATE action SET timer=0, timer_last=? WHERE id=?', $action['timer'], $action['id'] );
            db_query( 'UPDATE user SET gold=?, exp=? WHERE id=?', $user['gold'], $user['exp'], $user['id'] );

            // Verfica se o usuario evoluiu
            if ( user_calculate_level( $user['exp'] ) > $user['level'] )
                user_level_up( $user );
            
            // Envia as mensagens
            $from = array( 'id' => 1 );
            $name = 'Caçada humana';
            $subject = 'Caçada humana concluída';
            $message = "Sua caçada por humanos foi bem sucedida, recebe alguns {$earn_gold} <img src=\"img/res2.gif\" alt=\"Ouro\" align=\"absmiddle\" border=\"0\"> e {$earn_exp} pontos de experiência!";
            user_messages_send( $from, $user, $subject, $message, false );
            
        } else {
            // Ou apenas desabilita
            db_query( 'UPDATE action SET timer=0 WHERE id=?', $action['id'] );
        }
    }
}