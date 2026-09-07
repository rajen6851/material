<?php

namespace App\Listeners;

use App\Models\CartItem;
use Illuminate\Auth\Events\Login;

class MergeGuestCart
{
    /**
     * Merge the guest's session cart into their account cart after login.
     */
    public function handle(Login $event): void
    {
        $sessionCart = session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $item) {
            $productId = (int) $productId;
            $qty = (int) ($item['quantity'] ?? 0);

            if ($qty <= 0) {
                continue;
            }

            $existing = CartItem::where('user_id', $event->user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                $existing->quantity += $qty;
                $existing->save();
            } else {
                CartItem::create([
                    'user_id' => $event->user->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                ]);
            }
        }

        session()->forget('cart');
    }
}
