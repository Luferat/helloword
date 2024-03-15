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

    // Remove os "hash" da URL para evitar "hash" redundante
    const formAction = location.href.replace(location.hash, '');

    commentBox.innerHTML = `
    <form id="commentForm" method="post" action="${formAction}#comment" onsubmit="sanitizeMeFirst()">
        <input type="hidden" name="social_id" value="${user.uid}">
        <input type="hidden" name="social_name" value="${user.displayName}">
        <input type="hidden" name="social_photo" value="${user.photoURL}">
        <input type="hidden" name="social_email" value="${user.email}">
        <textarea id="txtComment" name="comment" placeholder="Comente aqui!" required minlength="3"></textarea>
        <button type="submit" id="btnCommentSubmit">Enviar</button>    
    </form>
    `;
}

function sanitizeMeFirst() {
    const txtComment = document.getElementById('txtComment');
    txtComment.value = stripTags(txtComment.value);
}

function showLoginLink() {
    commentBox.innerHTML = `
    <p><a href="login.php?ref=${location.href}%23comment">
        Logue-se</a> para comentar.
    </p>
    `;
}
