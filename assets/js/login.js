// Seleciona elementos do HTML para interação
const authError = document.getElementById('authError');
const btnLogin = document.getElementById('btnLogin');

// Monitora clique no botão de login e chama a função login()
btnLogin.addEventListener('click', login);

// Função de login
function login() {
    firebase.auth()
        .signInWithPopup(provider)
        .then((result) => {
            // Se o login foi bem sucedido...
            // Obtém o parâmetro do link da página
            var searchParams = new URLSearchParams(window.location.search);
            // Obtém o valor do parâmetro "ref"
            var refValue = searchParams.get('ref');
            // Redireciona para a página de origem
            location.href = refValue ? refValue : 'index.php';
        }).catch((error) => {
            // Se o login falhou, exibe aviso na view
            authError.innerHTML = 'Ocorreu um erro na tentativa de login. Por favor, tente mais tarde...';
            // Exibe erro completo no console            
            console.error(error);
        });
}