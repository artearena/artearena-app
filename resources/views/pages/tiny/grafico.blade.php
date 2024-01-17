<div class="container">
    <div class="card mt-3">
        <div class="card-header">Seu Gráfico Evolutivo</div>
        <div class="card-body">
            <canvas id="myChart" width="800" height="400"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>

<script>
    var labels = @json($labels);
    var data = @json($data);

    // Converta os dados de DateTime para Date usando 'dayjs'
    var convertedData = data.map(function (item) {
        return new Date(item);
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
