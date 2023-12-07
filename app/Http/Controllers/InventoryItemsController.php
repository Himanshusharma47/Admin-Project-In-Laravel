<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;

class InventoryItemsController extends Controller
{
        /**
     * Import image data from a CSV file and update or create inventory items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageData(Request $request)
    {
        $request->validate([
            'image_csv_file' => 'required|mimes:csv,txt',
        ]);

        $csvFile = $request->file('image_csv_file');

        $handle = fopen($csvFile->getPathname(), 'r');

        fgetcsv($handle);

        InventoryItem::truncate();

        while (($row = fgetcsv($handle)) !== false) {

            $skuCode = $row[0];
            $image = $row[1];

            InventoryItem::updateOrCreate(
                ['sku_code' => $skuCode],
                ['images' => $image]
            );
        }

        fclose($handle);

        return redirect()->back()->with('success', 'CSV data has been successfully imported.');
    }
}
