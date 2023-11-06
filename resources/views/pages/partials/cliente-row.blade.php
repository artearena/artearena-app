@foreach ($clientes as $cliente)
    <tr>
        <td class="cliente-id text-center">{{ $cliente->id }}</td>
        <td class="text-center" style="word-wrap: break-word;">
            <a href="https://app.octadesk.com/chat/{{ $cliente->url_octa }}/opened" target="_blank">
                {{ mb_substr($cliente->nome, 0, 25) . (mb_strlen($cliente->nome) > 25 ? '...' : '') }}
            </a>
        </td>
        <td class="text-center">{{ $cliente->telefone }}</td>
        <td class="text-center">{{ $cliente->email }}</td>
        <td class="text-center">{{ $cliente->empresa }}</td>
        <td class="text-center">
            <select name="responsavel_contato" class="form-control responsavel-contato">
                <option value="">Selecione um responsável</option>
                @foreach ($vendedores as $vendedor)
                    <option value="{{ $vendedor }}" @if ($cliente->responsavel_contato == $vendedor) selected @endif>
                        {{ $vendedor }}
                    </option>
                @endforeach
            </select>
        </td>
        <td class="text-center">{{ $cliente->origem }}</td>
        <td>
            <select class="form-control" name="status_conversa">
                <option value="">Selecione uma opção</option>
                <option value="Lead" {{ $cliente->status_conversa == 'Lead' ? 'selected' : '' }}>Lead</option>
                <option value="Venda Concluída" {{ $cliente->status_conversa == 'Venda Concluída' ? 'selected' : '' }}>Venda Concluída</option>
                <option value="Enviado" {{ $cliente->status_conversa == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="Aberto" {{ $cliente->status_conversa == 'Aberto' ? 'selected' : '' }}>Aberto</option>
            </select>
        </td>
        <td class="text-center">{{ $cliente->created_at }}</td>
        <td class="text-center">
            <div class='date datetimepicker'>
                <input type="datetime-local" class="form-control" id="date" lang="pt-br"
                    value="{{ $cliente->data_agendamento ? (new DateTime($cliente->data_agendamento))->format('Y-m-d\TH:i:s') : '' }}">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </td>
        <td class="text-center">
            <select name="mensagem_id" class="form-control mensagem_id" @if (!$cliente->data_agendamento)
                disabled @endif>
                <option value="">Selecione uma mensagem</option>
                @php
                    $mensagensOrdenadas = $mensagens->sortBy('titulo');
                @endphp
                @foreach ($mensagensOrdenadas as $mensagem)
                    <option value="{{ $mensagem->id }}"
                        @if ($cliente->mensagem_template_id == $mensagem->id) selected @endif>
                        {{ $mensagem->titulo }}
                    </option>
                @endforeach
            </select>
        </td>
        <td class="text-center">
            <label class="switch">
                <input type="checkbox" class="table_checkbox" id="checkbox" value="{{ $cliente->contato_bloqueado }}" @if($cliente->contato_bloqueado == 1) checked @endif>
                <span class="slider round"></span>
            </label>
        </td>
        <td class="text-center">Prov.</td>
        <td class="text-center">Prov.</td>
        <td class="text-center">
            <a href="#" class="btn btn-primary ms-1" target="_blank">
                <i class="fa-brands fa-trello"></i>
            </a>
        </td>
    </tr>
@endforeach