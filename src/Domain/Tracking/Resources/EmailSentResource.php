<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailSentResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'xid' => $this->xid,
            'sender_name' => $this->sender_name,
            'recipient' => $this->recipient_email,
            'subject' => $this->subject,
            'content' => $this->content,
            'opens' => $this->opens,
            'opened_at' => $this->opened_at,
            'created_at' => $this->created_at,
        ];

        return $data;
    }
}
