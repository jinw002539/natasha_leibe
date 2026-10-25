<?php
/**
 * CONTEÚDO DO SITE — editas tudo aqui.
 *
 * Onde pôr as fotografias (dentro de /imagens):
 *   galeria/<nome-do-album>/foto.jpg   -> cada pasta é um álbum (ex.: galeria/primeiro-encontro/)
 *   poemas/foto.jpg                    -> fotos para acompanhar poemas
 *   mensagens/foto.jpg                 -> fotos de fundo das mensagens
 * Dica: começa o nome dos ficheiros por data (2024-05-12_praia.jpg) e ficam por ordem.
 */
return [
    'titulo'     => 'Para ti',
    'assinatura' => 'Só tu.',
    'intervalo'  => 5000,   // milissegundos entre trocas automáticas
    'paginacao'  => 30,     // fotos por página dentro de cada álbum

    // Se um poema/mensagem não tiver 'imagem', usa fotos da galeria como fundo.
    'fundo_automatico' => true,

    'secoes' => [
        'mensagens' => ['titulo' => 'Mensagens', 'descricao' => 'Palavras simples e momentos que guardo com carinho.'],
        'poemas'    => ['titulo' => 'Poemas',    'descricao' => 'Versos de amor com um toque da minha vida em IT.'],
        'galeria'   => ['titulo' => 'Galeria',   'descricao' => 'Fotografias e lembranças dos nossos momentos.'],
    ],

    // Capas do menu inicial (opcional): caminho relativo a /imagens
    'capas' => [
        // 'mensagens' => 'mensagens/capa.jpg',
        // 'poemas'    => 'poemas/capa.jpg',
        // 'galeria'   => 'galeria/primeiro-encontro/01.jpg',
    ],

    // Personalizar álbuns (a chave é o nome da pasta). Tudo opcional.
    'albuns' => [
        'nossa-historia' => [
            'titulo' => 'A nossa história',
            'descricao' => 'Pequenos instantes, conversas e passeios que guardo com carinho.',
            'capa' => 'galeria/nossa-historia/paisagem_praia_nossa_saida.jpg',
        ],
    ],

    // Legendas das fotos (caminho relativo a /imagens). Opcional.
    'legendas' => [
        'galeria/nossa-historia/Screenshot_deCall_2026.07.15-11:13:11.png' => 'Uma chamada que ficou na memória.',
        'galeria/nossa-historia/Screenshot_de_call_20260715-10:32:47.png' => 'Um instante nosso, mesmo à distância.',
        'galeria/nossa-historia/foto_da_carta_origame_que_dei.jpg' => 'Uma carta feita com carinho.',
        'galeria/nossa-historia/foto_de_como_ela_queria_carta.jpg' => 'Um retrato cheio de ternura.',
        'galeria/nossa-historia/foto_del_com_oculos.jpg' => 'Um dos teus olhares que adoro.',
        'galeria/nossa-historia/foto_dela_com_amigas.jpg' => 'Um dia feliz entre amigas.',
        'galeria/nossa-historia/foto_dela_com_sono_no_videocall.png' => 'Uma chamada tranquila no fim do dia.',
        'galeria/nossa-historia/foto_dela_dormindo.jpg' => 'Um momento calmo e sossegado.',
        'galeria/nossa-historia/foto_dela_esplendida.jpg' => 'Um detalhe preparado com carinho.',
        'galeria/nossa-historia/foto_dela_linda.jpg' => 'A tua beleza, guardada numa fotografia.',
        'galeria/nossa-historia/foto_dela_na_igreja_acolita.jpg' => 'Um momento especial na igreja.',
        'galeria/nossa-historia/foto_dela_perto_do_mar_na_nossa_saida.jpg' => 'Um passeio nosso junto ao mar.',
        'galeria/nossa-historia/foto_dela_rindo_4_fotosnuma.jpg' => 'Quatro jeitos de iluminares o dia.',
        'galeria/nossa-historia/foto_dela_seria_belissima.jpg' => 'A serenidade do teu olhar.',
        'galeria/nossa-historia/foto_perna_dela_no_bus.jpg' => 'Um pequeno detalhe de um passeio.',
        'galeria/nossa-historia/nossa_foto_maos_dadas.jpg' => 'Mãos dadas, um momento nosso.',
        'galeria/nossa-historia/nossa_foto_maos_dadas_com_outras_coisas.jpg' => 'Uma lembrança feita de pequenos detalhes.',
        'galeria/nossa-historia/nossa_foto_minha_mao_na_coxa_dela.jpg' => 'Um instante de proximidade e carinho.',
        'galeria/nossa-historia/olhos_dela.jpg' => 'Os olhos que reconheço entre mil.',
        'galeria/nossa-historia/paisagem_praia_nossa_saida.jpg' => 'A paisagem do nosso passeio à beira-mar.',
        'galeria/nossa-historia/screen_de_um_videoCall.png' => 'Um sorriso do outro lado do ecrã.',
    ],

    // Texto simples, ou ['texto' => '...', 'imagem' => 'mensagens/foto.jpg']
    'mensagens' => [
        ['texto' => 'Gosto muito de ti e desejo-te sempre coisas boas.', 'imagem' => 'mensagens/foto_dela_rindo_4_fotosnuma.jpg'],
        ['texto' => 'O teu sorriso tem o dom de tornar o dia mais leve.', 'imagem' => 'mensagens/screen_de_um_videoCall.png'],
        ['texto' => 'Aquele passeio junto ao mar continua entre as minhas memórias favoritas.', 'imagem' => 'mensagens/foto_dela_perto_do_mar_na_nossa_saida.jpg'],
        ['texto' => 'Mesmo à distância, uma conversa contigo sabe bem.', 'imagem' => 'mensagens/Screenshot_deCall_2026.07.15-11:13:11.png'],
        ['texto' => 'Guardo com carinho cada gesto e cada palavra que partilhámos.', 'imagem' => 'mensagens/foto_da_carta_origame_que_dei.jpg'],
    ],

    /*
     * Poemas:
     *   layout  'fundo' = foto por trás e texto por cima
     *           'topo'  = foto em cima e texto por baixo
     *   duracao tempo de leitura em ms (opcional; senão usa 'intervalo')
     *   Uma linha vazia ('') cria uma pausa entre estrofes.
     */
    'poemas' => [
        [
            'titulo' => 'Entre marés',
            'layout' => 'fundo',
            'imagem' => 'poemas/paisagem_praia_nossa_saida.jpg',
            'duracao' => 9000,
            'linhas' => [
                'Ao lado do mar, o mundo baixa o volume,',
                'e o instante aprende a durar.',
                'Como um algoritmo bem escrito,',
                'o teu sorriso encontra o caminho',
                'mais bonito até à minha memória.',
            ],
        ],
        [
            'titulo' => 'O teu olhar',
            'layout' => 'topo',
            'imagem' => 'poemas/olhos_dela.jpg',
            'duracao' => 9000,
            'linhas' => [
                'Nos teus olhos encontro silêncio,',
                'daquele que sabe acolher.',
                'São como dois pontos de luz no monitor,',
                'acendendo a noite sem pedir nada',
                'além de um instante para os ver.',
            ],
        ],
        [
            'titulo' => 'Em sintonia',
            'layout' => 'fundo',
            'imagem' => 'poemas/nossa_foto_maos_dadas.jpg',
            'duracao' => 9000,
            'linhas' => [
                'Mãos dadas, sem pressa de chegar,',
                'partilhando o caminho e o silêncio.',
                'Como dois dispositivos na mesma rede,',
                'encontramos um sinal tranquilo',
                'no simples prazer de estarmos perto.',
            ],
        ],
        [
            'titulo' => 'Aprender com cuidado',
            'layout' => 'topo',
            'imagem' => 'poemas/foto_da_carta_origame_que_dei.jpg',
            'duracao' => 9000,
            'linhas' => [
                'Se errei, quero aprender com isso,',
                'e mostrar a mudança com atitudes.',
                'Como quem depura um programa,',
                'revejo cada falha e procuro fazer melhor.',
                'Sem pressa e sem exigir respostas:',
                'só respeito, honestidade e cuidado,',
                'um passo de cada vez.',
            ],
        ],
    ],
];
