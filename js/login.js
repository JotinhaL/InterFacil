document.getElementById("login").addEventListener("click", login);

async function login(ev){
    ev.preventDefault();

    const email_input = document.getElementById("email");
    const senha_input = document.getElementById("senha");

    if(isNullOrEmpty(email_input.value) || isNullOrEmpty(senha_input.value)){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: "Email e/ou Senha em branco!",
        });
        return;
    }

    let senha_encriptada = await sha512(senha_input.value);

    const options = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
            email: email_input.value,
            senha: senha_encriptada
        }),
    };

    fetch(`http://localhost/ppi/php/login`, options)
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

            sessionStorage.setItem("email", email_input.value);
            window.location = "./area_privada/index.html";
        });
}

function isNullOrEmpty(string){
    return (string == null || string.trim() == "");
}

function sha512(str) {
    return crypto.subtle.digest("SHA-512", new TextEncoder("utf-8").encode(str)).then(buf => {
      return Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
    });
}