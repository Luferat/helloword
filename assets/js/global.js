/**
 * Configurações do Firebase
 * 
 * Lembre-se de substituir as configurações abaixo pelas que foram fornecidas pelo seu próprio Firebase.
 **/ 
const firebaseConfig = {
    apiKey: 'AIzaSyB_Dk7S89N7wQk_o3cntUH5-7v2IWd_P8Q',
    authDomain: 'hellowordblog.firebaseapp.com',
    projectId: 'hellowordblog',
    storageBucket: 'hellowordblog.appspot.com',
    messagingSenderId: '238708085735',
    appId: '1:238708085735:web:8c7fdcd4b63159275fe342'
};

// Inicializa o Firebase
const firebaseApp = firebase.initializeApp(firebaseConfig);

// Inicializa o Authentication
const auth = firebaseApp.auth();

// Define o provedor de autenticação
var provider = new firebase.auth.GoogleAuthProvider();

// Identifica elementos do HTML para interação
const authNav = document.getElementById('authNav');
const authNavIcon = document.getElementById('authNavIcon');
const authNavImg = document.getElementById('authNavImg');
const authNavLabel = document.getElementById('authNavLabel');

// Define um observador para obter o status de autenticação em tempo real
// Use este observador sempre que precisar validar a condição de um usuário autenticado
// Referências: https://firebase.google.com/docs/auth/web/start?hl=pt&authuser=0#web-namespaced-api
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se usuário está logado...
        // Executa a função que exibe a situação de logado na view
        authLogged(user);
    } else {
        // Se usuário NÃO está logado...
        // Executa a função que exibe a situação de não logado na view
        authNotLogged();
    }
});

// Exibe a situação de logado na view
function authLogged(user) {

    // URL do Link aponta para a página de perfil
    authNav.setAttribute('href', 'profile.php');
    authNav.setAttribute('title', `Perfil de ${user.displayName}.`);

    // Remove o ícone de login
    authNavIcon.style.display = 'none';

    // Exibe a imagem do usuário
    authNavImg.setAttribute('src', user.photoURL);
    authNavImg.setAttribute('alt', user.displayName);
    authNavImg.style.display = 'inline';

    // Altera o texto da label
    authNavLabel.innerHTML = 'Perfil';
}

// Exibe a situação de não logado na view
function authNotLogged() {

    // URL do Link aponta para a página de login
    authNav.setAttribute('href', 'login.php');
    authNav.setAttribute('title', 'Login');

    // Remove a imagem
    authNavImg.setAttribute('src', '');
    authNavImg.setAttribute('alt', '');
    authNavImg.style.display = 'none';

    // Exibe o ícone de login
    authNavIcon.style.display = 'inline';

    // Altera o texto da label
    authNavLabel.innerHTML = 'Login';
}