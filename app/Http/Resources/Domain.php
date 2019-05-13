<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\AddDomain;
use App\ImageUploads;

class Domain extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $additionalDomains = AddDomain::select('id', 'name')->where('domain_id', '=', $this->id)->get()->toArray();
        $screen = ImageUploads::select('image_path')->where('domain_id', '=', $this->id)->first();
        return [
            'id' =>$this->id,
            'name' =>$this->name,
            'link' =>$this->link,
            'hosting_name' =>$this->hosting_name,
            'hosting_link' =>$this->hosting_link,
            'type' =>$this->type,
            'login' =>$this->login,
            'password' =>$this->password,
            'description' =>$this->description,
            'additionalDomains' =>$additionalDomains,
            'screen' => $screen,
        ];
    }
}
