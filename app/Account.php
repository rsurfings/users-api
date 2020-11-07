<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
    /**
     * @inheritDoc
     */
    protected $guarded = [];

    /**
     * Get consumer.
     *
     * @return HasOne
     */
    public function consumer(): HasOne
    {
        return $this->hasOne(Consumer::class);
    }
}
