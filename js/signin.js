let nextGraduacaoId = 1;
let idiomas = [];
document.getElementById("signin").addEventListener("click", cadastrarUsuario);

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
}

function adicionarGraduacao() {
    
    var graduacaoContainer = document.getElementById("graduacao-container");
    var clone = graduacaoContainer.cloneNode(true);

    
    var uniqueIdInput = "graduacao-" + Math.random().toString(36).substring(2, 15);
    var uniqueIdCheckbox = "aindaCursando-" + Math.random().toString(36).substring(2, 15);
    
    
    var input = clone.querySelector("input[type='text']");
    input.id = uniqueIdInput;
    input.value = "";

    var checkbox = clone.querySelector("input[type='checkbox']");
    checkbox.id = uniqueIdCheckbox;

    var label = clone.querySelector("label[for='aindaCursando']");
    label.setAttribute("for", uniqueIdCheckbox);

    graduacaoContainer.parentNode.insertBefore(clone, graduacaoContainer.nextSibling);
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

async function cadastrarUsuario(ev){

    ev.preventDefault();
    let tipo_usuario = document.getElementById("tipo_usuario").value;
    let nome = document.getElementById("nome").value;
    let email = document.getElementById("email").value;
    let senha = document.getElementById("senha").value;
    let dataNascimento = document.getElementById("dataNascimento").value;
    let nivelEnsino = document.getElementById("nivelEnsino").value;
    let statusEnsino = document.getElementById("statusEnsino").value;
    let experiencia = document.getElementById("experiencia").value;

    if( isNullOrEmpty(tipo_usuario) ||
        isNullOrEmpty(nome) ||
        isNullOrEmpty(email) ||
        isNullOrEmpty(senha) ||
        isNullOrEmpty(dataNascimento) ||
        isNullOrEmpty(nivelEnsino) ||
        isNullOrEmpty(statusEnsino) ||
        isNullOrEmpty(experiencia)
    ){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Preencha todos os campos antes de cadastrar o usuário!',
        });
        return;
    }

    //montando um body proprio por ter feito o controle de idiomas via variavel js;
    const body = {
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

    fetch(`http://localhost/ppi/php/signin`, options)
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

            sessionStorage.setItem("email", email);
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