/**
 * contacts.js
 **/

// Obtém elementos para interação
const btnClose = document.getElementById('closeme');
const frmError = document.getElementById('error');
const formName = document.getElementById('name');
const formEmail = document.getElementById('email');

// Só executa as ações quando o elemento existe no documento
if (document.body.contains(frmError)) {
    // Monitora cliques em 'btnClose'
    btnClose.addEventListener('click', closeMe);
    // Timer para fechar em 'seconds' segundos
    // Se não quise usar, comente as linhas abaixo
    const seconds = 5;
    // setTimeout(closeMe, seconds * 1000);
}

// Define um observador para obter o status de autenticação em tempo real
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se usuário está logado, exibe os dados dele no formulário
        formName.value = user.displayName;
        formEmail.value = user.email;
    }
});

// Função que fecha a caixa de erro do PHP
function closeMe() {
    frmError.style.display = 'none';
}
