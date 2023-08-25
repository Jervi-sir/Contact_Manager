<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    private $limit = 5;

    private $rules = [
        'name' => ['required', 'min:5'],
        'company' => ['required'],
        'email' => ['required', 'email'],
        'photo' => ['mimes:jpg,jpeg,png,gif,bmp']
        ];

    private $upload_dir = 'public/uploads';
    public function __construct() 
    {
        $this->upload_dir = base_path() . '/' . $this->upload_dir;
    }

    public function autocomplete(Request $request)
    {
        $group_id = ($request->get('group_id'));
        
        if($request->ajax())
        {
            return Contact::select(['id','name as value'])->where(function($query) use ($request,$group_id)  {
                                if(($term = $request->get("term")))
                                {
                                    $keywords = '%'. $term. '%';
                                    $query->orWhere('name', 'LIKE', $keywords);
                                    $query->orWhere('company', 'LIKE', $keywords);
                                    $query->orWhere('email', 'LIKE', $keywords);
                                }
                    })->orderBy('name','asc')
                    ->take(5)
                    ->get();
            }


    }

    public function index(Request $request) 
    {
        $group_id = ($request->get('group_id'));

    	/* OLD without search form
    	if($group_id){
    		$contacts = Contact::where('group_id', $group_id)->orderBy('updated_at','desc')->paginate(7);
    	}
    	else{
    		$contacts = Contact::orderBy('updated_at','desc')->paginate(7);
    	}
        */

        $contacts = Contact::where(function($query) use ($request,$group_id)  {
                        if($group_id)   
                        {
                            $query->where('group_id', $group_id);
                        }

                        if(($term = $request->get("term")))
                        {
                            $keywords = '%'. $term. '%';
                            $query->orWhere('name', 'LIKE', $keywords);
                            $query->orWhere('company', 'LIKE', $keywords);
                            $query->orWhere('email', 'LIKE', $keywords);
                        }
                    })->orderBy('updated_at','desc')
                      ->paginate(7);


    	return view('contacts.index',compact('contacts'));
    }

    public function create() 
    {
    	return view("contacts.create");
    }

    public function edit($id)
    {
        $contact = Contact::find($id);
        return view("contacts.edit", ['contact' => $contact]);
    }


    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);

        $contact = Contact::find($id);
        $oldPhoto = $contact->photo;

        $data = $this->getRequest($request);
        $contact->update($data);

        if($oldPhoto !== $contact->photo)
        {
            $this->removePhoto($oldPhoto);
        }

        return redirect('contacts')->with('message', 'Contact Updated!');
    }


    public function store(Request $request) 
    {
    	$this->validate($request, $this->rules);
        // echo $request->file('photo')->getClientOriginalName();
        // exit;
        $data = $this->getRequest($request);
    	Contact::create($data);
    	return redirect('contacts')->with('message', 'Contact Saved!');
    }

    private function getRequest(Request $request) 
    {
        $data = $request->all();

        if($request->hasFile('photo'))
        {    
                $photo          = $request->file('photo');
                $fileName       = $photo->getClientOriginalName();
                $destination    = $this->upload_dir;
                $photo->move($destination, $fileName);
                $data = $request->all();
                $data['photo'] = $fileName;
        }

        return $data;
    }


    public function destroy($id)
    {  
        $contact = Contact::find($id);
        $contact->delete();
        $this->removePhoto($contact->photo);

        return redirect('contacts')->with('message', 'Contact Deleted!');
    }

    private function removePhoto($photo)
    {
        if( ! empty($photo))
        {
            $file_path = $this->upload_dir . '/' . $photo;

            if(file_exists($file_path)) unlink($file_path);
        }
    }

}
