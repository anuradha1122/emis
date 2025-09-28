<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'educationDivisionId',
        'gnDivisionId',
        'active',
    ];

    /**
     * Each location info belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * Education Division (from offices table).
     */
    public function educationDivision(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'educationDivisionId', 'id');
    }

    /**
     * GN Division.
     */
    public function gnDivision(): BelongsTo
    {
        return $this->belongsTo(GnDivision::class, 'gnDivisionId', 'id');
    }
}
