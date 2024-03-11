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
            // Se o login foi bem sucedido, redireciona para a home
            location.href = 'index.php';
        }).catch((error) => {
            // Se o login falhou, exibe aviso na view
            authError.innerHTML = 'Ocorreu um erro na tentativa de login. Por favor, tente mais tarde...';
            // Exibe erro completo no console            
            console.error(error);
        });
}