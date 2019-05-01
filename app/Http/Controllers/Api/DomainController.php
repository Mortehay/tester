<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain;
use App\Http\Resources\Domain as DomainResource;

class DomainController extends Controller
{
    public function getAll()
    {
        $domains = Domain::orderBy('created_at','desc')->paginate(5);
        // returnn collection of domains as a resource
        return  DomainResource::collection($domains);
    }

    public function show($id)
    {
        //get a single domain
        $domain = Domain::findOrFail($id);
        // return a single domain as resource
        return new DomainResource($domain);
    }
    public function store(Request $request)
    {
        //print_r($request);
        //print_r($request->input('image'));
        if($request->isMethod('put')){
            $domain = Domain::findOrFail($request->domain_id);
            $domain->id = $request->input('domain_id');
            $storeType = 'update';
        } else {
            $domain = new Domain;
            $storeType = 'new';
        }
        $domain->name = $request->input('name');
        $domain->link = $request->input('link');
        $domain->hosting_name = $request->input('hosting_name');
        $domain->hosting_link = $request->input('hosting_link');
        $domain->type = $request->input('type');
        $domain->login = $request->input('login');
        $domain->password = $request->input('password');
        $domain->description = $request->input('description');

        $domain->save();
        return json_encode([$storeType=> 'success']);
        /*if($request->input('image') && $request->input('image') != $request->input('screen')){
            $image = $request->input('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

            Image::make($request->input('image'))->save(public_path('screen'.DIRECTORY_SEPARATOR ).$name);

            $image= new FileUploads();
            $image->image_name = $name;
            $image->save();

            $domain->screen = 'screen'.DIRECTORY_SEPARATOR .$name;
        } else {
            if($domain->screen != Null || $domain->logo != ''){
                $domain->screen = $domain->screen;
            } else {
                $domain->screen = 'screen'.DIRECTORY_SEPARATOR .'tmp.jpg';
            }
        }


        if($domain->save()){
            return  new DomainResource($domain);
        }*/

    }
}
