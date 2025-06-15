<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice(float $price, string $currency = '€', string $locale = 'fr_FR'): string
    {
        return number_format($price, 2, ',', ' ') . ' ' . $currency;
        
        // Alternative plus sophistiquée (nécessite l'extension intl):
        // return (new \NumberFormatter($locale, \NumberFormatter::CURRENCY))->formatCurrency($price, $currency);
    }
}