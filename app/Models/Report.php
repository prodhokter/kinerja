<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'ticket_code',
        'secret_hash',
        'type',
        'category',
        'region_id',
        'agency_id',
        'program_id',
        'target_beneficiary_id',
        'amount_claimed',
        'description',
        'status',
        'first_response_at',
        'resolved_at',
        'is_simulated',
    ];

    /** @var list<string> */
    protected $hidden = [
        'secret_hash',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'type' => ReportType::class,
        'status' => ReportStatus::class,
        'amount_claimed' => 'integer',
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'is_simulated' => 'boolean',
        'description' => 'encrypted',
    ];

    /** @return BelongsTo<Region, $this> */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /** @return BelongsTo<Agency, $this> */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    /** @return BelongsTo<AidProgram, $this> */
    public function program(): BelongsTo
    {
        return $this->belongsTo(AidProgram::class, 'program_id');
    }

    /** @return BelongsTo<Beneficiary, $this> */
    public function targetBeneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class, 'target_beneficiary_id');
    }

    /** @return HasMany<ReportUpdate, $this> */
    public function updates(): HasMany
    {
        return $this->hasMany(ReportUpdate::class)->orderBy('created_at', 'asc');
    }

    /** @return HasMany<ReportAttachment, $this> */
    public function attachments(): HasMany
    {
        return $this->hasMany(ReportAttachment::class);
    }
}
