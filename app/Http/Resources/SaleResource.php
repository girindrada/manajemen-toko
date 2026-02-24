<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          return [
            'id' => $this->id,
            'invoice' => $this->invoice,
            'total_price' => $this->total_price,
            'cashier' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'items' => $this->whenLoaded('details', fn() =>
                $this->details->map(fn($detail) => [
                    'id' => $detail->id,
                    'product' => [
                        'id' => $detail->product->id,
                        'name' => $detail->product->name,
                        'price' => $detail->product->price,
                    ],
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->subtotal,
                ])
            ),
            'created_at' => $this->created_at,
          ];
    }
}
