<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
<!-- Adicione o Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dados fictícios para o gráfico inicial
        var dadosIniciais = {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [{
                label: 'Total de Vendas por Vendedor',
                data: [100, 100, 200, 200, 300, 300, 400, 500, 600, 700, 800, 900],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false,
            }]
        };

        // Processar dados para o gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: dadosIniciais,
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'month',
                            parser: 'MMMM',
                            tooltipFormat: 'MMMM',
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
