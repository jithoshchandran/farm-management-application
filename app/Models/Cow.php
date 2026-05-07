<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cow extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dob' => 'date',
        'last_calving_date' => 'date',
        'last_heat_date' => 'date',
        'next_expected_heat' => 'date',
        'purchase_date' => 'date',
        'purchase_pregnancy_date' => 'date',
        'images' => 'array',
        'breed_id' => 'integer',
        'external_lineage' => 'array',
    ];

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function sire(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'sire_id');
    }

    public function dam(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'dam_id');
    }

    public function sireSemenStock(): BelongsTo
    {
        return $this->belongsTo(SemenStock::class, 'sire_semen_stock_id');
    }

    public function pGrandSire(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'p_grand_sire_id');
    }

    public function mGrandMother(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'm_grand_mother_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Cow::class, 'dam_id')->orWhere('sire_id', $this->id);
    }

    public function milkProductions(): HasMany
    {
        return $this->hasMany(MilkProduction::class);
    }

    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class);
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    // Helper to get Lineage tree
    public function getPedigreeTreeAttribute()
    {
        return [
            'self' => $this,
            'sire' => $this->sire_source === 'Local Bull' && $this->sire ? $this->sire : ($this->external_lineage['sire'] ?? null),
            'p_grand_sire' => $this->p_grand_sire_source === 'Local Bull' && $this->pGrandSire ? $this->pGrandSire : ($this->external_lineage['p_grand_sire'] ?? null),
            'dam' => $this->dam_source === 'Local' && $this->dam ? $this->dam : ($this->external_lineage['dam'] ?? null),
            'm_grand_mother' => $this->m_grand_mother_source === 'Local' && $this->mGrandMother ? $this->mGrandMother : ($this->external_lineage['m_grand_mother'] ?? null),
        ];
    }

    public function getAgeAttribute(): string
    {
        if (! $this->dob) {
            return '-';
        }

        $diff = $this->dob->diff(now());

        if ($diff->y > 0) {
            return $diff->y . ' yr' . ($diff->y > 1 ? 's ' : ' ') . ($diff->m > 0 ? $diff->m . ' mo' : '');
        }

        if ($diff->m > 0) {
            return $diff->m . ' mo' . ($diff->m > 1 ? 's' : '');
        }

        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
    }

    public function getFullNameAttribute(): string
    {
        if ($this->name && $this->tag_number) {
            return "{$this->name} [{$this->tag_number}]";
        }

        return $this->name ?: $this->tag_number ?: 'Unknown Cow';
    }
}
