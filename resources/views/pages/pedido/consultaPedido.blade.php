<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa do pedido</title>
    <style>
        .resultado {
            display: none; /* Oculta a parte de resultado inicialmente */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Consulta de etapa do pedido</h1>

        <form action="/consulta-etapa-pedido" class="mt-4">
            <div class="form-row align-items-end">
                <div class="form-group col-md-8">
                    <label for="numero_pedido">Número do pedido:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="numero_pedido" name="numero_pedido" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Consultar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="resultado mt-4" id="resultado">
            <!-- Aqui é onde a etapa do pedido será exibida -->
        </div>
    </div>

    <script>
        // Mostra a parte de resultado quando há um resultado definido
        window.addEventListener('DOMContentLoaded', () => {
            const resultado = document.getElementById('resultado');
            const etapa = "{{$etapa}}"; // Se a variável $etapa estiver definida no seu contexto Blade
            if (etapa) {
                resultado.innerHTML = `<p>Etapa: ${etapa}</p>`;
                resultado.style.display = 'block';
            } else {
                resultado.innerHTML = `<p>Etapa não definida</p>`;
                resultado.style.display = 'block';
            }
        });
    </script>
</body>
</html>
