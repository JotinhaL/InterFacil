document.getElementById("excluir").addEventListener("click", excluirUsuario);

window.onload = function(){
    const options = {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
    };

    let email = sessionStorage.getItem("email");

    fetch("http://localhost/ppi/php/perfil?email="+ email, options)
        .then(response => response.json())
        .then((data) => {
            if(!data.success){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error.errors ?? "Houve um erro no servidor. Tente novamente mais tarde!",
                });
                return;
            }

            console.log(data);

            let nome = document.getElementById("nome");
            let email = document.getElementById("email");
            let nascimento = document.getElementById("nascimento");
            let experiencia = document.getElementById("experiencia");
            let ensino = document.getElementById("ensino");
            let idiomas = document.getElementById("idiomas");
            let id = document.getElementById("id");
            let dataFormatada = new Date(data.user.dataNascimento);

            nome.textContent = data.user.nome;
            email.textContent = data.user.email;
            nascimento.textContent = dataFormatada.toLocaleDateString();
            experiencia.textContent = data.user.experiencia;
            ensino.textContent = `${data.user.nivelEnsino} (${data.user.statusEnsino})`;
            id.value = data.user.id;

            for(let idioma of data.user.idiomas){
                let span = document.createElement("span");
                span.className = "badge text-bg-light align-middle";
                span.innerHTML = `${idioma.idioma} (${idioma.fluencia})`;
                idiomas.appendChild(span);
            }
        });
}

function isNullOrEmpty(string){
    return (string == null || string.trim() == "");
}

async function sha512(str) {
    return crypto.subtle.digest("SHA-512", new TextEncoder("utf-8").encode(str)).then(buf => {
      return Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
    });
}

function excluirUsuario(ev){
    ev.preventDefault();

    let id = document.getElementById("id").value;

    const body = {
        id
    }

    const options = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    };

    fetch(`http://localhost/ppi/php/excluir`, options)
        .then(response => response.json())
        .then((data) => {
            if(!data.success){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error.errors ?? "Houve um erro no servidor. Tente novamente mais tarde!",
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: "Usuário excluido com sucesso!",
            });
            window.location = "../index.html";
        });
}