<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<!-- Adicione o Moment.js antes do Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>

<script>
    // Configurar o adaptador de data para 'moment'
    Chart.register({
        id: 'moment',
        beforeInit: function (chart, _options) {
            chart.$adapter = Chart._adapters._date.adapters.moment;
            chart._date = moment;
        },
    });

    var dadosGrafico = @json($dadosGrafico);

    // Processar dados para o gráfico
    var labels = dadosGrafico.map(function (item) {
        return moment(item.data_pedido).toDate();
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
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
