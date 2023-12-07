<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Response;
use TCPDF;

class CsvToPdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt',
            ]);

            // Read the CSV file
            $csvData = $this->readCsv($request->file('csv_file'));

            // Get the selected options
            $selectedOptions = $request->only(['sku', 'qty', 'orderId', 'orderNotes', 'invoiceNumber']);

            // Generate PDF with TCPDF and return a download response
            $pdf = $this->generateTcpdf($csvData, $selectedOptions);

            // Generate the PDF output
            $pdfOutput = $pdf->Output('generated_pdf.pdf', 'S');

            // Send the PDF as a downloadable response
            return Response::make($pdfOutput, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename=generated_pdf.pdf',
            ]);
        } catch (\Exception $exp) {
            // Handle the exception
            return back()->with('error', 'Error generating PDF: ' . $exp->getMessage());
        }
    }

    private function readCsv($csvFile)
    {
        $handle = fopen($csvFile->getPathname(), 'r');
        $data = [];

        // Skip the header row
        fgetcsv($handle);

        // Process each row in the CSV file
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }

        fclose($handle);

        return $data;
    }

    private function generateTcpdf($data, $selectedOptions)
{
    // Create a new TCPDF instance
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 10);

    // Set PDF content
    $pdf->SetFont('helvetica', '', 12);

    foreach ($data as $row) {
        // first column contains the sku code
        $skuCode = $row[0];

        $inventoryItem = InventoryItem::where('sku_code', $skuCode)->first();

        // Add a new page for each row
        $pdf->AddPage();

        // Image center
        if ($inventoryItem && !empty($inventoryItem->images)) {
            $image = $inventoryItem->images;
            $imageX = ($pdf->getPageWidth() - 120) / 2;
            $pdf->Image($image, $imageX, 70, 120);
        }

        // selected options to the top center of the PDF
        $options = [];
        foreach ($selectedOptions as $option => $value) {
            if ($value && isset($row[array_search($option, $data[0])])) {
                $options[] = ucfirst($option) . ': ' . $row[array_search($option, $data[0])];
            }
        }

        // Center the text
        $optionsText = implode('.', $options);
        $optionsX = ($pdf->getPageWidth() - $pdf->GetStringWidth($optionsText)) / 2;
        $pdf->SetXY($optionsX,10);
        $pdf->Cell(0, 10, $optionsText, 0, 1, 'C');
    }

    return $pdf;
}

}
