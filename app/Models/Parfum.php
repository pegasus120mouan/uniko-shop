<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parfum extends Model
{
    protected $table = 'parfums';

    const TYPE_CLASSICS = 'classics';
    const TYPE_LUXE = 'luxe';

    protected $fillable = [
        'code',
        'nom',
        'type',
    ];

    public static function getTypes(): array
    {
        return [
            self::TYPE_CLASSICS => 'Classics',
            self::TYPE_LUXE => 'Luxe',
        ];
    }

    public function isLuxe(): bool
    {
        return $this->type === self::TYPE_LUXE;
    }

    public function isClassics(): bool
    {
        return $this->type === self::TYPE_CLASSICS;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ParfumPrice::class);
    }

    public function getMinPrice(): ?int
    {
        return $this->prices->min('prix');
    }

    public function getMaxPrice(): ?int
    {
        return $this->prices->max('prix');
    }

    public function getPriceRange(): string
    {
        $min = $this->getMinPrice();
        $max = $this->getMaxPrice();

        if ($min === null) {
            return '0 FCFA';
        }

        if ($min === $max) {
            return number_format($min, 0, ',', ' ') . ' FCFA';
        }

        return number_format($min, 0, ',', ' ') . ' - ' . number_format($max, 0, ',', ' ') . ' FCFA';
    }
}
