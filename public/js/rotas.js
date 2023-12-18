$(document).ready(function(){
    function updateField(element) {
        var id = $(element).data('id');
        var field = $(element).data('field');
        var value = $(element).val();

        $.ajax({
            url: "/rotas/update",
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "field": field,
                "value": value
            },
            success: function(response){
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Rota atualizada com sucesso!',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });            
            }
        });
    }

    $('.edit, .edit-select').on('input change', function(){
        updateField(this);
    });
});