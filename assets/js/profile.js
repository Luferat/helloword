// Identifica elementos do HTML para interação
const userName = document.getElementById('userName');
const btnProfile = document.getElementById('btnProfile');
const btnLogout = document.getElementById('btnLogout');

// Define um observador para obter o status de autenticação em tempo real
// Referências: https://firebase.google.com/docs/auth/web/start?hl=pt&authuser=0#web-namespaced-api
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se usuário está logado...

        // Exibe o primeiro nome do usuário na página
        userName.innerHTML = user.displayName.split(' ')[0];

        // Monitora cliques no botão de perfil
        btnProfile.addEventListener('click', goProfile);

        // Monitora cliques no botão de logout
        btnLogout.addEventListener('click', logout);

    } else {
        // Se usuário NÃO está logado, redireciona ele para a página de login
        location.href = 'login.php';
    }
});

// Função que exibe o perfil do usuário o Google
function goProfile() {
    window.open('https://myaccount.google.com/', '_blank');
}

// Função para fazer logout do usuário neste dispositivo
// Referências: https://firebase.google.com/docs/auth/web/password-auth?hl=pt-br#next_steps
function logout() {
    firebase.auth().signOut().then(() => {
        // Se fez logout, exibe a página inicial
        location.href = 'index.php';
    }).catch((error) => {
        // Se o logout falhou, exibe aviso na view
        authError.innerHTML = 'Ocorreu um erro na tentativa de logout. Por favor, limpe os dados do navegador ou tente mais tarde...';
        // Exibe erro completo no console            
        console.error(error);
    });
}