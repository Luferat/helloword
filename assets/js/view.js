/**
 * view.js
 **/

// Elementos HTML para interação
const comments = document.getElementById('comments');

// Define um observador para obter o status de autenticação em tempo real
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se usuário está logado...
        commentIsLogged(user);
        // Obtém todos os comentários na forma de JSON e converte para objeto
        fetch(`_comments.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                // Detecta o status da resposta
                if (data.status == 'success')
                    // Chama a função que vai gerar a view
                    generateView(data);
                else
                    comments.innerHTML += '<p class="red center">Oooops!<br>Falha ao obter comentários. Por favor, tente mais tarde.</p>';
            })
            .catch(error => {
                // Se ocorreu erro, exibe na view
                comments.innerHTML += '<p class="red center">Oooops!<br>Falha ao obter comentários. Por favor, tente mais tarde.</p>';
                console.error('Erro ao obter JSON:', error);
            });
    } else {
        // Se usuário NÃO está logado...
        commentNotLogged();
    }
});

// Obtém o id da URL
var params = new URLSearchParams(window.location.search);
var id = parseInt(params.get('id'));

// Título da sessão
comments.innerHTML = `
    <hr class="block-divider">
    <h2>Comentários</h2>
`;

// Se usuário está logado
function commentIsLogged(user) {
    comments.innerHTML += `
<form method="post" name="commentForm">
    <p>
        <textarea name="content" id="content" placeholder="Digite seu comentário"></textarea>
        <button type="submit">Enviar</button>
    </p>
</form>    
    `;
}

// Se usuário não está logado
function commentNotLogged() {
    comments.innerHTML += `
<p><a href="login.php?ref=${location.href}">Logue-se</a> para comentar.</p>
    `;
}

function generateView(data) {
    // Divisor
    comments.innerHTML += `<hr class="divider">`;

    // Exibe a quantidade de comentários
    if (data.total_results == 0)
        comments.innerHTML += `<h5>Nenhum comentário</h5><p>Seja o(a) primeiro(a) a comentar!</p>`;
    else if (data.total_results == 1)
        comments.innerHTML += `<h5>1 comentário</h5>`;
    else
        comments.innerHTML += `<h5>${data.total_results} comentários</h5>`;

    // Se tem comentários, itera cada comentário
    if (data.total_results > 0) {
        data.data.forEach(cmt => {
            // Recebe dados do usuário do Realtime Database, identificado pelo Id
            // Referências: https://firebase.google.com/docs/database/web/read-and-write?hl=pt-br
            var userRef = firebase.database().ref('users/' + cmt.cmt_social_id);
            userRef.on('value', (snapshot) => {
                const userData = snapshot.val();
                comments.innerHTML += `
<div class="comment-block">
    <div class="comment-header">
        <img src="${userData.photoURL}" alt="${userData.displayName}">
        <small>Por ${userData.displayName} em ${brDate(cmt.cmt_date)}.</small>
    </div>
    <div class="comment-content">${cmt.cmt_content}</div>
</div>
                `;
            });
        });
    }
}

// Retorna a data formatada em pt-BR
function brDate(ISOdate) {
    const parts = ISOdate.split(' ');
    const date = parts[0].split('-');
    return `${date[2]}/${date[1]}/${date[0]} às ${parts[1]}`;
}