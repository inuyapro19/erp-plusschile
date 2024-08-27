<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BusCertificado;

class CertificadoBus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CertificadoBus:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica la fecha de vencimiento generando una notificacion para renovar el certificado';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $certificadoBus = BusCertificado::select('fecha_emision','tipo_certificado','bus_id','DATEDIFF(fecha_vencimiento, now()) as dias_por_vencer')
            ->where('fecha_vencimiento' ,'>', now())->get();
    }
}
