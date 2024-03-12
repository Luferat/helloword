/**
 * login.js
 **/

// Seleciona elementos do HTML para interação
const authError = document.getElementById('authError');
const btnLogin = document.getElementById('btnLogin');

// Obtém o parâmetro do link da página
var searchParams = new URLSearchParams(window.location.search);
// Obtém o valor do parâmetro "ref"
var refValue = searchParams.get('ref');

// Define um observador para obter o status de autenticação em tempo real
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se usuário está logado...
        // Salva / atualiza os dados do usuário no database e redireciona para a origem
        writeUserData(user);
    } else {
        // Se usuário NÃO está logado...
        // Monitora clique no botão de login e chama a função login()
        btnLogin.addEventListener('click', login);
    }
});

// Função de login
function login() {
    firebase.auth()
        .signInWithPopup(provider)
        .then((result) => {
            // Se o login foi bem sucedido...
            // Salva / atualiza os dados do usuário no database
            writeUserData(result.user);
        }).catch((error) => {
            // Se o login falhou, exibe aviso na view
            authError.innerHTML = 'Ocorreu um erro na tentativa de login. Por favor, tente mais tarde...';
            // Exibe erro completo no console            
            console.error(error);
        });
}

/**
 * Função que cria/atualiza os dados do usuário logado no Realtime Database
 * Se é o primeiro login, cria uma entrada para o "uid" do usuário no node 'users'
 * Se já é usuário corrente, atualiza a entrada para o "uid" do usuário no node 'users'
 * Isso permite que os dados do usuário sejam sempre atualizados quando este faz login
 **/
function writeUserData(user) {
    firebase.database().ref('users/' + user.uid).set({
        // Dados do usuário
        displayName: user.displayName,
        email: user.email,
        photoURL: user.photoURL,
        providerId: user.providerData[0].providerId
    }).then(() => {
        // Redireciona para a página de origem
        location.href = refValue ? refValue : 'index.php';
    }).catch((error) => {
        // Se o login falhou, exibe aviso na view
        authError.innerHTML = 'Ocorreu um erro na tentativa de login. Por favor, tente mais tarde...';
        // Exibe erro completo no console            
        console.error(error);
    });
}