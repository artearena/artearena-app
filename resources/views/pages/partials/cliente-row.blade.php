@foreach ($clientes as $cliente)
    <tr>
        <td style="display:none">{{ $cliente->id }}</td>
        <td>{{ $cliente->id }}</td>
        <td class="text-center" style="word-wrap: break-word;">
            <a href="https://app.octadesk.com/chat/{{ $cliente->url_octa }}/opened" target="_blank">
                {{ mb_substr($cliente->nome, 0, 25) . (mb_strlen($cliente->nome) > 25 ? '...' : '') }}
            </a>
        </td>        
        <td>{{ $cliente->telefone }}</td>
        <td style="display:none">{{ $cliente->email }}</td>
        <td>{{ $cliente->empresa }}</td>
        <td>{{ $cliente->responsavel_contato }}</td>
        <td style="display:none">{{ $cliente->origem }}</td>
        <td>{{ $cliente->status_conversa }}</td>
        <td>{{ $cliente->created_at }}</td>
        <td>
            <div class='date datetimepicker'>
                <input type="datetime-local" class="form-control" id="date" lang="pt-br"
                    value="{{ $cliente->data_agendamento ? (new DateTime($cliente->data_agendamento))->format('Y-m-d\TH:i:s') : '' }}">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </td>
        <td>
            <select name="mensagem_id" class="form-control mensagem_id" @if (!$cliente->data_agendamento) disabled @endif>
                <option value="">Selecione uma mensagem</option>
                @foreach ($mensagens as $mensagem)
                    <option value="{{ $mensagem->id }}" @if ($cliente->mensagem_template_id == $mensagem->id) selected @endif>
                        {{ $mensagem->titulo }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <label class="switch">
                <input type="checkbox" class="table_checkbox" id="checkbox" value="{{ $cliente->contato_bloqueado }}" @if($cliente->contato_bloqueado == 1) checked @endif>
                <span class="slider round"></span>
            </label>
        </td>
        <td>Prov.</td>
        <td>Prov.</td>
        <td>
            <a href="#" class="btn btn-primary ms-1" target="_blank">
                <i class="fa-brands fa-trello"></i>
            </a>
        </td>
    </tr>
@endforeach