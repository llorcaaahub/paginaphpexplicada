"use strict";
$(document).ready(function () {

        let messageTitle = '<div class="modal-header text-white btn-secondary"><h5 class="text-white modal-title">Register successful!</h5></div>'
        let messageText = 'Your register was completed successfully but your account must be activated before your first login to the Cinetics platform.';

        let customModal = $('<div class="modal fade" id="resRegistro" tabindex="-1" role="dialog" aria-labell' +
            'edby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal' +
            '-dialog-centered" role="document"><div class="modal-content">' + messageTitle + '<div class="modal-body text-justify">' + messageText + 
            '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" onclick="$(\'#resRegistro\').modal(\'hide\');' +
            'window.location.replace(\'index.php\');">Cerrar</button></div></div></div></div>');
        $('body').append(customModal);
        $('#resRegistro').modal();
});