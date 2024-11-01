(function(){
    const tipo_dato=document.querySelectorAll(".tipo-dato__label");
    const tipo_validacion=document.querySelector(".tipo-validacion");
    tipo_dato.forEach(dato=>{
        dato.addEventListener("click",function(){
            tipo_dato.forEach(e=> e.classList.remove("activo"));
            dato.classList.add("activo");
            if(dato.getAttribute('for')==="codigo"){
                tipo_validacion.querySelector("#fecha").classList.add("hidden");
                tipo_validacion.querySelector("#codigo").classList.remove("hidden");
                tipo_validacion.querySelector("#fecha").value="";
            }else if(dato.getAttribute('for')==="fecha"){
                tipo_validacion.querySelector("#fecha").value="";
                tipo_validacion.querySelector("#codigo").classList.add("hidden");
                tipo_validacion.querySelector("#fecha").classList.remove("hidden");
                tipo_validacion.querySelector("#codigo").value="";
            }
        })
    })
})();