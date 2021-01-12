<?php

namespace App\Http\Middleware;
use App\Models\Master\Auditor;
use App\Models\Audit\DataAudit;

use Closure;
use Menu;

class GenerateMenus
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        Menu::make('mainMenu', function ($menu) {
            $menu->add('Dashboard', 'home')
                 ->data('icon', 'dashboard')
                 ->data('perms', 'dashboard')
                 ->active('home');

            /* Data Master */
            $menu->add('Data Master')
                 ->data('icon', 'database')
                 ->active('master/*');
            $menu->dataMaster->add('Akun Induk', 'master/akun-induk/')
                 ->data('perms', 'master-akun-induk')
                 ->active('master/akun-induk/*');
      
            $menu->dataMaster->add('Trans Order', 'master/transorder/')
             ->data('perms', 'master-transorder')
             ->active('master/transorder/*');
                 
            $menu->dataMaster->add('OrderBy', 'master/order/')
             ->data('perms', 'master-order')
             ->active('master/order/*');
            /* Konfigurasi */
            $menu->add('Konfigurasi')
                 ->data('icon', 'settings')
                 ->active('konfigurasi/*');
            $menu->konfigurasi->add('Manajemen Pengguna', 'konfigurasi/users/')
                 ->data('perms', 'konfigurasi-users')
                 ->active('konfigurasi/users/*');
            $menu->konfigurasi->add('Hak Akses', 'konfigurasi/roles/')
                 ->data('perms', 'konfigurasi-roles')
                 ->active('konfigurasi/roles/*');

        });

        return $next($request);
    }
}
