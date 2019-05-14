<?php

namespace App\Http\Controllers\Api;

use App\AddDomain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain;
use App\Http\Resources\Domain as DomainResource;
use Intervention\Image\ImageManagerStatic as Image;
use App\ImageUploads;

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

        return new DomainResource($domain);
    }
    public function store(Request $request)
    {
        //save or update domain
        //dd($request);
        if($request->isMethod('put')){
            $domain = Domain::findOrFail($request->domain_id);
            $domain->id = $request->input('domain_id');
            $operationType = 'update';
        } else {
            $domain = new Domain;
            $operationType = 'new';
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

        $additionalDomains = $request->input('additionalDomains');
        //dd($additionalDomains);
        //delete additional domain
        $existingAddDomainIds = []; $postAddDomainIds = [];
        $additionalDomainsExistingIds = AddDomain::select('id')->where('domain_id', '=', $domain->id)->get()->toArray();
        if(is_array($additionalDomainsExistingIds) && !empty($additionalDomainsExistingIds)){
            foreach ($additionalDomainsExistingIds as $additionalDomainsExistingId){
                array_push($existingAddDomainIds, $additionalDomainsExistingId['id']);
            }
        }
        if(is_array($additionalDomains) && !empty($additionalDomains)){
            foreach ($additionalDomains as $additionalDomain){
                if(array_key_exists('id', $additionalDomain)) array_push($postAddDomainIds, $additionalDomain['id']);
            }
        }
        //dd(array_diff($existingAddDomainIds, $postAddDomainIds));
        $additionalDomainsToRemove = array_diff($existingAddDomainIds, $postAddDomainIds);
        if(is_array($additionalDomainsToRemove) && !empty($additionalDomainsToRemove)) {
            foreach ($additionalDomainsToRemove as $additionalDomainToRemove) {
                $_additionalDomainToRemove = AddDomain::where('id', '=', $additionalDomainToRemove)->delete();
            }
        }
        //add new update existing additional domains
        if($additionalDomains && !empty($additionalDomains)){
            foreach ($additionalDomains as $additionalDomain){
                if(!array_key_exists('id',$additionalDomain)){
                    $newAdditionalDomain = new AddDomain();
                    $newAdditionalDomain->domain_id = $domain->id;
                    $newAdditionalDomain->name = $additionalDomain['name'];
                    $newAdditionalDomain->save();
                } else {
                    $existingAdditionalDomain = AddDomain::findOrFail($additionalDomain['id']);
                    $existingAdditionalDomain->name = $additionalDomain['name'];
                    $existingAdditionalDomain->save();
                }
            }
        }

        //dd($image);
        $image = $request->input('screen');
        if(substr_count($image, 'screen') == 0) {
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

            Image::make($request->input('screen'))->save(public_path('screen'.DIRECTORY_SEPARATOR ).$name);
            if(empty($domain->screen()->get()->toArray())){
                $domain_screen = new ImageUploads();
                $domain_screen->domain()->associate($domain);
                $domain_screen->image_path  = 'screen'.DIRECTORY_SEPARATOR.$name;
                $domain_screen->save();
            } else {
                $domain_screen = ImageUploads::where('domain_id', '=', $domain->id)->first();
                $domain_screen->image_path  = 'screen'.DIRECTORY_SEPARATOR.$name;
                $domain_screen->save();
            }
        }

        return json_encode([$operationType => 'success']);
    }
    public function destroy($id)
    {
        //destroy a single domain
        $operationType = 'destroy';
        $domain = Domain::findOrFail($id);
        $domainId = $domain->id;
        $deleteAddDomain = AddDomain::where('domain_id', '=', $domainId)->delete();
        $domain->delete();

        return json_encode([$operationType => 'success', 'domein' => $domainId]);
    }
}
