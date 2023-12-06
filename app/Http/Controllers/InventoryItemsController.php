<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;

class InventoryItemsController extends Controller
{
    public function imageData(Request $request)
    {
        $request->validate([
            'image_csv_file' => 'required|mimes:csv,txt',
        ]);

        // Get the uploaded CSV file
        $csvFile = $request->file('image_csv_file');

        // Open the CSV file for reading
        $handle = fopen($csvFile->getPathname(), 'r');

        // Skip the header row
        fgetcsv($handle);

        // Truncate the existing data in the table
        InventoryItem::truncate();

        // Process each row in the CSV file
        while (($row = fgetcsv($handle)) !== false) {
            // Assuming your CSV has columns 'Sku_Code' and 'Image'
            $skuCode = $row[0]; // Adjust index based on your CSV structure
            $image = $row[1];   // Adjust index based on your CSV structure

            // Create or update the InventoryItem in the database
            InventoryItem::updateOrCreate(
                ['sku_code' => $skuCode],
                ['images' => $image]
            );
        }

        // Close the CSV file handle
        fclose($handle);

        return redirect()->back()->with('success', 'CSV data has been successfully imported.');
    }
}
