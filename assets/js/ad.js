$(document).ready(function () {
    $('#add-image').click(function () { // On recupere le numero du champ suivant qu'on va creer
        const index = + $('#widgets-counter').val();
        console.log(index);
        // On remplace __name__ du prototype par le numero du champ suivant
        const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
        $('#ad_images').append(tmpl);
        $('#widgets-counter').val(index + 1);
        handleDeleteButtons();
    });

    function handleDeleteButtons() {
        $('button[data-action="delete"]').click(function () {
            const target = this.dataset.target;
            $(target).remove();
        });
    }
    function updateCounter() {
        const count = +$('#ad_images div.form-group').length;

        $('#widgets-counter').val(count);
    }

    updateCounter();
    handleDeleteButtons();
})