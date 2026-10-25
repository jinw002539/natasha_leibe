# Recordações

Sistema em PHP com quatro ecrãs: **Início** (menu), **Mensagens**, **Poemas** e **Galeria** (álbuns).
Totalmente responsivo (telemóvel, tablet, computador).

## Estrutura
```
index.php                    router (?p=mensagens | poemas | galeria)
thumb.php                    serve miniaturas (cache em /cache/thumbs)
gerar-miniaturas.php         opcional: pré-gera todas as miniaturas (php gerar-miniaturas.php)
config/conteudo.php          TODO o conteúdo e opções
includes/                    helpers, header, footer, miniaturas
includes/paginas/            inicio, mensagens, poemas, galeria (+ _poema.php)
assets/css, assets/js        estilos e comportamento
imagens/galeria/<album>/     uma pasta por álbum (as novas fotos estão em nossa-historia)
imagens/poemas/              fotos dos poemas
imagens/mensagens/           fotos das mensagens
```

## Como usar
1. Cria pastas em `imagens/galeria/` (uma por álbum) e põe lá as fotos. Nomes com data à frente ficam por ordem. As fotos desta coleção estão agrupadas em `imagens/galeria/nossa-historia/`.
2. Para associar imagens às mensagens e aos poemas, coloca-as também em `imagens/mensagens/` ou `imagens/poemas/` e indica o caminho em `config/conteudo.php`.
3. Edita `config/conteudo.php`: mensagens, poemas (layout 'fundo' ou 'topo'), legendas e títulos dos álbuns. Os poemas desta coleção incluem comparações com conceitos de IT.
4. `php -S localhost:8000` na pasta do projecto e abre http://localhost:8000

## Requisitos
PHP 8.0+ com extensão GD (miniaturas). Sem GD, o site usa as fotos originais (mais pesado).
Pasta `cache/` com permissão de escrita.

## Frameworks (CDN)
Tailwind CSS, Swiper, GSAP, GLightbox.
