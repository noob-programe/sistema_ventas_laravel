<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $total_usuario = DB::select ("SELECT COUNT(*) as total FROM  usuario where estado =1");
        View::share ("total_usuario", $total_usuario[0]-> total);

        $total_cliente = DB::select ("SELECT COUNT(*) as total FROM cliente");
        View::share ("total_cliente", $total_cliente[0]-> total);

        $total_venta = DB::select ("SELECT SUM(total)  as total from venta where estado =1 AND fecha= curdate()");
        View::share ("total_venta", $total_venta[0]-> total);

        $total_producto = DB::select ("SELECT COUNT(*) as total  FROM producto where estado =1");
        View::share ("total_producto", $total_producto[0]-> total);

        $ventas = DB::select("
        SELECT
        sum(venta.pagoTotal) as 'tot',
        MONTHNAME(venta.fecha) as 'fecha',
        MONTH(venta.fecha) as 'fechaN',
        venta.total,
        venta.id_venta
        FROM
        venta
        where
        EXTRACT(YEAR FROM fecha) = EXTRACT(YEAR FROM NOW()) and venta.estado=1
        GROUP BY MONTHNAME(venta.fecha)
        ORDER BY Month(fecha)ASC
         ");
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($ventas as $key => $value) {
            $data[$value->fechaN - 1] = $value->tot;
        }

        View::share ("ventas", $ventas);
    }   
}
