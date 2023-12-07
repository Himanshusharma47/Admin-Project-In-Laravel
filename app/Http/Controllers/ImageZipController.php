<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use ZipArchive;


class ImageZipController extends Controller
{
     /**
     * Convert images from URLs specified in a CSV file to a downloadable ZIP file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function convertZipFile(Request $request)
    { 
        try {
            if ($request->hasFile('csv_file')) {
                // Create a zip archive
                $zipFileName = 'images.zip';
                $zipFilePath = storage_path($zipFileName);
                $zip = new ZipArchive();

                if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

                    $csv = $request->file('csv_file')->getRealPath();
                    $handle = fopen($csv, "r");

                    $skuList = [];

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Assuming sku is in the first column
                        $sku = $data[0];
                        $skuList[] = $sku;
                    }

                    fclose($handle);

                    $items = InventoryItem::whereIn('sku_code', $skuList)->get();

                    foreach ($items as $item) {
                        $imageURL = $item->images;
                        $imageContent = file_get_contents($imageURL);
                        $imageFilename = basename($imageURL); // Get filename from URL

                        $zip->addFromString($imageFilename, $imageContent);
                    }

                    $zip->close();

                    return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
                }
            }

        } catch (\Exception $exp) {
            // Handle the exception
            return back()->with('error', 'Error generating zip file: ' . $exp->getMessage());
        }

    }
}
