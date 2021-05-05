<?php

namespace App\Helpers\View;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class ViewFunctions extends AbstractExtension
{
    /**
     * Register functions to be used in template.
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('settings', 'settings'),
            new TwigFunction('url_for', 'url_for'),
            new TwigFunction('only_numbers', 'only_numbers'),

            // You can also refer to functions in this class
            // new TwigFunction('example_function', [$this, 'example_function']),

            // Or refer to functions in another class
            // new TwigFunction('example_function', [App\Example::class, 'function_in_example_class']),
        ];
    }
}
