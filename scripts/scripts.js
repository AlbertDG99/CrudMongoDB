function validar(Form) {
    let formulario = document.getElementById(Form); //Formulario
    let datos = formulario.getElementsByTagName("input"); //Inputs dentro del formulario
     plataforma = document.getElementsByTagName("select")[0]; //Select del tipo de PC
    let rating = document.getElementsByName("valoracion");
     comentario = document.getElementById("comentario");
    let listaErrores=document.getElementById("listaErrores"); //Div en el que se mostrará la lista de errores
    let ok = true; //Booleana para comprobar que todos los campos están ccorrectos.
    let estrella=false; //Booleana para saber si has marcado alguna estrella
    let error = "<ul>";
    //EXPRESION REGULAR
    let LetyNum = new RegExp(/^[A-Za-z0-9\s.]{1,25}$/);
    let coment = new RegExp(/^[A-Za-z0-9\s.]{1,70}$/);//Expresion regular que contempla letras, numeros espacios y . Y una longitud de 1 a 100 caracteres. PENDIENTE REVISAR
    DefaultBorders(datos); //Llamamos a la función para poner los bordes de los campos en su color inicial
//----------------------PLATAFOTMA
    if (plataforma.value== 0 && plataforma.innerText=="Selecciona una Plataforma" ) { //Si está en el value 0 (Por defecto) nos muestra error
        plataforma.style.border="1px solid red";
        plataforma.classList.add('animated', 'flash');
        error += "<li> Debes seleccionar una Plataforma</li>";
        ok=false;
    }

    if(comentario.value.length>70){
        comentario.style.border="1px solid red";
        comentario.classList.add('animated', 'flash');
        error += "<li>Longitud Maxima de comentario Superada</li>";
        ok=false;
    }


    for (let i = 0; i < datos.length - 3; i++) { //Ponemos datos.length-2 para que solo cubra los datos deseados.
        if(i==2) {
            if (datos[i].value == "") {
                datos[i].style.borderColor = "red";
                datos[i].classList.add('animated', 'flash')
                error += "<li> El campo "+ datos[i].placeholder + " contiene errores.</li>";
                ok = false; //Ponemos OK afalse para que no se envie el form.
            }
        }
       else if (!(LetyNum.test(datos[i].value))) { //Si tiene caracteres inapropiados da error.
            if(i!=8) {
            datos[i].style.borderColor = "red";
            datos[i].classList.add('animated', 'flash')

                error += "<li> El campo " + datos[i].placeholder + " contiene errores.</li>";
                ok = false; //Ponemos OK afalse para que no se envie el form.
            }
        }
    }
    //---------------------RATING OBLIGATORIO----------------------
    for (let i = 0; i <rating.length ; i++) {
        if(rating[i].checked)
            estrella=true;
    }
    if(!estrella){
        error+="<li> Debes añadir una valoración</li>"
        document.getElementById("Estrellas").style.border="2px solid red";
        document.getElementById("Estrellas").classList.add('animated', 'flash');
        ok=false;
    }
    if (ok) // Sitodo está correcto se envia el form.
        formulario.submit();
    else { //De otra manera nos muestra el div con los errores
        listaErrores.innerHTML = error;
        listaErrores.style.display="block";
        listaErrores.scrollIntoView({behavior: 'smooth' });
    }

}


function DefaultBorders(datos) { //Función para poner los bordes de los elementos en su color inicial cada vez que demos a Enviar, para que se puedan corregir errores y se elimine el borde rojo.
    for (let i = 0; i < datos.length - 3; i++) {
        datos[i].style.borderColor = "initial";
    }
    plataforma.style.borderColor = "grey";
    comentario.style.borderColor = "initial";
    document.getElementById("Estrellas").style.border="initial";
}

 function limpiarBuscador() {
   let buscador= document.getElementById("Buscador");
buscador.getElementsByTagName("input")[0].value="";
buscador.submit();
}

function masInformacion(id){
document.getElementById(id+'A').style='display: none !important';
    document.getElementById(id+'B').style.display= "flex";
}
function cerrarInformacion(id){
    document.getElementById(id+'B').style='display: none !important';
    document.getElementById(id+'A').style.display= "flex";
}

//-----------Validaciones Login--------------------------
function InputReset(datos) {//Pone todos los inputs en su color original para ello necesita

    for (var i = 0; i < datos.length; i++) {

        datos[i].style.borderColor = 'initial';
    }

}

