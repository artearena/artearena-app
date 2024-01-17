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

    var labels = @json($labels);
    var data = @json($data);

    // Converta os dados de DateTime para Date usando 'moment'
    var convertedData = data.map(function (item) {
        return moment(item).toDate();
    });

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Vendas por Vendedor',
                data: convertedData,
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
