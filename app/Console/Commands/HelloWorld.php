<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Cliente;
use App\Models\Agendamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class HelloWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulates a CURL request';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        App::setLocale('pt'); // Define o idioma padrão como português

        $now = Carbon::now();

        $agendamentos = Agendamento::where('horario', '<=', $now)
            ->whereNull('confirmacao')
            ->get();

        foreach ($agendamentos as $agendamento) {
            $cliente = Cliente::findOrFail($agendamento->crm_clientes_id);
            $number = $cliente->telefone;

            $response = Http::withHeaders([
                'X-API-KEY' => '3b8f740e-6dd3-4da3-a59e-30ee20169c49.31b74e42-c05f-4341-b386-320b5231125d',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://artearena.api004.octadesk.services/chat/conversation/send-template', [
                "target" => [
                    "contact" => [
                        "phoneContact" => [
                            "number" => $number
                        ]
                    ]
                ],
                "content" => [
                    "templateMessage" => [
                        "id" => "64d2e17f6f8d1b0007de15f3"
                    ]
                ],
                "origin" => [
                    "from" => [
                        "number" => "+5511934881548"
                    ]
                ],
                "options" => [
                    "automaticAssign" => true
                ]
            ]);

            if ($response->successful()) {
                $this->info('CURL request successful');
                $cliente->update(['status_conversa' => 'Enviado']);
            } else {
                $errorMessage = $response->json('message'); // Obtém a mensagem de erro da resposta JSON
            
                if ($errorMessage === 'An open conversation already exists with this contact') {
                    $this->error('Conversa Aberta');
                    $cliente->update(['status_conversa' => 'Aberta']);
                } else {
                    $this->error('Erro não definido');
                    $cliente->update(['status_conversa' => $errorMessage ?? 'Aberta']); // Define como "Aberta" se a mensagem de erro não estiver disponível
                }
            }
            
            $agendamento->update(['confirmacao' => true]);
        }

        return 0;
    }
}