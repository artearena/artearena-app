<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Converter os meses do formato YYYY-MM para o formato "Mês Ano"
    var labels = @json($meses.map(month => new Date(month + "-01").toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' })));
    var data = @json($data);
    var dadosGrafico = @json($dadosGrafico);

    // Restante do seu código...
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