function validarRegistro() {
    var formularioRegistro=document.getElementById('formularioRegistro');
    var datosRegistro=formularioRegistro.getElementsByTagName('input');
    var todoOK=true;//Comprueba que todo el formulario este validado
    var Vemail=/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/;
    var Vcontraseña=/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;

    InputReset(datosRegistro);
//datos[0]=nombre,datos[1]=contraseña,datos[2]=email


// NOMBRE:no puede ser nulo, no puede tener mas de veinte caracteres y no puede contener inserciones sql
    if (datosRegistro[0].value == "" || datosRegistro[0].value.length > 20) {
        datosRegistro[0].style.border="1px solid red";
        todoOK = false;

    }
//contraseña:no puede ser nulo,no puede tener mas de 20 caracteres
    if (datosRegistro[1].value == "" || Vcontraseña.test(datosRegistro[1].value)==false) {
        datosRegistro[1].style.border="1px solid red";
        todoOK = false;

    }
    if (datosRegistro[2].value == "" || Vemail.test(datosRegistro[2].value)==false) {
        datosRegistro[2].style.border="1px solid red";
        todoOK = false;

    }


    if(todoOK){
        formularioRegistro.submit();
    }

}


function validarLogin(){
    var formularioLogin=document.getElementById('formularioLogin');
    var datos=formularioLogin.getElementsByTagName('input');
    var todoOK=true;//Comprueba que todo el formulario este validado
    var Vcontraseña=/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
    InputReset(datos);
//datos[0]=nombre,datos[1]=contraseña



    if (datos[0].value == "" || datos[0].value.length > 20) {
        datos[0].style.borderColor = 'red';
        todoOK = false;
    }


//Este no puede ser nulo , no puede tener mas de 16 caracteres,la contraseña debe tener al menos 8 caracteres y no puede contener inserciones sql
    if (datos[1].value==""||datos[1].value.length<8||Vcontraseña.test(datos[1].value)==false){
        datos[1].style.borderColor = 'red';

    }

    if(todoOK){
        document.getElementById('formularioLogin').submit();
    }

}

function AbrirRegistro() {
    document.getElementById("registro").classList.remove("d-none");
    document.getElementById("FormuLogin").classList.add("d-none");

}
function CerrarRegistro() {
    document.getElementById("FormuLogin").classList.remove("d-none");
    document.getElementById("registro").classList.add("d-none");

}


//----------------------------AJAX BORRAR---------------------------------

function ajax() {
    try {
        req = new XMLHttpRequest();
    } catch(err1) {
        try {
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                req = false;
            }
        }
    }
    return req;
}
var borrar = new ajax();
function BorrarImagen(id) {
if(confirm("¿Seguro que deseas borrar la imagen?")) {
    var myurl = 'llamadas/borrarImagen.php';
    myRand = parseInt(Math.random() * 999999999999999);
    modurl = myurl + '?rand=' + myRand + '&id=' + id;
    borrar.open("GET", modurl, true);
    borrar.onreadystatechange = borrarImagenResponse;
    borrar.send(null);
}
}



function borrarImagenResponse() {

    if (borrar.readyState == 4) {
        if(borrar.status == 200) {

            var imagen = borrar.responseText;

            document.getElementById('imagen').innerHTML=imagen;

        }
    }
}



function borrarJuego(id){
    if(confirm("¿Seguro que deseas borrar el videojuego?")) {
        var myurl = 'llamadas/borrarJuego.php';
        myRand = parseInt(Math.random() * 999999999999999);
        modurl = myurl + '?rand=' + myRand + '&id=' + id;
        borrar.open("GET", modurl, true);
        borrar.onreadystatechange = borrarJuegoResponse;
        borrar.send(null);
    }

}
function borrarJuegoResponse() {

    if (borrar.readyState == 4) {
        if(borrar.status == 200) {

            var juego = borrar.responseText;

            document.getElementById('catalogo').innerHTML=juego;

        }
    }
}

buscar= new ajax();

 buscador = document.getElementById("buscador");
document.addEventListener("keypress", function(event) {
    if (event.code === 'Enter') {
        buscador = document.getElementById("buscador");
        buscarJuego(buscador.value);
    }
});

function buscarJuego(busqueda){

        var myurl = 'llamadas/buscarJuego.php';
        myRand = parseInt(Math.random() * 999999999999999);
        modurl = myurl + '?rand=' + myRand + '&busqueda=' + busqueda;
    buscar.open("GET", modurl, true);
    buscar.onreadystatechange = buscarJuegoResponse;
    buscar.send(null);

}
function buscarJuegoResponse() {
    if (buscar.readyState == 4) {
        if(buscar.status == 200) {

            var juego = buscar.responseText;

            document.getElementById('catalogo').innerHTML=juego;

        }
    }
}