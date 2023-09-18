<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'id_mercadopago',
        'user_id',
        'status',
        'status_detail',
        'status_product',
        'statement_descriptor',
        'transaction_amount',
        'transaction_amount_refunded',
        'transaction_amount_recibido',
        'coupon_amount',
        'date_created',
        'date_aproved',
        'date_of_expiration',
        'date_entregado',
        'date_entrega_aprox',
        'differential_pricing_id',
        'deduction_schema',
        'money_release_date',
        'money_release_schema',
        'payment_method_id',
        'payment_type_id',
        'payment_description',
        'payment_operation_type',
        'payment_authorization_code',
        'payment_currency_id',
        'payment_method_captured',
        'payment_installments_cuotas',
        'payment_payer_first_name',
        'payment_payer_email',
        'payment_payer_dni',
        'payment_payer_phone_area',
        'payment_payer_phone_number',
        'contacto',
        'direccion',
        'total_precio',
        'detalles',
    ];

    public function User():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function estadoTicket(){
        $status = $this->status;
        switch($status){
            case 'pending':
                $status = "El usuario no ha concluido el proceso de pago";
                break;
            case 'approved':
                $status = "El pago ha sido aprobado y acreditado";
                break;
            case 'authorized':
                $status = "El pago ha sido autorizado pero aún no capturado";
                break;
            case 'in_process':
                $status = "El pago esta en proceso";
                break;
            case 'in_mediation':
                $status = "El usuario inició una disputa";
                break;
            case 'rejected':
                $status = "El pago fue rechazado (el usuario puede intentar pagar de nuevo)";
                break;
            case 'cancelled':
                $status = "El pago fue cancelado por una de las partes o venció";
                break;
            case 'refunded':
                $status = "El pago fue devuelto al usuario";
                break;
            case 'charged_back':
                $status = "Se realizó un contracargo en la tarjeta de crédito del comprador";
                break;
            default: 
                $status = $this->status;
                break;
        }
        return $status;
    }

    public function EstadoDetallado(){
        $status = $this->status_detail;
        switch($status){
            case 'accredited':
                $status = "El pago ha sido acreditado";
                break;
            case 'pending_contingency':
                $status = "El pago se está procesando";
                break;
            case 'pending_review_manual':
                $status = "El pago se encuentra en revisión para determinar su aprobación o rechazo";
                break;
            case 'cc_rejected_bad_filled_date':
                $status = "Fecha de caducidad incorrecta";
                break;
            case 'cc_rejected_bad_filled_other':
                $status = "Detalles de tarjeta incorrectos";
                break;
            case 'cc_rejected_bad_filled_security_code':
                $status = "CVV incorrecto";
                break;
            case 'cc_rejected_blacklist':
                $status = "La tarjeta está en una lista negra por robo/denuncia/fraude";
                break;
            case 'cc_rejected_call_for_authorize':
                $status = "El medio de pago requiere autorización previa del monto de la operación";
                break;
            case 'cc_rejected_card_disabled':
                $status = "La tarjeta está inactiva";
                break;
            case 'cc_rejected_duplicated_payment':
                $status = "Transacciones duplicadas";
                break;
            case 'cc_rejected_high_risk':
                $status = "Rechazada por Prevención de Fraude";
                break;
            case 'cc_rejected_insufficient_amount':
                $status = "Cantidad insuficiente";
                break;
            case 'cc_rejected_invalid_installments':
                $status = "Número de cuotas no válido";
                break;
            case 'cc_rejected_max_attempts':
                $status = "Excedió el número máximo de intentos";
                break;
            case 'cc_rejected_other_reason':
                $status = "Error genérico";
                break;
            case 'pending_waiting_payment':
                $status = "Esperando a que el pago sea recibido y aprobado";
                break;
            default:
                $status = $this->status_detail;
                break;
        }
        return $status;
    }

    public function MetodoDePago(){
        $metodo = $this->payment_method_id;
        switch($metodo){
            case 'pix':
                $metodo = "Método de pago digital instantáneo utilizado en Brasil";
                break;
            case 'account_money':
                $metodo = "Cuando el pago se debita directamente de una cuenta de Mercado Pago";
                break;
            case 'debin_transfer':
                $metodo = "Método de pago digital utilizado en Argentina que debita inmediatamente un monto de una cuenta, solicitando autorización previa";
                break;
            case 'ted':
                $metodo = "Es el pago de Transferencia Electrónica Disponible, utilizado en Brasil, que tiene tarifas para ser utilizado. El pago se realiza el mismo día de la transacción, pero para ello es necesario realizar la transferencia dentro del plazo estipulado";
                break;
            case 'cvu':
                $metodo = "Método de pago utilizado en Argentina";
                break;
            case 'master':
                $metodo = "Metodo de pago Mastercard";
                break;
            default: 
                $metodo = $this->payment_method_id;
                break;
        }
        return $metodo;
    }

    public function MetodoDePagoId(){
        $metodo = $this->payment_type_id;
        switch($metodo){
            case 'account_money':
                $metodo = "Dinero en la cuenta de Mercado Pago";
                break;
            case 'ticket':
                $metodo = "Boletos, Caixa Electronica Payment, PayCash y Oxxo, etc";
                break;
            case 'atm':
                $metodo = "Pago en cajero automático (muy utilizado en México a través de BBVA Bancomer)";
                break;
            case 'credit_card':
                $metodo = "Pago con tarjeta de crédito";
                break;
            case 'debit_card':
                $metodo = "Pago con tarjeta de débito";
                break;
            case 'prepaid_card':
                $metodo = "Pago con tarjeta prepago";
                break;
            case 'digital_currency':
                $metodo = "Compras con Mercado Crédito";
                break;
            case 'digital_wallet':
                $metodo = "Paypal";
                break;
            case 'voucher_card':
                $metodo = "Beneficios Alelo, Sodexo";
                break;
            case 'crypto_transfer':
                $metodo = "Pago con criptomonedas como Ethereum y Bitcoin";
                break;
            default:
                $metodo = $this->payment_type_id;
                break;
        }
        return $metodo;
    }
    public function Compras(){
        $compras = Compra::where('id_ticket', $this->id)->orderBy('created_at', 'desc')->get();
        return $compras;
    }
}
