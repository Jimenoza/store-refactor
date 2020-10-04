$(document).ready(function(){
    $('#register').on('click', function (ev){
        $("#popupRegister").modal('show');
    });
    $('#iniciarSesion').on('click', function (ev){
        $("#popupLogin").modal('show');
    });

})

function callModal(modal) {
    $(modal).modal('show');
};