
# Configurando o Firebase para o aplicativo

## Sobre
O Firebase é uma plataforma BaaS (Back-end as a Service) com suporte para várias linguagens que pertencente ao Google.

> *Referências: https://en.wikipedia.org/wiki/Firebase*

## Entrando e criando um projeto

1. Acesse o site do [Firebase](https://firebase.com) e logue-se com sua conta Google / Gmail;
2. No canto superior direito, clique em "Go to console";
3. Clique em "+ Adicionar projeto";
4. Forneça um nome para o projeto. Este pode usar maiusculas espaços, acentos, etc;
    - Ex.: "Blog HelloWord"
6. Clique em **`[Continuar]`**;
7. Opcionalmente, desmarque a opção "Ativar o Google Analytics neste projeto", pois não usaremos ela agora;
    - *Se necessário, o Google Analytics pode ser ativado depois*
8. Aguarde a preparação do projeto...
9. Clique em **`[Continuar]`** na conclusão.

## Ativando o Authentication
Em nosso aplicativo vamos usar a autenticação por um provedor federado, mais especificamente, o Google. Este provedor já vem pré-configurado por padrão, facilitando o restante das tarefas.
1. No console do projeto recém criado, no menu da esquerda, clique em "Criação" → "Authentication";
2. Clique em **`[Vamos começar]`**;
3. Na lista de "provedores de login", localize o grupo "Outros provedores" e clique em "Google";
4. Marque o botão "Ativar";
5. Logo abaixo, em "E-mail de suporte do projeto", clique na lista e selecione seu e-mail;
6. Clique em **`[Salvar]`**.
Você pode usar outros provedores suportados, mas, tenha em mente que será necessário seguir a documentação para integrar o provedor ao seu Firebase. 
A documentação do Firebase é bem completa e elucidativa...

## Ativando o Realtime Database
O Realtime Database é um banco de dados  NoSQL, em tempo real, que armazena e disponibiliza os dados em uma estrutura JSON. Vamos usá-lo para manter os dados do usuário atualizados mesmo que este não esteja logado.
1.  No console do projeto recém criado, no menu da esquerda, clique em "Criação" → "Relatime Database";
2. Clique em **`[Criar banco de dados]`**;
3. No popup "Configurar banco de dados", em "Opções de banco de dados", apenas clique em **`[Próxima]`**;
4. Ainda em "Configurar banco de dados", em "Regras de segurança", apenas clique em **`[Ativar]`**;
5. Aguarde a criação do banco de dados...
6. No console do "Realtime Database", clique na guia "Regras";
7. Altere as regras com cuidado para que tenhamos:
```JSON
{
  "rules": {
    ".read": true,
    ".write": "auth.uid !== null",
  }
}
```
8. Clique em **`[Publicar]`**.

## Criando um aplicativo
Para que nosso aplicativo Web "converse" com as APIs do Firebase, precisamos implementar um aplicativo no serviço, seguindo os passos:
1. No topo do menu da esquerda, clique em "Visão geral do projeto";
2. Abaixo do nome do projeto, clique no símbolo da Web **`(</>)`**;
3. Forneça um "Apelido do app". Use, preferencialmente, letras minúsculas, números e símbolos básicos, respeitando as regras da Web;
4. Clique em **`[Registrar app]`**;
5. Selecione e copie o código para uso no aplicativo front-end;
6. Clique em **`[Continuar no console]`**.

> Se necessário, você também pode obter as configurações do aplicativo clicando na engrenagem ao lado de "Visão geral do projeto" e clicando em "Configurações do projeto".

## Implementando
O Firebase fornece uma documentação bastante sólida e atualizada, já devidamente traduzida. Você pode, inclusive, implementar outros recursos e serviços da plataforma de forma gratuita e/ou paga.

 - [Documentação do Firebase](https://firebase.google.com/docs/?hl=pt)

Por hora, siga os procedimentos e orientações do instrutor para integrar e desenvolver o Firebase no aplicativo de trabalho.