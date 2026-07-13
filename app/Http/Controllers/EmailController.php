<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(Request $request){
        $mail = Email::where('statut',0)->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->when($request->search, function ($query, $value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })->paginate($request->page_size ?? 10);
        $config = Email::where('statut',1)->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->when($request->search, function ($query, $value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })->paginate($request->page_size ?? 10);
        return Inertia::render('Email/index', [
            'Email' => $mail,
            'config'=>$config
        ]);
    }
    public function store(Request $request){
        if ($request->donnees){
            // dd('send');
            foreach ($request->donnees as $key => $donne) {
                Email::create(['name' => $donne['name']]);
            }
        }else {
            // dd('config');
            Email::create([
                'name' => $request->name,
                'port' => $request->port,
                'host' => $request->host,
                'password' => $request->password,
                'mailer' => $request->mailer,
                'encryption' => $request->encryption,
                'mailer_from' => $request->mail_from,
                'name_from' => $request->name_from,
                'statut' =>1
            ]);
            $this->updateEnv();
        } 
        return redirect()->back()->with('success','E-mail crée avec succès');
    }
    public function update(Request $request,$id){
        $email = Email::find($id);
        $email->name = $request->name;
        $email->port = $request->port;
        $email->host = $request->host;
        $email->password = $request->password;
        $email->mailer = $request->mailer;
        $email->encryption = $request->encryption;
        $email->mail_from = $request->mail_from;
        $email->name_from = $request->name_from;
                
        $email->update();

        $this->updateEnv();
        return redirect()->back()->with('success','E-mail Modifié avec succès');
    }

    public function updateEnv()
    {
        $config = Email::where('statut',1)->first();

        $tabs = [
            'MAIL_MAILER' => $config->mailer,
            'MAIL_HOST' => $config->host,
            'MAIL_PORT' => $config->port,
            'MAIL_USERNAME' => $config->name,
            'MAIL_PASSWORD' => $config->password,
            'MAIL_ENCRYPTION' => $config->encryption,
            'MAIL_FROM_ADDRESS' => $config->mail_from,
            'MAIL_FROM_NAME' => $config->name_from
        ];

        $envFilePath = base_path('.env');

        foreach ($tabs as $key => $tab) {
            // dump($tab,$key);
            
            $keyToModify = $key;
            if($key == 'MAIL_FROM_ADDRESS' || $key == 'MAIL_FROM_NAME' ){
                $newValue = '"' . $tab . '"';
            }else{
                $newValue = $tab;
            }

            $envContent = file_get_contents($envFilePath);

            $searchPattern = "/^{$keyToModify}=.*/m";
            
            $envContent = preg_replace($searchPattern, "{$keyToModify}={$newValue}", $envContent);
            
            file_put_contents($envFilePath, $envContent);

        }
    }

    public function destroy(Request $request,$id){
        $email = Email::find($id);
        $email->delete();
        return redirect()->back()->with('success','E-mail supprimé avec succès');
    }
}