<?php

namespace App\Models;

use App\Services\GenerateUIDService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;


    protected $fillable = [
        'uid',
        'firstname',
        'lastname',
        'middlename',
        'address'
    ];

    public static function generateUniqueIdentifier($uid=null)
    {
        return (new GenerateUIDService)->call($uid);
    }

    public static function isExistingUID($uid)
    {
        return self::where('uid', $uid)->count() > 0;
    }
}
