<?php

namespace App\Twig;

use App\Classe\Cart;
use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements GlobalsInterface
{

    private $categoryRepository;
    private $cart;

    public function __construct(CategoryRepository $categoryRepository,Cart $cart)
    {
        $this->categoryRepository=$categoryRepository;
        $this->cart=$cart;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($number): string
    {
        return number_format($number, 2, ',', ' ') . ' DH';
    }

    public function getGlobals(): array
    {
        return [
            'AllCategories' => $this->categoryRepository->findAll(),
            'fullCartQuantity' => $this->cart->fullOuantity()
        ];
    }
}
