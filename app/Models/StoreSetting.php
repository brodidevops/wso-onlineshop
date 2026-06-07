<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'is_active',
        'sort',
        'options',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
        'options' => 'array',
    ];

    // Get setting value by key
    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Get setting by key with type casting
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        // Type casting based on type field
        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'number', 'integer' => is_numeric($setting->value) ? (int) $setting->value : $default,
            'float', 'decimal' => is_numeric($setting->value) ? (float) $setting->value : $default,
            'json' => json_decode($setting->value, true) ?: $default,
            default => $setting->value,
        };
    }

    // Set setting value
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );
    }

    // Get all settings by group
    public static function getGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();
    }

    // Get settings as key-value array for a group
    public static function getGroupValues(string $group): array
    {
        return static::getGroup($group)
            ->pluck('value', 'key')
            ->toArray();
    }

    // Scope for active settings
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for groups
    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    // Get image URL if type is image
    public function getImageUrlAttribute(): ?string
    {
        if ($this->type === 'image' && $this->value) {
            return asset('storage/' . $this->value);
        }
        return null;
    }
}
