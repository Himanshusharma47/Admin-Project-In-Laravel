<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Response;
use TCPDF;

class CsvToPdfController extends Controller
{
     /**
     * Generate a PDF document from CSV data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generatePdf(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt',
            ]);

            $csvData = $this->readCsv($request->file('csv_file'));

            $pdf = $this->generateTcpdf($csvData);

            $pdfOutput = $pdf->Output('csv_file_pdf.pdf', 'S');

            return Response::make($pdfOutput, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename=generated_pdf.pdf',
            ]);
        } catch (\Exception $exp) {
            // Handle the exception
            return back()->with('error', 'Error generating PDF: ' . $exp->getMessage());
        }
    }

     /**
     * Read CSV data from the uploaded file.
     *
     * @param  \Illuminate\Http\UploadedFile  $csvFile
     * @return array
     */
    private function readCsv($csvFile)
    {
        $handle = fopen($csvFile->getPathname(), 'r');
        $data = [];

        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }

        fclose($handle);

        return $data;
    }

    /**
     * Generate a PDF document using TCPDF.
     *
     * @param  array  $data
     * @return \TCPDF
     */
    private function generateTcpdf($data)
    {
        $pdf = new TCPDF();
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetFont('helvetica', '', 12);

        foreach ($data as $row) {
            $skuCode = $row[0];
            $inventoryItem = InventoryItem::where('sku_code', $skuCode)->first();

            $pdf->AddPage();

            // Image center logic
            if ($inventoryItem && !empty($inventoryItem->images)) {
                $image = $inventoryItem->images;
                $imageX = ($pdf->getPageWidth() - 130) / 2;
                $pdf->Image($image, $imageX, 70, 130);
            }

            // SKU value at the top center
            $pdf->SetY(20);
            $pdf->SetX($pdf->getPageWidth() / 2);
            $pdf->Cell(10, 10, 'SKU: ' . $skuCode, 0, 1, 'C');
        }

        return $pdf;
    }


}
