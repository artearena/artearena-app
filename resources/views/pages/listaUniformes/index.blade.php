document.addEventListener('DOMContentLoaded', function() {
    var produtos = @json($produtos);

    var tbody = document.querySelector('tbody');
    tbody.innerHTML = '';

    produtos.forEach(function(produto) {
        if (ehVestuario(normalize(produto.produto_nome))) {
            for (var i = 0; i < produto.quantidade; i++) {
                var row = document.createElement('tr');
                var sexoCategoria = produto.sexo === 'M' ? 'Masculino' : (produto.sexo === 'F' ? 'Feminino' : 'Infantil');
                var camisaChecked = produto.camisa ? 'Sim' : 'Não';
                var calcaoChecked = produto.calcao ? 'Sim' : 'Não';
                var meiaoChecked = produto.meiao ? 'Sim' : 'Não';

                row.innerHTML = `
                    <td>${produto.produto_nome}</td>
                    <td>
                        <select class='form-control'>
                            <option value='M' ${produto.sexo === 'M' ? 'selected' : ''}>Masculino</option>
                            <option value='F' ${produto.sexo === 'F' ? 'selected' : ''}>Feminino</option>
                            <option value='I' ${produto.sexo === 'I' ? 'selected' : ''}>Infantil</option>
                        </select>
                    </td>
                    <td>${produto.arte_aprovada}</td>
                    <td>${produto.pacote !== null && produto.pacote !== '' ? produto.pacote : ''}</td>
                    <td>${camisaChecked}</td>
                    <td>${calcaoChecked}</td>
                    <td>${meiaoChecked}</td>
                    <td>${produto.nome_jogador !== null && produto.nome_jogador !== '' ? `<input type='text' value='${produto.nome_jogador}' class='form-control'>` : ''}</td>
                    <td>${produto.numero !== null && produto.numero !== '' ? `<input type='number' value='${produto.numero}' class='form-control'>` : ''}</td>
                    <td>
                        <select class='form-control'>
                            <!-- Adicione as opções desejadas para Tamanho aqui -->
                        </select>
                    </td>
                    <td>
                        <select class='form-control'>
                            <!-- Adicione as opções desejadas para Gola aqui -->
                        </select>
                    </td>
                `;
                tbody.appendChild(row);
            }
        }
    });

    // Aplicar máscara após a criação das linhas
    $('input[type="number"]').mask('00000');
});
