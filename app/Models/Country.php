<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function timezones()
    {
        return $this->hasMany(Timezone::class);
    }
}
