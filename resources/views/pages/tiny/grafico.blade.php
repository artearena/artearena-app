<div class="container">
    <div class="card mt-3">
        <div class="card-header">Seu Gráfico Evolutivo</div>
        <div class="card-body">
            <canvas id="myChart" width="800" height="400"></canvas>
        </div>
    </div>
</div>

<!-- Adicione o Day.js antes do Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.6"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>

<script>
    // Configurar o adaptador de data para 'dayjs'
    Chart.register({
        id: 'dayjs',
        beforeInit: function (chart, _options) {
            chart.$adapter = Chart._adapters._date.adapters.dayjs;
        },
    });
</script>

<script>
    // Recupere os dados do controlador e passe para o gráfico
    var labels = @json($labels);
    var data = @json($data);

    // Converta os dados de DateTime para Date usando 'dayjs'
    var convertedData = data.map(function (item) {
        return dayjs(item).toDate();
    });

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line', // Tipo de gráfico de linha do tempo
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Vendas por Vendedor',
                data: convertedData,
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
