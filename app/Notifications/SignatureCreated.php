<?php

namespace App\Notifications;

use App\Models\{Item, Signature};
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SignatureCreated extends Notification
{
    use Queueable;

    public function __construct(
        protected readonly Item $item,
        protected readonly Signature $signature,
        protected readonly int $quantity
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => __('app.signature.notification', [
                'name'     => $this->signature->name,
                'phone'    => blank($this->signature->phone) ? 'N/A' : $this->signature->phone,
                'item'     => $this->item->name,
                'category' => $this->item->category->name,
                'quantity' => $this->quantity,
            ]),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
