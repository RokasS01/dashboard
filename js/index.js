////////////////////////////////////////////////////////////////////////////////////////////////////////


const openModalSupprButtons = document.querySelectorAll('.openModalSuppr');
const openModalAddButtons = document.querySelectorAll('.openModalAdd');
const openModalInacButtons = document.querySelectorAll('.openModalInac');
const openModalCreateButtons = document.querySelectorAll('.openModalCreate');
const openModalMonthButtons = document.querySelectorAll('.openMonth');
const cancelButton = document.querySelectorAll('.cancelButton');

const modal = document.getElementById('modal');
const fenetreSuppr = document.querySelector('.page-suppr');
const fenetreAdd = document.querySelector('.page-ajouter');
const fenetreInactif = document.querySelector('.page-inactif');
const fenetreArgent = document.querySelector('.page-argent');
const fenetreMonth = document.querySelector('.page-update');

openModalInacButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      modal.style.display = 'flex';
      fenetreInactif.style.display = 'flex';
      var divInac = button.getAttribute('data-id');
      var inputInac = document.getElementById("inputInac");
      inputInac.setAttribute("value", divInac);
    });
  });

  openModalAddButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      modal.style.display = 'flex';
      fenetreAdd.style.display = 'flex';
      var divAdd = button.getAttribute('data-id');
      var inputAdd = document.getElementById("inputAdd");
      inputAdd.setAttribute("value", divAdd);
    });
  });


openModalSupprButtons.forEach(function(button) {
  button.addEventListener('click', function() {
    modal.style.display = 'flex';
    fenetreSuppr.style.display = 'flex';
    var divSuppr = button.getAttribute('data-id');
    var inputSuppr = document.getElementById("inputSuppr");
    inputSuppr.setAttribute("value", divSuppr);
  });
});




openModalCreateButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      modal.style.display = 'flex';
      fenetreArgent.style.display = 'flex';
      var divCreate = button.getAttribute('data-id');
    });
});

openModalMonthButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      modal.style.display = 'flex';
      fenetreMonth.style.display = 'flex';
    });
});

  cancelButton.forEach(function(button) {
    button.addEventListener('click', function() {
    modal.style.display = 'none';
    fenetreSuppr.style.display = 'none';
    fenetreAdd.style.display = 'none';
    fenetreInactif.style.display = 'none';
    fenetreArgent.style.display = 'none';
    fenetreMonth.style.display = 'none';
    var divCancel = button.getAttribute('data-id');
    });
});

modal.addEventListener('click', function(event) {
  if (event.target === modal) {
    modal.style.display = 'none';
    fenetreSuppr.style.display = 'none';
    fenetreAdd.style.display = 'none';
    fenetreInactif.style.display = 'none';
    fenetreArgent.style.display = 'none';
    fenetreMonth.style.display = 'none';
  }
});



////////////////////////////////////////////////////////////////////////////////////////////////////////

