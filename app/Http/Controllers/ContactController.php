<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Home');
    }

    public function searchContacts(Request $request)
    {
        $contacts = Contact::where('name', 'LIKE','%'.$request->contact.'%')->get();
        return response()->json($contacts);
    }

    public function getContacts()
    {
        $contacts = Contact::orderBy('name')->get();
        return response()->json($contacts);
    }

    public function getContact(Request $request)
    {
        $contact = Contact::where('id',$request->id)->first()->toArray();
        return response()->json($contact);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required',
            'photo' => 'max:8000|mimes:jpg,png,jpeg',
        ];

        $message = [
            'name.required'=>'É necessário designar um nome para o contato',
            'photo.size'  => 'O tamanho da imagem não poderá exceder 8mb',
            'photo.mimes' => 'Apenas os formatos jpg, png e jpeg são suportados',
        ];

        $request->validate($rules, $message);

        $contact = new Contact();
        $contact->name            = $request->name;
        $contact->type_of_contact = $request->contact_type;
        $contact->phone           = $request->phone;
        $contact->email           = $request->email;
        $contact->cep             = $request->cep;
        $contact->city            = $request->city;
        $contact->address         = $request->address;
        $contact->address_number  = $request->address_number;
        $contact->neighborhood    = $request->neighb;


        if($request->photo)
        {
            $file_name = uniqid('img_').'.'.$request->photo->extension();
            $path = $request->photo->storeAs('public/contact', $file_name);
            $contact->photo = $file_name;
        }

        $contact->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name'  => 'required',
            'photo' => 'max:8000|mimes:jpg,png,jpeg',
        ];

        $message = [
            'name.required'=>'É necessário designar um nome para o contato',
            'photo.size'  => 'O tamanho da imagem não poderá exceder 8mb',
            'photo.mimes' => 'Apenas os formatos jpg, png e jpeg são suportados',
        ];

        $request->validate($rules, $message);

        $contact = Contact::where('id',$id);
        $contact->update([
            'name'            => $request->name,
            'type_of_contact' => $request->type,
            'phone'           => $request->phone,
            'email'           => $request->email,
            'cep'             => $request->cep,
            'city'            => $request->city,
            'address'         => $request->address,
            'address_number'  => $request->number,
            'neighborhood'    => $request->neighb,
        ]);
       
    }
    public function changePhoto(Request $request)
    {
        
        $rules = [
            'photo' => 'max:8000|mimes:jpg,png,jpeg',
        ];

        $message = [
            'photo.size'  => 'O tamanho da imagem não poderá exceder 8mb',
            'photo.mimes' => 'Apenas os formatos jpg, png e jpeg são suportados',
        ];

        $request->validate($rules, $message);

        $contact = Contact::where('id', $request->id);

        if($request->photo)
        {
            $data = $contact->first();

            if($data->photo)
            {
                $deleted   = Storage::delete('/public/contact/'.$data->photo);
            }

            $file_name = uniqid('img_').'.'.$request->photo->extension();
            $path = $request->photo->storeAs('public/contact', $file_name);
           
            $contact->update([
                'photo'=>$file_name
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $contact =  Contact::where('id',$id);

       $content = $contact->first();

       if($content && $content->photo)
       {
            $deleted = Storage::delete('/public/contact/'.$content->photo);
       }
       $contact->delete();
    }
}
