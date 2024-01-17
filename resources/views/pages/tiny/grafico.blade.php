<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<!-- Adicione o Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dadosGrafico = @json($dadosGrafico);

        // Processar dados para o gráfico
        var labels = dadosGrafico.map(function (item) {
            return item.data_pedido; // A data já está no formato adequado
        });

        var data = dadosGrafico.map(function (item) {
            return parseFloat(item.soma_total_reais.replace('R$ ', ''));
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Vendas por Vendedor',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            parser: 'YYYY-MM-DD', // Formato da data
                            tooltipFormat: 'll', // Formato da data no tooltip
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
