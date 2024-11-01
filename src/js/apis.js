import Swal from 'sweetalert2'

const nom_alumno=document.querySelector(".alumno_id"),
diploma_pas=document.querySelector("#diploma_pas");
if(diploma_pas){
  diploma_pas.addEventListener("keydown", function(e) {
    if (e.code === 'Enter') {
        e.preventDefault();
        if (diploma_pas.value !== '') {
          obtenerAlumno(diploma_pas.value);
      }
    }
  });
}


async function obtenerAlumno(id){
  const url = `/api/alumno?id=${id}`;
  const respuesta= await fetch(url);
  const resultado= await respuesta.json();
  if (resultado.length === 0) {
    nom_alumno.value="";
    Swal.fire({
      title: 'Pasaporte no registrado',
      text: 'ingrese un pasaporte de un alumno registrado',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  } else {
    nom_alumno.value=resultado.nombre;
  } 
}

document.addEventListener('DOMContentLoaded', function () {
  const statusElements = document.querySelectorAll('.color-status');
  
  statusElements.forEach(element => {
    element.addEventListener('click', function () {
      cambiarEstatus(this);
    });
  });
});
window.cambiarEstatus = async function(element) {
  const path = window.location.pathname;
  const id = element.getAttribute('data-id');
  const estatusActual = element.classList.contains('vigente') ? '1' : '0';
  const nuevoEstatus = estatusActual === '1' ? '0' : '1';
  
  const result = await Swal.fire({
    title: '¿Estás seguro?',
    text: `Cambiar el estatus a ${nuevoEstatus === '1' ? 'vigente' : 'anulado'}?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, cambiar',
    cancelButtonText: 'Cancelar',
    customClass: {
      popup: 'custom-popup',
      title: 'custom-title',
      content: 'custom-content',
      confirmButton: 'custom-confirm-button',
      cancelButton: 'custom-cancel-button'
    }
  });
  

  if (result.isConfirmed) {
    try {
      const formData = new FormData();
      formData.append('id', id);
      formData.append('estatus', nuevoEstatus);
      formData.append('ruta', path);
      const response = await fetch('/api/cambiar-status', {
        method: 'POST',
        body: formData
      });
      const dat = await response.json();
      if (!response.ok) {
        throw new Error('No se pudo actualizar el estatus.');
      }
      element.classList.toggle('vigente', nuevoEstatus === '1');
      element.classList.toggle('anulado', nuevoEstatus === '0');
      element.textContent = nuevoEstatus === '1' ? 'vigente' : 'anulado';

      Swal.fire('Actualizado!', 'El estatus ha sido actualizado.', 'success');
    } catch (error) {
      Swal.fire('Error!', error.message, 'error');
    }
  }
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.table__accion--eliminar').forEach(button => {
      button.addEventListener('click', function(event) {
          event.preventDefault();
          const form = this.closest('form');

          Swal.fire({
              title: '¿Estás seguro que deseas eliminar este registro?',
              text: "No podrás revertir esta acción",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
              customClass: {
                confirmButton: 'confirm-button-class',
                cancelButton: 'cancel-button-class'
            }
          }).then((result) => {
              if (result.isConfirmed) {
                  form.submit();
              }
          })
      });
  });
});
