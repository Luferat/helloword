// Referência dos elementos HTML
const commentBox = document.getElementById('commentBox');

// Monitora se houve mudanças na autenticação do usuário
firebase.auth().onAuthStateChanged((user) => {
    if (user) {
        // Se alguém se logou, faça isso:
        showCommentField(user);
    } else {
        // Se alguém deslogou, faça isso:
        showLoginLink();
    }
});

function showCommentField(user) {
    console.log(user);
}

function showLoginLink() {
    commentBox.innerHTML = `
    <p><a href="login.php?ref=${location.href}%23comment">
        Logue-se</a> para comentar.
    </p>
    `;
}