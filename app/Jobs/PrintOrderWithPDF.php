<?php

namespace App\Jobs;

use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrintOrderWithPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $order
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PDF $pdf)
    {
        $pdf = $pdf->loadView('print/order-pdf-print', ['order' => $this->order]);
        return $pdf->download('bilet.pdf');
    }
}
