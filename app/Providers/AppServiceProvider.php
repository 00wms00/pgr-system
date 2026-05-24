<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // @role('admin') ... @endrole
        Blade::directive('role', function (string $role) {
            return "<?php if(auth()->check() && auth()->user()->role?->value === trim({$role}, \"'\"  )): ?>";
        });
        Blade::directive('endrole', fn() => '<?php endif; ?>');

        // @canwrite ... @endcanwrite
        Blade::directive('canwrite', function () {
            return '<?php if(auth()->check() && auth()->user()->canWrite()): ?>';
        });
        Blade::directive('endcanwrite', fn() => '<?php endif; ?>');
    }
}
