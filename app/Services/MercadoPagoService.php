<?php
namespace App\Services;

use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPagoService{

    public function __construct()
    {
        SDK::setAccessToken(config('services.mercadopago.token'));
    }

    public function crearPreferencia($title, $price, $quantity, $metadata, $id_factura){
        $preference = new Preference();
        $item = new Item();
        $item->title = $title;
        $item->quantity = $quantity;
        $item->unit_price = $price;
        $preference->items = [$item];
        $preference->back_urls = [
            'success' => url('?msg=sucess'),
            'failure' => url('?msg=failure'),
            'pending' => url('?msg=pending'),
        ];
        $preference->metadata = $metadata;
        $preference->auto_return = 'approved';
        $preference->external_reference = $id_factura;
        $preference->save();
        return [
            'id' => $preference->id,
            'collector_id' => $preference->collector_id,
            'url_payment' => $preference->init_point
        ];
    }
    public function obtenerPago(){

    }

}