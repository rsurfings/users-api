<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transaction extends Model
{
    use HasFactory;
    /**
     * @inheritDoc
     */
    protected $guarded = [];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @inheritDoc
     */
    protected $appends = [
        'transaction_date',
    ];

    protected $casts = [
        'payee_id' => 'integer',
        'payer_id' => 'integer',
        'value' => 'integer',
    ];

    /**
     * Get created_at.
     *
     * @return string
     */
    public function getTransactionDateAttribute(): string
    {
        return $this->attributes['created_at'];
    }
}
