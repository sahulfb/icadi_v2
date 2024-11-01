/* function cargarR(form){
  grecaptcha.ready(function() {
        grecaptcha.execute('6LdydnEqAAAAAK9Nan8b0jSvwfT7WsMEl_GaSIhw', {action: 'formulario'}).then(function(token) {
            let input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'token');
            input.setAttribute('value', token);
            form.appendChild(input);
                form.submit();
        });
});
}

submit=document.querySelector("#btnSubmit");
form_diplomas=document.querySelector("#form__diplomas");

if(submit){
    submit.addEventListener("click",function(e){
        e.preventDefault();
       cargarR(form_diplomas);
    })
} */