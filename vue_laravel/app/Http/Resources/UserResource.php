<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

     //필터링 처리를 해주기 위함
    public function toArray($request)
    {
        //모든 정보를 다 리턴하는 것 toArray()
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,
        ];        
    }

    //withResponse 메소드를 사용하면, 리스폰스 보낼때 헤더값을 원하는대로 정해줄 수 있다.
    public function withResponse($request, $response){
        $response->header('X-Value', 'True');
    }
}
