<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'roles';
    protected $fillable = [
        'role_name',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function permission(){
        return $this->hasOne(Permission::class);
    }
}
