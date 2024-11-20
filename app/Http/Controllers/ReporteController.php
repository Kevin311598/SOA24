<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReporteController extends Controller
{
    function getMeses()
    {
        return [
            "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO",
            "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
        ];
    }

    private function setFinishExcel($spreadsheet, $filename)
    {
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function __invoke($anio, $mes = null)
    {

        $orders = Order::with("order_details")->whereYear('created_at', $anio);
        $mes_str = null;
        if ($mes !== null) {
            $mes_str = $this->getMeses()[$mes - 1];
            $orders->whereMonth('created_at', $mes);
        }
        $orders = $orders->get();

        $totalTortas = $orders->reduce(function ($carry, $order) {
            return $carry + $order->order_details->sum('quantity');
        }, 0);

        $spreadsheet = IOFactory::load(public_path('assets/reporte.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();

        $row = 6;

    
        $sheet->setCellValue('C' . 2, "Reportes del $mes_str $anio");
        $sheet->getStyle('C' . 2)->getFont()->setBold(true);

        $sheet->setCellValue('F' . $row + 1, $totalTortas);
        $sheet->getStyle('F' . $row + 1)->getFont()->setBold(true);

        $numFilas = count($orders);
        $sheet->insertNewRowBefore($row + 1, $numFilas);
        foreach ($orders as $reporte) {
            $sheet->fromArray([
                $reporte->customer->full_name,
                $reporte->event->name,
                $reporte->created_at,
                $reporte->order_details->sum('quantity'),
            ], NULL, "C$row");
            $row++;
        }

        foreach (range('C', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = "reporte $anio $mes_str.xlsx";
        $this->setFinishExcel($spreadsheet, $filename);
        exit;
    }
}
