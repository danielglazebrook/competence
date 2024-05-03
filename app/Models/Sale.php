<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public $table = 'sales';
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_id', 'quantity', 'unit_cost'];
    protected $connection = 'mysql';
}
