$(document).ready(function(){
    $('.edit').on('blur', function(){
        var id = $(this).data('id');
        var field = $(this).data('field');
        var value = $(this).text();

        $.ajax({
            url: "/rotas/update", // Substituído pela URL da rota nomeada
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
    });
});