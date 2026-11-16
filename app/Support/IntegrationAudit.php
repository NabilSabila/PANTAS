<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class IntegrationAudit
{
    /**
     * Create a new class instance.
     */
    // Constructor kosong generator tidak diperlukan; audit hanya membaca route dan file.
    public function routeIssues(): array
    {
        $issues = [];
        foreach (Route::getRoutes() as $route) {
            if (! $route->getAction('controller')) {
                continue;
            }
            $class = $route->getControllerClass();
            $method = $route->getActionMethod();
            if (! class_exists($class) || ! method_exists($class, $method)) {
                $issues[] = $route->uri().': '.$class.'@'.$method;
            }
        }

        return $issues;
    }
}
