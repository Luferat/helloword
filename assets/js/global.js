/**
 * Chaves de configuração do Firebase
 * Copie aqui as suas prórias chaves do Firebase.
 **/
const firebaseConfig = {
    apiKey: "AIzaSyB_Dk7S89N7wQk_o3cntUH5-7v2IWd_P8Q",
    authDomain: "hellowordblog.firebaseapp.com",
    databaseURL: "https://hellowordblog-default-rtdb.firebaseio.com",
    projectId: "hellowordblog",
    storageBucket: "hellowordblog.appspot.com",
    messagingSenderId: "238708085735",
    appId: "1:238708085735:web:8c7fdcd4b63159275fe342"
};

// Inicializa o Firebase
firebase.initializeApp(firebaseConfig);

// Inicializa o Firebase Authentication
const auth = firebase.auth();

// Identifica elementos do HTML para interação
const userAccess = document.getElementById('userAccess');
const userImg = document.getElementById('userImg');
const userIcon = document.getElementById('userIcon');
const userLabel = document.getElementById('userLabel');

// Monitora se houve mudanças na autenticação do usuário
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se alguém se logou, faça isso:
        // Chama a função que trata o usuário logado
        isLogged(user);
    } else {
        // Se alguém deslogou, faça isso:
        // Chama a função que trata o usuário NÃO logado
        notLogged();
    }
});

// Evita o reenvio dos formulários ao atualizar a página
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Função que trata o usuário logado
function isLogged(user) {
    // Altera href do link
    userAccess.href = `profile.php?ref=${location.href}`;
    // Altera title do link
    userAccess.title = `Ver perfil de ${user.displayName}`;
    // Oculta o ícone de login
    userIcon.style.display = 'none';
    // Define os atributos da imagem conforme dados do usuário
    userImg.src = user.photoURL;
    userImg.alt = user.displayName;
    // Mostrar a imagem do usuário
    userImg.style.display = 'inline';
    // Altera a label para entrar
    userLabel.innerHTML = 'Perfil';
}

// Função que trata o usuário NÃO logado 
function notLogged() {
    // Altera href do link
    userAccess.href = `login.php?ref=${location.href}`;
    // Altera title do link
    userAccess.title = 'Logue-se';
    // Oculta a imagem do usuário
    userImg.style.display = 'none';
    // Mostra o ícone de login
    userIcon.style.display = 'inline';
    // Altera a label para entrar
    userLabel.innerHTML = 'Entrar';
}

// Função que converte datas do Firebase (timestamp) para pt-BR
function convertTimestampToDateFormat(jsFormatedDate) {
    const date = new Date(jsFormatedDate);
    // padStart(a, b) preenche o começo da string com "b" até que ela tenha o comprimento "a"
    // Referências: https://www.w3schools.com/jsref/jsref_string_padstart.asp
    const day = date.getDate().toString().padStart(2, '0');
    // Os meses estão em um array onde janeiro = é [0], por isso, + 1
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear();
    const hour = date.getHours().toString().padStart(2, '0');
    const min = date.getMinutes().toString().padStart(2, '0');
    return `${day}/${month}/${year} às ${hour}:${min}`;
}

// Função que remove espaços antes e depois, códigos JavaScript e tags HTML da string argumento
function stripTags(htmlText) {
    // Cria um novo elemento <div> no documento
    let div = document.createElement('div');
    // Remove JavaScript e insere a string de argumento no novo elemento
    div.innerHTML = htmlText.trim().replace(/<script>.*<\/script>/, '');
    // Retorna somente os textos do elemento, sem HTML
    return div.textContent;
}

// Sanitiza e bloqueia envio do formulário de buscas
function formSearchValidate(searchFieldId) {
    // Obtém e sanitiza valor do campo de busca
    var searchTerm = stripTags(document.getElementById(searchFieldId).value.trim());
    // Se o campo está vazio:
    if (searchTerm === "") {
        // Envia alerta
        alert("Por favor, preencha o campo de busca.");
        // Impede o envio do formulário
        return false;
    }
    // Permite o envio do formulário
    return true;
}
