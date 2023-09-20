<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Compra;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShopController extends Controller
{
    //
    public function Procesar(){
        return view('procesar');
    }
    public function Payment(Request $request){
        $request->validate([
            'direccion' => ['required', 'max:100', 'min:10'],
            'contacto' => ['required','numeric', 'min:8'],
            'ciudad' => ['required', 'min:3'],
            'provincia' => ['required', 'min:3'],
            'codigo_postal' => ['required', 'numeric', 'min:3'],
            'pais' => ['required'],
        ]);
        $metadata = [
            'direccion' => $request->direccion,
            'contacto' => $request->contacto,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
            'pais' => $request->pais,
            'codigo_postal' => $request->codigo_postal,
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'lista_productos' => $request->input("productos"),
            'id_productos' => $request->input("id_productos"),
            'total_precios' => $request->total_precios,
        ];
        $id_factura = $this->CrearFactura(
            $metadata["user_id"], $metadata["contacto"], $metadata["direccion"], 
            $metadata["total_precios"], $metadata["ciudad"], $metadata["provincia"], 
            $metadata["codigo_postal"], $metadata["pais"]
        );
        $preference = new MercadoPagoService();
        $data = $preference->crearPreferencia('Productos', $request->total_precios, 1, $metadata, $id_factura);
        $factura = Ticket::findOrFail($id_factura);
        $factura->id_mercadopago = $data["id"];
        $factura->url_payment = $data["url_payment"];
        $factura->update();
        $this->CrearListaDeCompras($id_factura, $metadata["lista_productos"], $metadata["id_productos"]);
        return view('limpiarStorage');
    }
 
    public function CrearFactura($user_id, $contacto, $direccion, $total_precios, $ciudad, $provincia, $codigo_postal, $pais){
        $ticket = new Ticket();
        $date = Carbon::now();
        $ticket->user_id = $user_id;
        $ticket->contacto = $contacto;
        $ticket->direccion = $direccion;
        $ticket->total_precio = $total_precios;
        $ticket->ciudad = $ciudad;
        $ticket->provincia = $provincia;
        $ticket->codigo_postal = $codigo_postal;
        $ticket->pais = $pais;
        $ticket->bool_pagado = 0;
        $ticket->bool_acreditado = 0;
        $ticket->bool_cancelado = 0;
        $ticket->estado = "NO PAGADA";
        $ticket->estado_detallado = "";
        $ticket->fecha_creacion = $date->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $ticket->hora_creacion = $date->toTimeString();
        $ticket->fecha_del_pago = "";
        $ticket->hora_del_pago = "";
        $ticket->save(); 
        return $ticket->id;
    }
    public function CrearListaDeCompras($id_factura, $lista_productos, $id_productos){
        for($i = 0; $i < count($lista_productos); $i++){
            $id_producto = $id_productos[$i]; // id del producto
            //Log::debug($id_producto);
            $lista_colores = $lista_productos[$i]; // colores y productos
            for($j = 0; $j < count($lista_colores); $j++){
                $lista_talles = $lista_colores[$j];
                $id_color = $lista_talles[0]; // id del color
                //Log::debug($id_color);
                for($m = 1; $m < count($lista_talles); $m++){
                    $talles = explode(" ", $lista_talles[$m]); // id talle y cantidad
                    $id_talle = $talles[0];
                    $cantidad_talle = $talles[1];
                    $compra = new Compra();
                    $compra->id_ticket = $id_factura;
                    $compra->id_producto = $id_producto; 
                    $compra->id_color = $id_color;
                    $compra->id_talle = $id_talle;
                    $compra->cantidad = $cantidad_talle;
                    $compra->save();
                    //Log::debug($id_talle." ".$cantidad_talle);
                }
            }
        }
    }
    public function LimpiarStorage(){
        return view('limpiarStorage');
    }
    public function ShowPdf($id){
        $ticket = Ticket::findOrFail($id);
        $pdf = Pdf::loadView('pdf.index', compact('ticket'));
        return $pdf->stream();
    }
    public function DownloadPdf($id){
        $ticket = Ticket::findOrFail($id);
        $pdf = Pdf::loadView('pdf.index', compact('ticket'));
        return $pdf->download('factura.pdf');
    }
}
