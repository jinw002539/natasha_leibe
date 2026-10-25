# Para ti — site estático (HTML + CSS + JS)

Não precisa de PHP nem de servidor especial: funciona em qualquer hospedagem
(GitHub Pages, Netlify, Vercel, Cloudflare Pages, hospedagem comum, etc.).

## Páginas
index.html       entrada, com o botão "Amo-te Natasha"
inicio.html      menu: Mensagens, Poemas, Galeria
mensagens.html   mensagens em ecrã inteiro
poemas.html      poemas com foto por trás ou por cima
galeria.html     álbuns, grelha, páginas e ampliação

## Onde editar
dados/conteudo.js   todo o texto: botão, mensagens, poemas, legendas, álbuns, intervalo
imagens/            as fotos (galeria/<album>/, poemas/, mensagens/)

## Depois de mexer nas fotos
    pip install pillow      (só a primeira vez)
    python gerar-fotos.py

Cria as miniaturas em imagens/miniaturas/ e escreve dados/fotos.js.
Sem correr isto, o site não sabe que fotos existem.

## Publicar
Envia TUDO para a hospedagem: os .html, assets/, dados/ e imagens/ (incluindo imagens/miniaturas).
As fotos originais só são necessárias se quiseres guardá-las lá; o site usa as miniaturas.
Apaga da hospedagem os ficheiros antigos em PHP (index.php, inicio.php, includes/, config/, thumb.php, cache/, .htaccess).
