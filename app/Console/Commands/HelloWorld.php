<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $response = Http::withHeaders([
            'X-API-KEY' => '3b8f740e-6dd3-4da3-a59e-30ee20169c49.31b74e42-c05f-4341-b386-320b5231125d',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://artearena.api004.octadesk.services/chat/conversation/send-template', [
            "target" => [
                "contact" => [
                    "phoneContact" => [
                        "number" => "+5511987430004"
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
        } else {
            $this->error('CURL request failed');
        }

        return 0;
    }
}