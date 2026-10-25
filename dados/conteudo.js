/**
 * CONTEÚDO DO SITE — editas tudo aqui.
 *
 * Onde pôr as fotografias (dentro de /imagens):
 *   galeria/<nome-do-album>/foto.jpg   -> cada pasta é um álbum (ex.: galeria/nossa-historia/)
 *   poemas/foto.jpg                    -> fotos para acompanhar poemas
 *   mensagens/foto.jpg                 -> fotos de fundo das mensagens
 * Depois de mexer nas fotos, corre:  python gerar-fotos.py
 * Dica: começa o nome dos ficheiros por data (2024-05-12_praia.jpg) e ficam por ordem.
 */
window.CONTEUDO = {
  titulo: 'Para ti',
  assinatura: 'Só tu.',
  botao: 'Amo-te Natasha',                       // texto do botão da página de entrada
  entrada: 'Ao menos quando te fores embora, terei esse lugar para me lembrar de ti com fotografias e recordações, lembrando que sempre te amei.',
  intervalo: 5000,                                // milissegundos entre trocas automáticas
  paginacao: 30,                                  // fotos por página dentro de cada álbum

  // Se um poema/mensagem não tiver 'imagem', usa fotos da galeria como fundo.
  fundo_automatico: true,

  secoes: {
    mensagens: { titulo: 'Mensagens', descricao: 'Palavras simples e idiotas escritas com carinho.' },
    poemas:    { titulo: 'Poemas',    descricao: 'Textos de amor com um pouco de Computacao.' },
    galeria:   { titulo: 'Galeria',   descricao: 'Fotografias e lembranças dos nossos momentos.' },
  },

  // Capas (opcional): caminho relativo a /imagens
  capas: {
    // entrada:   'galeria/nossa-historia/foto_dela_linda.jpg',
    // mensagens: 'mensagens/capa.jpg',
    // poemas:    'poemas/capa.jpg',
    // galeria:   'galeria/nossa-historia/01.jpg',
  },

  // Personalizar álbuns (a chave é o nome da pasta). Tudo opcional.
  albuns: {
    'nossa-historia': {
      titulo: 'A nossa história',
      descricao: 'Pequenos instantes, conversas e passeios que guardo com carinho.',
      capa: 'galeria/nossa-historia/paisagem_praia_nossa_saida.jpg',
    },
  },

  // Legendas das fotos (caminho relativo a /imagens). Opcional.
  legendas: {
    'galeria/nossa-historia/Screenshot_deCall_2026.07.15-11:13:11.png': 'Uma chamada que ficou na memória.',
    'galeria/nossa-historia/Screenshot_de_call_20260715-10:32:47.png': 'Um instante nosso, mesmo à distância.',
    'galeria/nossa-historia/foto_da_carta_origame_que_dei.jpg': 'Uma carta feita com carinho.',
    'galeria/nossa-historia/foto_de_como_ela_queria_carta.jpg': 'Um retrato daquilo que me tornou romantico.',
    'galeria/nossa-historia/foto_del_com_oculos.jpg': 'Os olhos que me tornam um bobo apaixonado.',
    'galeria/nossa-historia/foto_dela_com_amigas.jpg': 'Entre suas amigas.',
    'galeria/nossa-historia/foto_dela_com_sono_no_videocall.png': 'Voce me pediu coisas estranhas nesse dia e eu fiz o que voce pediu.',
    'galeria/nossa-historia/foto_dela_dormindo.jpg': 'Eu amo-te, esses labios.',
    'galeria/nossa-historia/foto_dela_esplendida.jpg': 'Uma obra de arte que perdi por burrice.',
    'galeria/nossa-historia/foto_dela_linda.jpg': 'A tua beleza, guardada numa fotografia.',
    'galeria/nossa-historia/foto_dela_na_igreja_acolita.jpg': 'Rezo que Deus esteja consigo.',
    'galeria/nossa-historia/foto_dela_perto_do_mar_na_nossa_saida.jpg': 'O dia que meu amor por ti aumentou mesmo não te tendo mais',
    'galeria/nossa-historia/foto_dela_rindo_4_fotosnuma.jpg': 'Quatro jeitos de iluminares o dia.',
    'galeria/nossa-historia/foto_dela_seria_belissima.jpg': 'A serenidade do teu olhar.',
    'galeria/nossa-historia/foto_perna_dela_no_bus.jpg': 'Um dia voltando para casa sem mim',
    'galeria/nossa-historia/nossa_foto_maos_dadas.jpg': 'Mãos dadas, minha maravilhosa racista kkk.',
    'galeria/nossa-historia/nossa_foto_maos_dadas_com_outras_coisas.jpg': 'Uma lembrança feita de pequenos detalhes.',
    'galeria/nossa-historia/nossa_foto_minha_mao_na_coxa_dela.jpg': 'Um instante de proximidade e coisas muito safadas.',
    'galeria/nossa-historia/olhos_dela.jpg': 'Os olhos que reconheço entre mil.',
    'galeria/nossa-historia/paisagem_praia_nossa_saida.jpg': 'Imagem que me faz lembrar do meu erro e do meu imenso amor por ti.',
    'galeria/nossa-historia/screen_de_um_videoCall.png': 'Um sorriso do outro lado do ecrã.',
  },

  // Texto simples, ou { texto: '...', imagem: 'mensagens/foto.jpg' }
  mensagens: [
    { texto: 'Amote-te desejo-te sempre coisas boas, por isso tenho que perceber que tu te vas.', imagem: 'mensagens/foto_dela_rindo_4_fotosnuma.jpg' },
    { texto: 'O teu sorriso bobo e lindo tem o dom de tornar o meu coracão em algo leve.', imagem: 'mensagens/screen_de_um_videoCall.png' },
    { texto: 'Infelizmente nosso primeiro e ultimo passeio juntos ao mar. Essa memoria é uma das mais lindas desse ano ', imagem: 'mensagens/foto_dela_perto_do_mar_na_nossa_saida.jpg' },
    { texto: 'Voce consegue me tornar numa pessoa tão boa mesmo à distância,  conversar contigo sempre será maravilhoso.', imagem: 'mensagens/Screenshot_deCall_2026.07.15-11:13:11.png' },
    { texto: 'Cada carta que deu foi escrito com Amor sincero, sempre foste tu e assim será, cada palavra foi um pingo de amor.', imagem: 'mensagens/foto_da_carta_origame_que_dei.jpg' },
  ],

  /*
   * Poemas:
   *   layout  'fundo' = foto por trás e texto por cima
   *           'topo'  = foto em cima e texto por baixo
   *   duracao tempo de leitura em ms (opcional; senão usa 'intervalo')
   *   Uma linha vazia ('') cria uma pausa entre estrofes.
   */
  poemas: [
    {
      titulo: 'Entre marés',
      layout: 'fundo',
      imagem: 'poemas/paisagem_praia_nossa_saida.jpg',
      duracao: 9000,
      linhas: [
        'Ao lado do mar, o mundo baixa o volume,',
        'e o instante aprende a durar.',
        'Como um algoritmo bem escrito,',
        'o teu sorriso encontra o caminho',
        'mais bonito até à minha memória.',
      ],
    },
    {
      titulo: 'O teu olhar',
      layout: 'topo',
      imagem: 'poemas/olhos_dela.jpg',
      duracao: 9000,
      linhas: [
        'Nos teus olhos encontro o meu sorriso,',
        'daquele que sabe acolher.',
        'São como dois pontos de luz no monitor,',
        'acendendo a noite sem pedir nada',
        'além de um instante para os ver.',
      ],
    },
    {
      titulo: 'Em sintonia',
      layout: 'fundo',
      imagem: 'poemas/nossa_foto_maos_dadas.jpg',
      duracao: 9000,
      linhas: [
        'Mãos dadas, sem pressa de chegar a casa,',
        'partilhando o caminho e o silêncio.',
        'Como dois dispositivos na mesma rede,',
        'encontramos um sinal tranquilo',
        'no simples prazer de estarmos perto um do amor com amor.',
      ],
    },
    {
      titulo: 'Aprender com cuidado',
      layout: 'topo',
      imagem: 'poemas/foto_da_carta_origame_que_dei.jpg',
      duracao: 9000,
      linhas: [
        'Se errei, quero aprender com isso,',
        'e mostrar a mudança com atitudes.',
        'Como quem depura um programa,',
        'revejo cada falha e procuro fazer melhor.',
        'Sem pressa e sem exigir respostas:',
        'só respeito, honestidade e cuidado,',
        'um passo de cada vez.',
      ],
    },
  ],
};
