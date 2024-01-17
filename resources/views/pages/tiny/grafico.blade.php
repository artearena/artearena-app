<div class="container">
        @auth
            @if(Auth::user()->id == $user->id) {{-- Verifica se o usuário logado é o mesmo que está acessando a página --}}
                <div class="card">
                    <div class="card-header">Seu Gráfico Evolutivo</div>
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="200"></canvas>
                    </div>
                </div>
            @else
                <div class="alert alert-danger" role="alert">
                    Você não tem permissão para visualizar este gráfico.
                </div>
            @endif
        @else
            <div class="alert alert-info" role="alert">
                Você precisa estar logado para visualizar este gráfico.
            </div>
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Recupere os dados do controlador e passe para o gráfico
        var labels = @json($labels);
        var data = @json($data);

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Vendas por Vendedor',
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