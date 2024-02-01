@foreach ($orcamentos as $orcamento)
    <tr>
        <td>{{ $orcamento->id }}</td>
        <td>{{ $orcamento->id_octa }}</td>
        <td class="expandir-observacoes" title="{{ $orcamento->detalhes_orcamento }}">{{ $orcamento->detalhes_orcamento }}</td>
        <td>{{ $orcamento->nome_transportadora }}</td>
        <td>{{ $orcamento->valor_frete }}</td>
        <td>
            @if($orcamento->usuario)
                {{ $orcamento->usuario->nome_usuario }}
            @else
                -
            @endif
        </td>
        <td>{{ $orcamento->created_at->format('d/m/Y H:i:s') }}</td>
        <td>{{ $orcamento->quantidade_repeticoes }}</td>
        <td>
            <!-- Link para visualizar detalhes do orçamento -->
            <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-info">Detalhes</a>

            <!-- Link para editar o orçamento -->
            <a href="{{ route('orcamentos.edit', $orcamento->id) }}" class="btn btn-warning">Editar</a>

            <!-- Botão para excluir o orçamento -->
            <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
        </td>
    </tr>
@endforeach
