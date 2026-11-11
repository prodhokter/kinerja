<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportUpdate extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'report_id',
        'status',
        'message',
        'is_public',
        'user_id',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => ReportStatus::class,
        'is_public' => 'boolean',
        'message' => 'encrypted',
    ];

    /** @return BelongsTo<Report, $this> */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
