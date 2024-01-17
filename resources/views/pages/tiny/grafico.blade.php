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
        var dadosGrafico = [{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-05","soma_total_reais":"1,080.10"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-06","soma_total_reais":"170.00"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-08","soma_total_reais":"2,676.50"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-09","soma_total_reais":"2,595.00"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-10","soma_total_reais":"780.65"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-11","soma_total_reais":"2,846.27"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-12","soma_total_reais":"1,756.43"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-15","soma_total_reais":"2,264.00"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-16","soma_total_reais":"1,017.00"},{"id_vendedor":704965097,"nome_vendedor":"Elieth","data_pedido":"2024-01-17","soma_total_reais":"496.00"}];

        // Processar dados para o gráfico
        var labels = dadosGrafico.map(function (item) {
            return item.data_pedido;
        });

        var data = dadosGrafico.map(function (item) {
            return parseFloat(item.soma_total_reais.replace('R$ ', '').replace(',', '.'));
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
                            parser: 'YYYY-MM-DD',
                            tooltipFormat: 'll',
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
