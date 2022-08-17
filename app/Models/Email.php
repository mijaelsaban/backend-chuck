<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $value
 * @property string $name
 * @property string $domain
 * @property Message $messages
 */
final class Email extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)
            ->select('id', 'email_id', 'value', 'created_at');
    }
}
