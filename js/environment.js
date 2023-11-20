const urlDev = "";
const urlHomolog = "";
const urlProd = "";

const enviroment = "dev";
// const enviroment =  "homolog";
// const enviroment =  "prod";

let prefixUrl = "";

// mudar conforme o local desejado para subir
switch(enviroment){
    case "dev":
        prefixUrl = "http://localhost/ppi/php";
    break;
    case "homolog":
        prefixUrl = "http://localhost/php/";
    break;
    case "prod":
        prefixUrl = "http://localhost/php/";
    break;
}

export const config = {
    enviroment,
    prefixUrl,
}