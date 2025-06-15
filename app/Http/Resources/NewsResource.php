<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Mengubah model News menjadi array JSON untuk respons API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image_url' => $this->image, // Memberikan nama yang lebih jelas untuk URL gambar
            'body' => $this->body,
            'published_at' => $this->published_at ? $this->published_at->format('Y-m-d H:i:s') : null, // Format tanggal
            'views' => $this->views,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            // Memuat relasi komentar hanya jika sudah di-eager load (misalnya di show method NewsApiController)
            // Menggunakan CommentResource untuk memformat data komentar juga.
            // Pastikan CommentResource juga sudah dibuat jika ini akan digunakan.
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
