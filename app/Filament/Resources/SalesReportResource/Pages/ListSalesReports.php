<?php
namespace App\Filament\Resources\SalesReportResource\Pages;

use App\Filament\Resources\SalesReportResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ListSalesReports extends ListRecords
{
    protected static string $resource = SalesReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Export PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    // Ambil data order yang difilter
                    $orders = $this->getFilteredTableQuery()->get();
                    
                    // Buat PDF
                    $pdf = PDF::loadView('reports.sales', [
                        'orders' => $orders,
                        'total_sales' => $orders->sum('total_amount'),
                        'total_items' => $orders->sum(function($order) {
                            return $order->items->sum('quantity');
                        })
                    ]);
                    
                    // Generate nama file
                    $filename = 'sales_report_' . now()->format('YmdHis') . '.pdf';
                    
                    // Langsung return response download
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, $filename);
                }),
        ];
    }
}