window.onload = function(){
    const options = {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
    };

    let email = sessionStorage.getItem("email");

    fetch("http://localhost/ppi/php/getVagas", options)
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

            for(let vaga of data.vagas){
                let pool_vagas = document.getElementById("pool_vagas");

                let div1 = document.createElement("div");
                let div2 = document.createElement("div");
                let div3 = document.createElement("div");
                let h5 = document.createElement("h5");
                let p1 = document.createElement("p");
                let p2 = document.createElement("p");
                let pool_idiomas = document.createElement("span");

                div1.className = "col-md-6";
                div2.className = "card mb-3";
                div3.className = "card-body";
                h5.className = "card-title";
                p1.className = "card-text";
                pool_idiomas.id = "pool_idiomas";

                p1.textContent = vaga.nome;
                h5.textContent = vaga.descricao;
                p2.textContent = "Idiomas: ";

                for(let idioma of vaga.idiomas){
                    let span = document.createElement("span");
                    span.className = "badge text-bg-light align-middle";
                    span.innerHTML = `${idioma.idioma} (${idioma.fluencia})`;

                    pool_idiomas.appendChild(span);
                }
            
                div3.appendChild(h5);
                div3.appendChild(p1);
                div3.appendChild(p2);
                
                p2.appendChild(pool_idiomas);

                div2.appendChild(div3);
                
                div1.appendChild(div2);

                pool_vagas.appendChild(div1);
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