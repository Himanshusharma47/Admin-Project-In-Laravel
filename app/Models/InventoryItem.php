<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku_code',
        'images',
    ];

    // Get table from the database
    protected $table = 'inventory_items';
    public $timestamps = false;
}
