<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Ticket;
use App\Models\Producto;
use App\Models\Compra;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\FacturaMailable;

class WebHookController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        if($request->action == 'test.created'){
            Log::debug("Webhook de prueba recibido");
            return;
        }
        $id_mercadopago = $request->data_id; // obtenemos el id
        $respuesta = Http::get("https://api.mercadopago.com/v1/payments/$id_mercadopago"."?access_token=".env('MP_ACCESS_TOKEN'));
        $response = json_decode($respuesta);
        Log::debug("Ticket nro: ".$id_mercadopago. " paso por aqui!!");
        $id_factura = $this->CrearFactura($response, $id_mercadopago, $response->metadata->telefono, $response->metadata->direccion, $response->metadata->total_precios);
        $factura = Ticket::findOrFail($id_factura);
        $this->CrearListaDeCompras($id_factura, $response->metadata->lista_productos, $response->metadata->id_productos);
        $this->EnviarCorreo($response->metadata->email, $factura);
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

    public function EnviarCorreo($email, $factura){
        $correo = new FacturaMailable($factura);
        Mail::to($email)->send($correo);
    }

    public function CrearFactura($response, $id_mercadopago, $contacto, $direccion, $precio){
        $user_id = $response->metadata->user_id;
        $status = $response->status;
        $status_detail = $response->status_detail;
        $status_product = "Sin entregar";
        $statement_descriptor = $response->statement_descriptor;
        $transaction_amount = $response->transaction_amount;
        $transaction_amount_refunded = $response->transaction_amount_refunded;
        $transaction_amount_recibido = null;
        $transaction_amount_recibido_object = $response->transaction_details;
        if($transaction_amount_recibido_object != null){
            $transaction_amount_recibido_object = (array)$transaction_amount_recibido_object;
            $transaction_amount_recibido = $transaction_amount_recibido_object['net_received_amount'];
        }
        $coupon_amount = $response->coupon_amount;
        $date_created = $response->date_created;
        $date_approved = $response->date_approved;
        $date_of_expiration = $response->date_of_expiration;
        $date_entregado = "Sin entregar";
        $date_entregado_aprox = "3 dias";
        $differential_pricing_id = $response->differential_pricing_id;
        $deduction_schema = $response->deduction_schema;
        $money_release_date = $response->money_release_date;
        $money_release_schema = $response->money_release_schema;
        $payment_method_id = $response->payment_method_id;
        $payment_type_id = $response->payment_type_id;
        $payment_description = $response->description;
        $payment_operation_type = $response->operation_type;
        $payment_authorization_code =  $response->authorization_code;
        $payment_currency_id = $response->currency_id;
        $payment_method_captured = $response->captured;
        $payment_installments_cuotas = $response->installments;
        $payment_payer_first_name = null;
        $payment_payer_email = null;
        $payment_payer_dni = null;
        $payment_payer_phone_area = null;
        $payment_payer_phone_number = null;
        $payment_payer = $response->payer;
        if($payment_payer != null){
            $payment_payer = (array)$payment_payer;
            $payment_payer_first_name = $payment_payer['first_name'];
            $payment_payer_email = $payment_payer['email'];
            $payment_payer_dni = (array)$payment_payer['identification'];
            $payment_payer_dni = $payment_payer_dni['number'];
            $payment_phone = (array)$payment_payer['phone'];
            if($payment_phone != null){
                $payment_payer_phone_area = $payment_phone['area_code'];
                $payment_payer_phone_number = $payment_phone['number'];
            }
        }
        $ticket = new Ticket();
        $ticket->id_mercadopago = $id_mercadopago;
        $ticket->user_id = $user_id;
        $ticket->status = $status;
        $ticket->status_detail = $status_detail;
        $ticket->status_product = $status_product;
        $ticket->statement_descriptor = $statement_descriptor;
        $ticket->transaction_amount = $transaction_amount;
        $ticket->transaction_amount_refunded = $transaction_amount_refunded;
        $ticket->transaction_amount_recibido = $transaction_amount_recibido;
        $ticket->coupon_amount = $coupon_amount;
        $ticket->date_created = $date_created;
        $ticket->date_aproved = $date_approved;
        $ticket->date_of_expiration = $date_of_expiration;
        $ticket->date_entregado = $date_entregado;
        $ticket->date_entrega_aprox = $date_entregado_aprox;
        $ticket->differential_pricing_id = $differential_pricing_id;
        $ticket->deduction_schema = $deduction_schema;
        $ticket->money_release_date = $money_release_date;

        if($money_release_schema == 'payment_in_flow')
            $ticket->money_release_schema = "Pago en cuotas";
        else
            $ticket->money_release_schema = $money_release_schema;

        $ticket->payment_method_id = $payment_method_id;
        $ticket->payment_type_id = $payment_type_id;
        $ticket->payment_description = $payment_description;
        $ticket->payment_operation_type = $payment_operation_type;
        $ticket->payment_authorization_code = $payment_authorization_code;
        $ticket->payment_currency_id = $payment_currency_id;
        $ticket->payment_method_captured = $payment_method_captured;
        $ticket->payment_installments_cuotas = "Cuotas: ".$payment_installments_cuotas;
        $ticket->payment_payer_first_name = $payment_payer_first_name;
        $ticket->payment_payer_email = $payment_payer_email;
        $ticket->payment_payer_dni = $payment_payer_dni;
        $ticket->payment_payer_phone_area = $payment_payer_phone_area;
        $ticket->payment_payer_phone_number = $payment_payer_phone_number;
        $ticket->contacto = $contacto;
        $ticket->direccion = $direccion;
        $ticket->total_precio = $precio;
        $ticket->save(); 
        return $ticket->id;
    }
}
