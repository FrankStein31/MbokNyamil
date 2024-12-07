<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdate extends Notification
{
    use Queueable;

    protected $status;
    protected $orderNumber;

    public function __construct($status, $orderNumber)
    {
        $this->status = $status;
        $this->orderNumber = $orderNumber;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Sesuaikan pesan berdasarkan status
        switch($this->status) {
            case 'processing':
                $message = 'Pesanan Anda sedang dalam proses produksi.';
                break;
            case 'shipped':
                $message = 'Pesanan Anda sudah dikirim.';
                break;
            case 'finished':
                $message = 'Pesanan Anda telah selesai.';
                break;
            default:
                $message = 'Pesanan Anda telah dikonfirmasi dan akan diproses.';
        }

        return (new MailMessage)
            ->subject('Status Pesanan #' . $this->orderNumber)
            ->line($message)
            ->line('Terima kasih telah berbelanja di toko kami.');
    }
}