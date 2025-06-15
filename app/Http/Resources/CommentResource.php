<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource // Hanya satu kali deklarasi kelas
{
    /**
     * Transform the resource into an array.
     * Mengubah model Comment menjadi array JSON untuk respons API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'news_id' => $this->news_id,
            'parent_id' => $this->parent_id,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'body' => $this->body,
            'approved' => (bool) $this->approved, // Konversi ke boolean eksplisit
            'posted_at' => $this->created_at->diffForHumans(), // Contoh: "5 minutes ago"
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Waktu pembuatan lengkap
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Waktu pembaruan lengkap
            // Memuat balasan secara rekursif hanya jika sudah di-eager load (melalui with('replies') di controller)
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
        ];
    }
}
