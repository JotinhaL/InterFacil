let nextGraduacaoId = 1;
let idiomas = [];

document.getElementById("submitVaga").addEventListener("click", cadastrarVaga);

window.onload = function(){
    const options = {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
    };

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

            let selectGraduacao = document.getElementById("nivelEnsino");

            for(let item of data.data){
                let option = document.createElement("option");
                option.textContent = item.nome;
                option.value = item.id;

                selectGraduacao.appendChild(option);
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
            option.value = item.id;

            fluencias.appendChild(option);
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

async function cadastrarVaga(ev){
    ev.preventDefault();

    let nome = document.getElementById("nome").value;
    let descricao = document.getElementById("descricao").value;
    let nivelEnsino = document.getElementById("nivelEnsino").value;
    let statusEnsino = document.getElementById("statusEnsino").value;

    if( isNullOrEmpty(nome) || isNullOrEmpty(descricao) ||
        isNullOrEmpty(nivelEnsino) || isNullOrEmpty(statusEnsino)
    ){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Preencha todos os campos antes de cadastrar a vaga!',
        });
        return;
    }

    //montando um body proprio por ter feito o controle de idiomas via variavel js;
    const body = {
        nome,
        descricao,
        nivelEnsino,
        statusEnsino,
        idiomas
    }

    const options = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    };

    fetch(`http://localhost/ppi/php/cadastrarVaga`, options)
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
                title: 'Oba!',
                text: "Vaga cadastrada com sucesso!",
            });  
        });
}

function isNullOrEmpty(string){
    return (string == null || string.trim() == "");
}