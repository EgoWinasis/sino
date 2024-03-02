<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelCustomer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customer'; // Define the table name

    protected $fillable = [
        'id_user',
        'name',
        'alamat',
        'patokan',
        'maps',
        'pemilik',
        'telp',
        'foto_toko',
        'limit',
        'tipe_pembayaran',
        'area',
        'order',
        'approve_by',
    ];
}
