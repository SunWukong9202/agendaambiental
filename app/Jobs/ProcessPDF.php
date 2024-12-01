<?php

namespace App\Jobs;

use App\Models\CMUser;
use App\Models\Pivots\Delivery;
use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\LaravelPdf\Facades\Pdf;

class ProcessPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $pdfData
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $supplier = Supplier::find($this->pdfData['to_id']);
        $user = CMUser::find($this->pdfData['from_id']);
        $deliveries = Delivery::whereIn('id', $this->pdfData['deliveries_ids'])->get();
        $total = $this->pdfData['total'];

        Pdf::view('pdf.deliveries', [
            'from' => $user,
            'to' => $supplier,
            'deliveries' => $deliveries,
            'total' => $total
        ])
            ->disk('public')
            ->save("reporte-entregas-{$supplier}-" . now('America/Mexico_City')->format('Y-m-d-H:i:s') . ".pdf");
    }
}
