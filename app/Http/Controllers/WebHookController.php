<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Ticket;
use App\Models\User;
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
        $factura = Ticket::findOrFail($response->external_reference);
        $date = Carbon::now();
        if($response->status == 'approved')
            $factura->bool_pagado = 1;
        if($response->status == 'cancelled')
            $factura->bool_cancelado = 1;
        if($response->status_detail == 'accredited')
            $factura->bool_acreditado = 1;
        $factura->estado = $this->Traducciones('status', $response);
        $factura->estado_detallado = $this->Traducciones('status_detail', $response);
        $factura->fecha_del_pago = $date->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $factura->hora_del_pago = $date->toTimeString();
        $factura->update();
        $this->EnviarCorreo($response->metadata->email, $factura);
    }
    public function Traducciones($case, $response){
        switch($case){
            case 'status': {
                switch($response->status){
                    case 'pending':
                        return "PENDIENTE";
                        break;
                    case 'approved':
                        return "PAGADO";
                        break;
                    case 'authorized':
                        return "AUTORIZADO";
                        break;
                    case 'in_process':
                        return "EN PROCESO";
                        break;
                    case 'in_mediation':
                        return "EN MEDIACION";
                        break;
                    case 'rejected':
                        return "RECHAZADO";
                        break;
                    case 'cancelled':
                        return "CANCELADO";
                        break;
                    case 'refunded':
                        return "REEMBOLZADO";
                        break;
                    case 'charged_back':
                        return "Se realizó un contracargo en la tarjeta de crédito del comprador";
                        break;
                    default: 
                        return $response->status;
                        break;
                }
                break;
            }
            case 'status_detail':{
                switch($response->status_detail){
                    case 'accredited':
                        return "ACREDITADO";
                        break;
                    case 'pending_contingency':
                        return "PROCESANDO";
                        break;
                    case 'pending_review_manual':
                        return "EN REVISION";
                        break;
                    case 'cc_rejected_bad_filled_date':
                        return "Fecha de caducidad incorrecta";
                        break;
                    case 'cc_rejected_bad_filled_other':
                        return "Detalles de tarjeta incorrectos";
                        break;
                    case 'cc_rejected_bad_filled_security_code':
                        return "CVV incorrecto";
                        break;
                    case 'cc_rejected_blacklist':
                        return "La tarjeta está en una lista negra por robo/denuncia/fraude";
                        break;
                    case 'cc_rejected_call_for_authorize':
                        return "El medio de pago requiere autorización previa del monto de la operación";
                        break;
                    case 'cc_rejected_card_disabled':
                        return "La tarjeta está inactiva";
                        break;
                    case 'cc_rejected_duplicated_payment':
                        return "Transacciones duplicadas";
                        break;
                    case 'cc_rejected_high_risk':
                        return "Rechazada por Prevención de Fraude";
                        break;
                    case 'cc_rejected_insufficient_amount':
                        return "Cantidad insuficiente";
                        break;
                    case 'cc_rejected_invalid_installments':
                        return "Número de cuotas no válido";
                        break;
                    case 'cc_rejected_max_attempts':
                        return "Excedió el número máximo de intentos";
                        break;
                    case 'cc_rejected_other_reason':
                        return "Error genérico";
                        break;
                    case 'pending_waiting_payment':
                        return "Esperando a que el pago sea recibido y aprobado";
                        break;
                    default:
                        return $response->status_detail;
                        break;
                }
            }
            case 'payment_method_id':{
                switch($response->payment_method_id){
                    case 'pix':
                        return "Método de pago digital instantáneo utilizado en Brasil";
                        break;
                    case 'account_money':
                        return "Cuando el pago se debita directamente de una cuenta de Mercado Pago";
                        break;
                    case 'debin_transfer':
                        return "Método de pago digital utilizado en Argentina que debita inmediatamente un monto de una cuenta, solicitando autorización previa";
                        break;
                    case 'ted':
                        return "Es el pago de Transferencia Electrónica Disponible, utilizado en Brasil, que tiene tarifas para ser utilizado. El pago se realiza el mismo día de la transacción, pero para ello es necesario realizar la transferencia dentro del plazo estipulado";
                        break;
                    case 'cvu':
                        return "Método de pago utilizado en Argentina";
                        break;
                    case 'master':
                        return "Metodo de pago Mastercard";
                        break;
                    default: 
                        return $response->payment_method_id;
                        break;
                }
            }
            case 'payment_type_id':{
                switch($response->payment_type_id){
                    case 'account_money':
                        return "Dinero en la cuenta de Mercado Pago";
                        break;
                    case 'ticket':
                        return "Boletos, Caixa Electronica Payment, PayCash y Oxxo, etc";
                        break;
                    case 'atm':
                        return "Pago en cajero automático (muy utilizado en México a través de BBVA Bancomer)";
                        break;
                    case 'credit_card':
                        return "Pago con tarjeta de crédito";
                        break;
                    case 'debit_card':
                        return "Pago con tarjeta de débito";
                        break;
                    case 'prepaid_card':
                        return "Pago con tarjeta prepago";
                        break;
                    case 'digital_currency':
                        return "Compras con Mercado Crédito";
                        break;
                    case 'digital_wallet':
                        return "Paypal";
                        break;
                    case 'voucher_card':
                        return "Beneficios Alelo, Sodexo";
                        break;
                    case 'crypto_transfer':
                        return "Pago con criptomonedas como Ethereum y Bitcoin";
                        break;
                    default:
                        return $response->payment_type_id;
                        break;
                }
            }
            case 'payment_operation_type':{
                switch ($response->payment_operation_type) {
                    case 'investment':
                        return "Pago en inversion";
                        break;
                    case 'regular_payment':
                        return "Tipificación por defecto de una compra siendo pagada a través de Mercado Pago";
                        break;
                    case 'money_transfer':
                        return "Transferencia de fondos entre dos usuarios";
                        break;
                    case 'recurring_payment':
                        return "Debido a una suscripción de usuario activa";
                        break;   
                    case 'account_fund':
                        return "Ingresos de dinero en la cuenta del usuario";
                        break;  
                    case 'payment_addition':
                        return "Mercado Pago";
                        break;        
                    case 'cellphone_recharge':
                        return "Recarga de la cuenta del celular de un usuario";
                        break;  
                    case 'pos_payment'  :
                        return "Pago realizado a través de un Punto de Venta";
                        break;  
                    case 'money_exchange':
                        return "Pago de cambio de moneda para un usuario";
                        break;  
                    default: 
                        return $response->payment_operation_type;
                        break;  
                }
            }
        }
    }
    public function EnviarCorreo($email, $factura){
        $correo = new FacturaMailable($factura);
        Mail::to($email)->send($correo);
    }
}
