<!-- Conteúdo da página de relatório -->
<div class="container">
    <!-- Seção do Relatório de Tabela -->

    <!-- Seção do Gráfico -->
    <div class="card mt-3">
        <div class="card-header">Seu Gráfico Evolutivo</div>
        <div class="card-body">
            <canvas id="myChart" width="800" height="400"></canvas>
        </div>
    </div>
</div>

<!-- Inclusão do script para gerar o gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script para inicializar o gráfico com os dados -->
<script>
    // Recupere os dados do controlador e passe para o gráfico
    var labels = @json($labels);
    var data = @json($data);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line', // Tipo de gráfico de linha do tempo
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Vendas por Vendedor',
                data: data,
                fill: false, // Não preencher a área abaixo da linha
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time', // Tipo de escala para o eixo X
                    time: {
                        unit: 'day' // Ajuste conforme necessário (day, month, year, etc.)
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
