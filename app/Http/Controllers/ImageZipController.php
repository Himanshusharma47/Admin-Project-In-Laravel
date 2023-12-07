<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use ZipArchive;


class ImageZipController extends Controller
{
    public function generateZip(Request $request)
    {
        try {
            if ($request->hasFile('csv_file')) {
                // Create a zip archive
                $zipFileName = 'downloaded_images.zip';
                $zipFilePath = storage_path($zipFileName);
                $zip = new ZipArchive();

                if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    // Read CSV file
                    $csv = $request->file('csv_file')->getRealPath();
                    $handle = fopen($csv, "r");

                    // Array to hold sku and qty
                    $skuList = [];

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Assuming sku is in the first column
                        $sku = $data[0];
                        $skuList[] = $sku;
                    }

                    fclose($handle);

                    // Query database to get image URLs based on SKUs from the CSV
                    $items = InventoryItem::whereIn('sku_code', $skuList)->get();

                    foreach ($items as $item) {
                        $imageURL = $item->images;
                        $imageContent = file_get_contents($imageURL);
                        $imageFilename = basename($imageURL); // Get filename from URL

                        // Save the image content to the zip archive
                        $zip->addFromString($imageFilename, $imageContent);
                    }

                    $zip->close();

                    // Set headers to force download
                    return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
                }
            }

        } catch (\Exception $exp) {
            // Handle the exception
            return back()->with('error', 'Error generating zip file: ' . $exp->getMessage());
        }

    }
}
