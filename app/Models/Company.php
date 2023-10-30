<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $uploadPath = 'app/public/logo/';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function getLogo(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attr) => asset('storage/logo/' . $this->logo)
        );
    }

    protected $appends = ['get_logo'];
    protected $hidden = ['created_at', 'updated_at'];
}
