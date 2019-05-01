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
        //$addDomain = AddDomain::select('name')->where('domain_id', '=', $this->id)->get()->toArray();
        //$screen = ImageUploads::select('image_path')->where('domain_id', '=', $this->id)->first()->image_path;
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
            //'addDomain' =>$addDomain,
            //'screen' => $screen,
        ];
    }
}
