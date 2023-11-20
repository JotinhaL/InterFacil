let nextGraduacaoId = 1;
let idiomas = [];
document.getElementById("edit").addEventListener("click", editarUsuario);

window.onload = function(){
    const options = {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
    };

    fetch(`http://localhost/ppi/php/getTipoUsuario`, options)
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

            let selectTipoUsuario = document.getElementById("tipo_usuario");

            for(let item of data.data){
                let option = document.createElement("option");
                option.textContent = item.nome;
                option.value = item.id;

                selectTipoUsuario.appendChild(option);
            }
        });

    fetch(`http://localhost/ppi/php/getNivelEnsino`, options)
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

            let nivelEnsino = document.getElementById("nivelEnsino");

            for(let item of data.data){
                let option = document.createElement("option");
                option.textContent = item.nome;
                option.value = item.id;

                nivelEnsino.appendChild(option);
            }
        });

    fetch(`http://localhost/ppi/php/getStatusEnsino`, options)
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

        let selectstatusEnsino = document.getElementById("statusEnsino");

        for(let item of data.data){
            let option = document.createElement("option");
            option.textContent = item.nome;
            option.value = item.id;

            selectstatusEnsino.appendChild(option);
        }
    });

    fetch(`http://localhost/ppi/php/getIdiomas`, options)
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

        let idiomas = document.getElementById("idiomas");

        for(let item of data.data){
            let option = document.createElement("option");
            option.textContent = item.nome;
            option.value = item.id;

            idiomas.appendChild(option);
        }
    });

    fetch(`http://localhost/ppi/php/getFluencia`, options)
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

        let fluencias = document.getElementById("fluencia");

        for(let item of data.data){
            let option = document.createElement("option");
            option.textContent = item.nome;
            option.value = item.id;;

            fluencias.appendChild(option);
        }
    });

    let email = sessionStorage.getItem("email");

    fetch("http://localhost/ppi/php/getperfil?email="+ email, options)
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

            let id_tipo_usuario = document.getElementById("tipo_usuario");
            let id = document.getElementById("id");
            let nome = document.getElementById("nome");
            let email = document.getElementById("email");
            let nascimento = document.getElementById("dataNascimento");
            let experiencia = document.getElementById("experiencia");
            let ensino = document.getElementById("nivelEnsino");
            let status = document.getElementById("statusEnsino");
            let idi = document.getElementById("pool_idiomas");

            let dataFormatada = new Date(data.user.dataNascimento);

            id_tipo_usuario.value = data.user.id_tipo_usuario;
            nome.value = data.user.nome;
            email.value = data.user.email;
            nascimento.value = dataFormatada.toDateString();
            experiencia.value = data.user.experiencia;
            ensino.value = data.user.idNivelEnsino;
            status.value = data.user.idStatusEnsino;
            id.value = data.user.id;

            for(let idioma of data.user.idiomas){
                idiomas.push({
                    id_idioma : idioma.id_idioma,
                    id_fluencia : idioma.id_fluencia
                });

                const id_tag = `_${idioma.id_idioma}_${idioma.id_fluencia}`;
                let span = document.createElement("span");
                span.className = "badge text-bg-light align-middle";
                span.id = id_tag;
                span.innerHTML = `${idioma.idioma} (${idioma.fluencia}) <i class="bi bi-x-circle" onclick="removeIdioma('${id_tag}')" role="button"></i>`;
                idi.appendChild(span);
            }
        });
}

function adicionarIdioma(){
    const pool_idiomas = document.getElementById("pool_idiomas");

    let selectIdioma = document.querySelector('#idiomas');
    let idioma = selectIdioma.children[selectIdioma.selectedIndex];
    let selectFluencia = document.querySelector('#fluencia');
    let fluencia = selectFluencia.children[selectFluencia.selectedIndex];

    if(isNullOrEmpty(idioma.value) || isNullOrEmpty(fluencia.value)){
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Preencha o idioma e o nivel de fluencia antes de tentar adicionar!',
        });
        return;
    }

    let idioma_ja_adicionado = idiomas.find(i => i.id_idioma == idioma.value);
    if(idioma_ja_adicionado){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Este idioma já foi adicionado!',
        });
        return;
    }

    const id_tag = `_${idioma.value}_${fluencia.value}`;
    let span = document.createElement("span");
    span.className = "badge text-bg-light align-middle";
    span.id = id_tag;
    span.innerHTML = `${idioma.textContent} (${fluencia.textContent}) <i class="bi bi-x-circle" onclick="removeIdioma('${id_tag}')" role="button"></i>`;

    idiomas.push({
        id_idioma : idioma.value,
        id_fluencia : fluencia.value
    });

    pool_idiomas.appendChild(span);

    idioma.removeAttribute("selected");
    idioma.removeAttribute("selected");

    selectIdioma.value = "";
    selectFluencia.value = "";
}

function removeIdioma(id_tag){
    document
        .getElementById("pool_idiomas")
            .removeChild(document.getElementById(id_tag));
    
    let tag = id_tag.split("_");

    let idioma = idiomas.find(i => i.id_idioma == tag[1]);
    idiomas = idiomas.filter(i => i.id_idioma != idioma.id_idioma);
}

async function editarUsuario(ev){
    ev.preventDefault();

    let id = document.getElementById("id").value;
    let tipo_usuario = document.getElementById("tipo_usuario").value;
    let nome = document.getElementById("nome").value;
    let email = document.getElementById("email").value;
    let dataNascimento = document.getElementById("dataNascimento").value;
    let nivelEnsino = document.getElementById("nivelEnsino").value;
    let statusEnsino = document.getElementById("statusEnsino").value;
    let experiencia = document.getElementById("experiencia").value;

    if( isNullOrEmpty(tipo_usuario) ||
        isNullOrEmpty(nome) ||
        isNullOrEmpty(email) ||
        isNullOrEmpty(dataNascimento) ||
        isNullOrEmpty(nivelEnsino) ||
        isNullOrEmpty(statusEnsino) ||
        isNullOrEmpty(experiencia)
    ){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Preencha todos os campos antes de editar o usuário!',
        });
        return;
    }

    //montando um body proprio por ter feito o controle de idiomas via variavel js;
    const body = {
        id,
        tipo_usuario,
        nome,
        email,
        senha : await sha512(senha),
        dataNascimento,
        nivelEnsino,
        statusEnsino,
        experiencia,
        idiomas
    }

    const options = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    };

    fetch(`http://localhost/ppi/php/editar`, options)
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

            window.location = "../area_privada/index.html";
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