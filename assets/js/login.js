// Referência dos elementos HTML
const btnLogin = document.getElementById('btnLogin');
const loginError = document.getElementById('loginError');

// Monitora se houve mudanças na autenticação do usuário
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Grava / atualiza dados do usuário no Realtime Database
        firebase.database().ref('users/' + user.uid).set({
            'date': now(),
            'displayName': user.displayName,
            'email': user.email,
            'photoURL': user.photoURL,
            'providerId': user.providerData[0].providerId
        }).then(() => {
            // Obtém o parâmetro do link da página
            var searchParams = new URLSearchParams(window.location.search);
            // Obtém o valor do parâmetro "ref"
            var refValue = searchParams.get('ref');
            // Redireciona para a página de origem
            location.href = refValue ? refValue : 'index.php';
        }).catch((error) => {
            // Se o login falhou, exibe aviso na view
            loginError.innerHTML = 'Ocorreu um erro na tentativa de login. Por favor, tente mais tarde...';
            // Exibe erro completo no console            
            console.error(error);
        });;
    } else {
        // Se alguém deslogou, faça isso...
        // Monitorar cliques no botão de login
        btnLogin.addEventListener('click', login);
    }
});

// Função para fazer login
function login() {
    // Referência ao provedor de login
    const provider = new firebase.auth.GoogleAuthProvider();
    // Login do usuário na janela popup
    firebase.auth().signInWithPopup(provider);
}
