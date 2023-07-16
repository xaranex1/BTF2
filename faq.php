<?php
/**
 * BiteFight
 * Fixed by: ExtremsX
 * Versão: 1.1
 * Revisão: 2013/01/08
 */

require 'include/config.php';

if ( isset( $_SESSION['id'] ) )
    require 'include/tpl/top.php';
else
    require 'include/tpl/top_2.php';
?>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
    <tr>
        <td class="tdh" align="center">Ajuda</td>
    </tr>
    <tr>
        <td class="tdn" align="left">
            <ul>
                <li>1. <a href="#F100" style="cursor:help;" onclick="show_hide_menus('fm100');">O que é o Bitefight?</a></li>
                <li>
                    2. <a href="#F200" style="cursor:help;" onclick="show_hide_menus('fm200');">Vista geral</a>
                    <ul>
                        <li>2.01 <span><a href="#F201" style="cursor:help;" onclick="show_hide_menus('fm201');">Habilidades</a></span></li>
                        <li>2.02 <span><a href="#F202" style="cursor:help;" onclick="show_hide_menus('fm202');">Estatísticas</a></span></li>
                        <li>2.03 <span><a href="#F203" style="cursor:help;" onclick="show_hide_menus('fm203');">Link mordedura</a></span></li>
                        <li>2.04 <span><a href="#F204" style="cursor:help;" onclick="show_hide_menus('fm204');">Inventário</a></span></li>
                    </ul>
                </li>
                <li>3. <a href="#F300" style="cursor:help;" onclick="show_hide_menus('fm300');">O esconderijo</a><ul></ul></li>
                <li>
                    4. <a href="#F400" style="cursor:help;" onclick="show_hide_menus('fm400');">clã</a> 
                    <ul>
                        <li>4.01 <span><a href="#F401" style="cursor:help;" onclick="show_hide_menus('fm401');">Esconderijo do clã e membros</a></span></li>
                        <li>4.02 <span><a href="#F402" style="cursor:help;" onclick="show_hide_menus('fm402');">Luta de clãs</a></span></li>
                        <li>4.03 <span><a href="#F403" style="cursor:help;" onclick="show_hide_menus('fm403');">Rituais de clãs</a></span></li>
                    </ul>
                </li>
                <li>
                    5. <a>A cidade</a>
                    <ul>
                        <li>5.01 <span><a href="#F501" style="cursor:help;" onclick="show_hide_menus('fm501');">O mercador</a></span></li>
                        <li>5.02 <span><a href="#F502" style="cursor:help;" onclick="show_hide_menus('fm502');">O Cemitério</a></span></li>
                        <li>5.03 <span><a href="#F503" style="cursor:help;" onclick="show_hide_menus('fm503');">Taverna</a></span></li>
                        <li>5.04 <span><a href="#F504" style="cursor:help;" onclick="show_hide_menus('fm504');">A Caverna</a></span></li>
                        <li>5.05 <span><a href="#F505" style="cursor:help;" onclick="show_hide_menus('fm505');">Market</a></span></li>
                        <li>5.06 <span><a href="#F506" style="cursor:help;" onclick="show_hide_menus('fm506');">O mercado</a></span></li>
                        <li>5.07 <span><a href="#F507" style="cursor:help;" onclick="show_hide_menus('fm507');">Loja Voodoo</a></span></li>
                        <li>5.08 <span><a href="#F508" style="cursor:help;" onclick="show_hide_menus('fm508');">A Igreja</a></span></li>
                    </ul>
                </li>
                <li>
                    6. <a href="#F600" style="cursor:help;" onclick="show_hide_menus('fm600');">A caça</a> 
                    <ul>
                        <li>6.01 <span><a href="#F601" style="cursor:help;" onclick="show_hide_menus('fm601');">Caça outra raça</a></span></li>
                        <li>6.02 <span><a href="#F602" style="cursor:help;" onclick="show_hide_menus('fm602');">Caça a humanos</a></span></li>
                        <li>6.03 <span><a href="#F603" style="cursor:help;" onclick="show_hide_menus('fm603');">Caça aos dem&oacute;nios</a></span></li>
                    </ul>
                </li>
                <li>
                    7. <a >Mensagens, lista de amigos e Bloco de Anotaç&otilde;es</a> 
                    <ul>
                        <li>7.01 <span><a href="#F701" style="cursor:help;" onclick="show_hide_menus('fm701');">Mensagens</a></span></li>
                        <li>7.02 <span><a href="#F702" style="cursor:help;" onclick="show_hide_menus('fm702');">Lista de amigos</a></span></li>
                        <li>7.03 <span><a href="#F703" style="cursor:help;" onclick="show_hide_menus('fm703');">Bloco de anotaç&otilde;es</a></span></li>
                    </ul>
                </li>
                <li>8. <a href="#F800" style="cursor:help;" onclick="show_hide_menus('fm800');">Configuraç&otilde;es</a></li>
            </ul>
	</td>
    </tr>
    <tr><td height=10></td></tr>
    <tr>
        <td>
            <table id="fm100" border="0" width="100%" style="display:none;">
		<tr><td class="tdh">O que é o Bitefight?</td></tr>
		<tr>
                    <td class="tdn">BiteFight é um jogo de browser grátis 
                        no qual você compete contra milhares de outros jogadores. A 
                        &uacute;nica coisa que você precisa para jogar BiteFight é 
                        um browser (como Internet Explorer ou FireFox), não sendo preciso 
                        baixar ou instalar qualquer coisa. Quando você faz o log in, 
                        você já pode decidir se você quer escorregar para 
                        dentro do papel de um vampiro ou de um lobisomem para ir á 
                        batalha. 
                        <p>Quando se registrar, por favor insira um endereço de e-mail 
                        válido, uma vez registrado irá receber um e-mail contendo 
                        um link de ativação da sua conta. Por favor clique 
                        nesse link ou copie para o seu navegador de internet no prazo de 
                        3 dias para validar a sua conta no BiteFight.</p>
                    </td>
                </tr>
		<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm100');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm200" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Vista geral</td>
        </tr>
			<tr>
          <td class="tdn">A vista geral mostra á você todas as informaç&otilde;es 
            sobre seu personagem: sua posição no ranking, a quantidade 
            de Pedras do Inferno e ouro que tem, suas estatísticas e seus 
            itens.<br>
            Você pode também treinar suas habilidades aqui:</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm200');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm201" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Habilidades</td>
        </tr>
			<tr>
          <td class="tdn">A tabela mostra seu nivel atual. O nivel é baseado 
            na sua experiência e aumenta quando você ganha mais experiência 
            (por exemplo em batalhas). 
            <p>A força indica seu grau de força que você poderá 
              usar na batalha. Quanto maior for sua força, maiores as chances 
              de você fazer um bom ataque no inimigo.</p>
            <p>Defesa reflete suas capacidade de se defender nas suas habilidades 
              de evitar ataques do seu inimigo.</p>
            <p>Destreza descreve a capacidade de acertar seu inimigo na batalha. 
              Quanto maior for este valor, mais chances você terá 
              de acertar seu inimigo.</p>
            <p>Seu nível de resistência afeta a sua recuperação 
              dos pontos de energia e ajuda você a limitar o dano que podes 
              sofrer. Quanto maior for este valor, mais rápido você 
              se recupera. A razão de recuperação por hora 
              corresponde aos seus pontos de resistência.</p>
            <p>Seu nível de carisma determina sua capacidade de encontrar 
              um inimigo durante uma caçada. Quanto maior for o seu carisma, 
              maiores suas chances de encontrar seus inimigos, até se você 
              tiver um bom e bem construído esconderijo. Durante a batalha, 
              seu carisma ajuda você a dar ataques duplos. Quando você 
              caçar humanos, o nível alto de carisma ajuda você 
              a encontrar mais vítimas.</p>
            <p>A experiência que você ganha durante os efeitos do 
              jogo no seu nível. A vista geral indica quantos pontos de 
              experiência que você precisa para chegar ao pr&oacute;ximo 
              nível. Há diferentes maneiras de ganhar pontos de 
              experiência:<br>
              caça humana, o trabalho de cemitério, miss&otilde;es 
              na gruta ou caça aos dem&ocirc;nios.<br>
              Os pontos de experiência que você precisa para chegar 
              ao pr&oacute;ximo nível é baseada no princípio: 
              10 * nível-5.</p>
            <p>A energia indica como está o seu personagem atualmente. 
              Não se preocupe, seu personagem não vai morrer por 
              mais baixos que sejam os seus pontos de vida. Mas você não 
              pode ir caçar, se você tiver menos de 25 pontos. Uma 
              vez que os seus pontos de vida diminuíram, eles vão 
              começar a aumentar novamente automaticamente durante o decorrer 
              do tempo. Com cada aumento de nível, seus pontos de vida 
              também aumentará.</p>
            <p>Você pode melhorar cinco skills básicas (força, 
              defesa, destreza, resistência e carisma), através do 
              treino. Se você quiser treinar suas habilidades, você 
              precisa pagar com o ouro que você tem. Quanto maior o nível 
              da formação é, mais ouro você tem que 
              pagar.</p></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm201');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm202" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Estatísticas</td>
        </tr>

			<tr>
          <td class="tdn">Esta tabela lista todas as estatísticas relevantes 
            do seu personagem: lutas, ouro capturado e todo o seu saque. O saque 
            total determina sua reputação no jogo. Quanto maior 
            for seu saque total, maior será sua reputação. 
            Se você visitar um falsificador para trocar seu nome, sua reputação 
            deve ser reduzida. Seu saque total também afeta a força 
            dos dem&oacute;nios contra os quais você luta na gruta.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm202');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm203" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Link mordedura</td>
        </tr>
			<tr>
          <td class="tdn">Você pode trazer novas pessoas ao jogo passando 
            o seu link para mordidelas. Todo mundo que clicar no seu link será 
            mordido por você, lhe dando algum ouro pela sua mordida. Quando 
            as pessoas clicam no seu link, se registam e indicam seu nome, elas 
            são &quot;transformadas&quot; por você.
            <p>Você pode adicionar esse link na sua página, assinaturas 
              de f&oacute;runs ou enviar para seus amigos. Por favor não 
              use o seu link para fazer spam em f&oacute;runs. Jogadores que forem 
              apanhados fazendo isso serão banidos sem aviso prévio. 
              Se alguém clicar no seu link será mordido e você 
              receberá ouro e saque!</p></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm203');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm204" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Inventário</td>
        </tr>
			<tr>
          <td class="tdn">Seu inventário lista os itens que você 
            possui atualmente. Se você quer usar um item na batalha (por 
            exemplo armas), você precisa ativá-los.<br>
            O n&uacute;mero de itens que você pode manter no seu inventário 
            depende do nível da sua residência no seu esconderijo. 
            No começo, você pode possuir até três itens 
            e mais dois adicionais por cada evolução da residência. 
            O máximo de itens que pode possuir é 25.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm204');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm300" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">O esconderijo</td>
        </tr>
			<tr>
          <td class="tdn">O esconderijo protege você de ataques de inimigos. 
            Quanto mais você evoluí-lo, melhor você estará 
            protegido. Você nunca pode ter o nível do muro, caminho 
            ou meio envolvente maior que o nível da residência.<br>
            Você pode também comprar outras utilidades do esconderijo 
            com suas pedras do inferno:
            <p>Ba&uacute; do Tesouro:<br>
              Você pode salvar parte do seu ouro dos inimigos aqui. Um dia 
              inteiro de empréstimos é protegido e não pode 
              ser roubado.</p>
            <p>Guardião-Gargoyle:<br>
              O Gargoyle protege você lutando contra seus inimigos. Sua 
              defesa é 30% mais eficiente que o normal.<br>
              Defesa +30%</p>
            <p>Livro das blasfêmias: O ancião coleciona conhecimento 
              das batalhas antigas neste livro. Sua força é 30% 
              maior se você tiver esse livro.<br>
              Força +30%</p></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm300');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm400" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">O Clã</td>
        </tr>
			<tr>
          <td class="tdn">Um Clã é um grupo de diferentes jogadores 
            da mesma raça. Seu objetivo é se tornar o mais poderoso 
            Clã e lutar juntos até o topo. Membros do Clã 
            ajudam uns aos outros e lutam juntos contra os inimigos.<br>
            &Eacute; sua decisão entrar em um Clã já existente, 
            começar um Clã novo ou se esforçar durante o 
            jogo sozinho (não existe a obrigação de se estar 
            em um Clã).</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm400');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm401" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Esconderijo do clã e membros</td>
        </tr>
			<tr>
          <td class="tdn">O n&uacute;mero máximo de membros do Clã 
            depende do nível do esconderijo do Clã.<br>
            Para cada evolução no esconderijo do Clã, 3 novos 
            membros poderão se juntar ao mesmo. O n&uacute;mero máximo 
            de evoluç&otilde;es é 16. Melhorar o esconderijo do 
            Clã custa ouro. Então, os membros do Clã podem 
            doar ouro para a conta do Clã. O ouro do Clã s&oacute; 
            pode ser usado para evoluir o esconderijo e para os rituais de Clã. 
            O fundador e os administradores têm várias ferramentas 
            &agrave; sua disposição para administrar os membros.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm401');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm402" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Luta de clãs</td>
        </tr>
			<tr>
          <td class="tdn">Um clã pode declarar guerra &agrave; outros clãs 
            que tenham o mesmo nível de esconderijo.<br>
            Se um clã declara guerra contra um clã da mesma raça, 
            o clã inimigo precisa aprovar a guerra. Guerras contra outras 
            raças podem ser travadas imediatamente. Quando uma declaração 
            de guerra é aprovada, a guerra começa 8 horas depois. 
            Durante o tempo de preparação os membros de cada clã 
            podem aceitar tomar parte na guerra. Se uma declaração 
            de guerra for descartada 1 hora ou menos antes de a guerra começar, 
            o fundador perde 5% do saque total (o comandante tem a posição 
            avançada quanto ao campo de batalha). 1 hora depois de começada 
            a guerra, todos os membros do clã que tiverem entrado na guerra 
            re&uacute;nem-se. Desse momento em diante, os membros não poderão 
            mais executar qualquer outra atividade.<br>
            Clãs que forem atacados podem adiar a hora de início 
            da guerra em até uma hora no máximo. O líder 
            do clã pode posicionar qualquer membro do clã que tiver 
            entrado na guerra em uma formação pr&oacute;pria. A 
            escolha da formação da guerra pode ser decisiva para 
            o final da guerra.<br>
            Existem no máximo 28 rounds durante a batalha. Se os dois líderes 
            sobreviverem, o clã que tiver conseguido mais pontos na batalha, 
            vence.<br>
            Todo membro do clã vencedor ganha uma divisão do ouro. 
            Essa divisão do ouro é feita pelo total de ouro que 
            os guerreiros conseguiriam em uma hora de trabalho no cemitério 
            e o n&uacute;mero de sobreviventes.<br>
            O clã que perde não ganha nada.<br>
            Todos os guerreiros envolvidos ganham pontos de experiência 
            nas batalhas em que lutarem.<br></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm402');">Fechar</span></td></tr>
			</table>

			</td></tr><tr><td>
			<table id="fm403" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Rituais de clãs</td>
        </tr>
			<tr>
          <td class="tdn">Os rituais do clã tem um impacto em todos os 
            membros e pode, por exemplo, deixá-los com habilidades melhores. 
            Membros do clã podem atuar como invocadores para evocar os 
            rituais desejados. O preço para uma invocação 
            é pago com o dinheiro do clã. Uma evocação 
            precisa de 10 minutos. Antes do final da invocação, 
            as condiç&otilde;es do ritual precisam ser favoráveis. 
            Membros do clã podem chamar por um invocador a cada 2 horas.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm403');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>

			<table id="fm501" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">O mercador</td>
        </tr>
			<tr>
          <td class="tdn">No mercador você pode comprar muitos itens &uacute;teis.<br>
            Armas e equipamentos normalmente aumentam sua força e outras 
            habilidades.<br>
            Quanto maior for o seu nível, maior será o repert&oacute;rio 
            de itens disponíveis. No seu inventário na &quot;Vista 
            Geral&quot; você s&oacute; pode ativar uma arma (ou um capacete, 
            armadura, etc.) de cada vez, mas você pode carregar vários 
            tipos de armas - até do mesmo tipo - com você. Se você 
            ativar uma nova arma, sua arma que estiver atualmente ativada será 
            desativada.<br>
            O n&uacute;mero de itens que você pode carregar depende do nível 
            do seu esconderijo.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm501');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm502" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">O Cemitério</td>
        </tr>
			<tr>
          <td class="tdn">Aqui você pode encontrar trabalho e ganhar ouro. 
            Você pode determinar seu tempo de trabalho. Você pode 
            trabalhar no máximo 8 horas. Você será pago de 
            acordo com seu nível e você receberá seu pagamento 
            assim que terminar seu trabalho. Se você sair do trabalho por 
            conta pr&oacute;pria, você não será pago.<br>
            Dica: você também pode ser atacado por inimigos enquanto 
            estiver trabalhando. Suas horas de trabalho continuam mesmo que você 
            se desconecte da Internet ou se você desligar seu computador.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm502');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm503" border="0" width="100%" style="display:none;">
			
        <tr> 
          <td class="tdh"><a name="F503">Taverna</a></td>
        </tr>
			<tr>
          <td class="tdn">Na taberna você pode aceitar miss&otilde;es e 
            conseguir algumas informaç&otilde;es sobre miss&otilde;es aceitas. 
            Você pode escolher entre três níveis de dificuldade: 
            Fácil, Médio e Difícil. Quanto mais difícil 
            a missão for, mas tempo você vai precisar para completá-la. 
            Quanto maior o nível de dificuldade, maior será a remuneração 
            quando você obtiver sucesso. Mas ao mesmo tempo você vai 
            precisar esperar um tempo maior para poder pegar uma nova missão.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm503');">Fechar</span></td></tr>
			</table>

			</td></tr><tr><td>
			<table id="fm504" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh"><a name="F504">A Caverna</a></td>
        </tr>
			<tr>
          <td class="tdn"><a name="F504">A Caverna </a>é o lugar de diversão 
            dos dem&oacute;nios. Aqui você pode caçar dem&oacute;nios 
            como o capricho pega você. Caçar dem&oacute;nios é 
            normalmente uma parte das miss&otilde;es. Os dem&oacute;nios que você 
            encontrar aqui podem ser muito perigosos e podem ter níveis 
            maiores que o teu. Em compensação, você ganha 
            mais saque e mais experiência na caça aos dem&oacute;nios 
            do que na caça &agrave; humanos. Você deve, entretanto, 
            perder mais pontos de vida. Uma vantagem de caçar dem&oacute;nios 
            é que você sempre volta mais forte para os inimigos.<br>
            Dica: O tempo que você usar na caça aos dem&oacute;nios 
            será reduzida no seu tempo de caça (também para 
            a caça &agrave; humanos).</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm504');">Fechar</span></td></tr>
			</table>

			</td></tr><tr><td>
			<table id="fm505" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">O mercado</td>
        </tr>
			<tr>
          <td class="tdn">O mercado é o lugar perfeito para neg&oacute;cios. 
            Qualquer um pode vender utilidades aqui. Você pode oferecer 
            algum de seus itens para venda para outros jogadores ou você 
            pode comprar itens de outros jogadores. &Eacute; decisão do 
            jogador que vende o preço do item; entretanto, é preciso 
            pagar uma taxa para poder vender os itens.<br>
            Dica: Você pode também comprar itens que não são 
            do seu nível. Mas você s&oacute; poderá usá-los, 
            ou &agrave;s vezes até mesmo vender, quando atingir o nível 
            do item.<br>
            Depois que você comprar um item no mercado, o item receberá 
            o elo espiritual. Você não poderá vendê-lo 
            no mercado, você s&oacute; poderá vendê-lo no mercador.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm505');">Fechar</span></td></tr>
			</table>

			</td></tr><tr><td>
			<table id="fm506" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">A Biblioteca</td>
        </tr>
			<tr>
          <td class="tdn">Se você não gostar do seu nome, poderá 
            altera-lo na biblioteca.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm506');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>

			<table id="fm507" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh"><a name="F507">Loja Voodoo</a></td>
        </tr>
			<tr>
          <td class="tdn">Neste lugar misterioso você pode comprar pedras 
            do inferno com dinheiro real.<br>
            Pedras do inferno são cristais místicos que possuem 
            uma energia enorme. Elas lhe permitem comprar itens especialmente 
            poderosos.<br>
            Na loja VooDoo você também pode se tornar um Lord das 
            Sombras. Como um Lord das Sombras você poderá aproveitar 
            alguns méritos que podem fazer o jogo mais prazeroso: 4 horas 
            de caça diária, apenas 5 minutos de espera entre os 
            ataques, melhor menu de mensagens, imagem do personagem e muito mais.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm507');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>

			<table id="fm508" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">A Igreja</td>
        </tr>
			<tr>
          <td class="tdn">Você pode ter suas feridas curadas em troca de 
            ouro na igreja. Curar 10% da sua energia custa 10% do seu atual salário 
            do dia. Você pode curar um máximo de 75% de sua energia, 
            mas se você tem mais energia, você não pode curar 
            na igreja. Depois de cada cura, você tem que esperar 1 hora 
            antes de poder curar novamente (tempo de espera). Durante o tempo 
            de espera você não pode usar qualquer outro tipo de poç&otilde;es 
            para além da poção 100% de regeneração.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm508');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm600" border="0" width="100%" style="display:none;">

			<tr>
          <td class="tdh">A caça</td>
        </tr>
			<tr>
          <td class="tdn">No Bitefight, caçar é uma de seus mais 
            importantes meios de conseguir ouro, experiência e fama.<br>
            Você tem várias opç&otilde;es de como e o que 
            caçar.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm600');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm601" border="0" width="100%" style="display:none;">

			<tr>
          <td class="tdh">Caça &agrave; outra raça</td>
        </tr>
			<tr>
          <td class="tdn">Na caçada &agrave; outra raça você 
            tenta encontrar e vencer inimigos que não sejam da sua raça. 
            Você pode procurar os inimigos rand&ocirc;micamente se você 
            selecionar &quot;normal&quot; ou &quot;procurar rivais do mesmo nível 
            ou superior&quot;.<br>
            Você também pode escrever o nome do inimigo, contra o 
            qual você queira lutar, no campo de busca. Você pode encontrar 
            os nomes de inimigos em potencial nas estatísticas. Aqui, você 
            pode ver os níveis dos seus inimigos.<br>
            Cada caçada custa 1 de ouro.
            <p>Para proteger jogadores novos de ataques de jogadores mais forte 
              você s&oacute; pode caçar inimigos em uma área 
              definida de nível. A área é 9 níveis 
              acima ou abaixo do seu pr&oacute;prio nível, ou +/- 15% do 
              seu nível (dependendo da área em que você se 
              encontra - nos níveis altos é a área da %)</p></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm601');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm602" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Caça a humanos</td>
        </tr>
			<tr>
          <td class="tdn">Em uma caçada &agrave; humanos, você pode 
            ganhar muito ouro e pontos de experiência. Para cada litro de 
            sangue ou kg de carne que você conseguir, conseguirás 
            também 1 ouro. Se você tiver sorte, você pode até 
            encontrar pedras do inferno nas caçadas.<br>
            Cada caçada &agrave; humano custa 10 de ouro.<br>
            Quanto mais tempo você caçar, mais você pode conseguir. 
            Pequenas, mas numerosas, caçadas podem ser melhores, mas se 
            você caçar por apenas 10 minutos você poderá 
            acertar um poste. Neste caso você não conseguirá 
            ouro nem sangue/carne.</td>
        </tr>

			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm602');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm603" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Caça aos dem&oacute;nios</td>
        </tr>
			<tr>
          <td class="tdn">Veja a gruta
            <p>Você tem 2 horas (4 se for Lord das Sombras) de tempo de 
              caçada. Você deve usar esse tempo antes das 0 hr do 
              servidor, porque &agrave; essa hora o tempo de caçada começa 
              de novo e o restante expira.</p></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm603');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm701" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Mensagens</td>
        </tr>
			<tr>
          <td class="tdn">Aqui você pode ver os resultados de sua caçada, 
            relat&oacute;rios de combate e mensagens pessoais de outros jogadores. 
            Você poderá também escrever as suas mensagens.</td>
        </tr>

			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm701');">Fechar</span></td></tr>
			</table>
			</td></tr><tr><td>
			<table id="fm702" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Lista de amigos</td>
        </tr>
			<tr>
          <td class="tdn">Na lista de amigos você pode ver o nome, o clã, 
            o nível e o status dos seus amigos. Pela lista de amigos você 
            entrar em contato com seus amigos facilmente e enviar-lhes mensagens 
            sem ter que olhar as informaç&otilde;es de contato. E &quot;Pedidos&quot; 
            você pode ver quem gostaria de ser seu amigo. Em &quot;Pr&oacute;prios 
            pedidos&quot; você pode ver os jogadores dos quais você 
            gostaria de ser amigo.<br>
            Você pode apagar amigos da sua lista a qualquer hora.</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm702');">Fechar</span></td></tr>

			</table>
			</td></tr><tr><td>
			<table id="fm703" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Bloco de anotaç&otilde;es</td>
        </tr>
			<tr>
          <td class="tdn">Aqui você pode salvar e recuperar notas pessoais 
            a qualquer hora (por exemplo nomes, resultados de caçada, etc.)</td>
        </tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm703');">Fechar</span></td></tr>
			</table>

			</td></tr><tr><td>
			<table id="fm800" border="0" width="100%" style="display:none;">
			<tr>
          <td class="tdh">Configuraç&otilde;es</td>
        </tr>
			<tr>
          <td class="tdn">Endereço de Email:<br>
            Por favor coloque um endereço de e-mail válido, já 
            que você vai receber um e-mail incluindo um link para ativar 
            sua conta. Por favor clique no link ou copie-o no seu browser em até 
            3 dias para validar sua conta no BiteFight.
            <p>Se você quiser trocar seu endereço de e-mail, por 
              favor peça um novo link para ativar sua conta porque ele 
              será posto como endereço permanente em apenas 7 dias 
              depois de você ativar seu novo endereço de e-mail.<br>
              Se você esquecer sua senha, ela será enviada para o 
              endereço permanente.</p>
            <p>Descrição do personagem:<br>
              Você pode descrever seu personagem e introduzi-lo para outros 
              jogadores.</p>
            <p>Mensagem padrão para suas vítimas:<br>
              Você colocar um texto que será mostrado para aquelas 
              pessoas que clicarem no seu link de mordida.</p>
            <p>Informaç&otilde;es opcionais:<br>
              Aqui você pode indicar algumas informaç&otilde;es opcionais 
              sobre você.</p>
            <p>Imagem do personagem:<br>
              Se você marcar a caixa, a imagem do seu personagem aparecerá 
              no lugar do log&oacute;tipo da sua raça. Você então 
              receberá uma imagem randomica do seu personagem. Como Lord 
              das Sombras você pode criar sua pr&oacute;pria imagem.</p>
            <p>Esconder:<br>
              Se você estiver em um feriado ou se você estiver muito 
              ocupado para jogar, você pode se esconder e não precisará 
              se preocupar com seu personagem. Enquanto estiver escondido, você 
              não pode ser atacado (mínimo de tempo escondido: 2 
              dias; máximo: 30 dias). Se você marcar a caixa, você 
              vai se esconder por um mínimo de 2 dias. Antes de completar 
              esses dois você não poderá jogar e nem sair 
              do esconderijo. Quando você sair do esconderijo, você 
              terá que esperar um mínimo de 7 dias para se esconder 
              de novo. Quando o máximo de 30 dias escondido expirar, você 
              sairá do esconderijo automaticamente.</p>
            <p>Deletar conta:<br>
              Se você deseja deixar de jogar BiteFight, você pode 
              aprovar e deletar sua conta. Depois de 7 dias, sua conta será 
              deletada. Se você mudar de ideia e quiser continuar jogando, 
              você pode cancelar a deleção aqui.</p>
            <p>Dê uma olhada no f&oacute;rum do BiteFight para mais informaç&otilde;es. 
              No f&oacute;rum você pode fazer perguntas e conhecer outros 
              jogadores.</p></td></tr>
			<tr><td class="tdn" align="center"><a href="#TOP" style="cursor:pointer;" onclick="show_hide_menus('fm800');">Fechar</span></td></tr>
			</table>
			
			</td></tr></table>
		<script type="text/javascript" language="javascript">
			function show_hide_menus(ele)    {
				if (document.getElementById(ele).style.display=='')
				{
					document.getElementById(ele).style.display='none';
				}    else    {
					document.getElementById(ele).style.display='';
				}
			}
		</script>
 
		</div>

					  <td style="width:22px; background-image:url(img/border.gif); background-repeat:repeat-y; background-position:left;"></td>
</tr>

 
<?php require 'include/tpl/footer.php';?>
