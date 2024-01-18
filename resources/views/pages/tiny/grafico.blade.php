<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labels = @json($meses);
    var data = @json($data);
    var dadosGrafico = @json($dadosGrafico);

    // Dados de exemplo
    // var labels = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",];
    // var data = [65, 59, 80, 81, 56, 55, 40];
    console.log(data);
    console.log(dadosGrafico);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Vendas Mensais',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
