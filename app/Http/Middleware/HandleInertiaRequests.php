<?php

namespace App\Http\Middleware;

use App\Models\Demande;
use App\Models\User;
use App\Models\Annee;
use App\Models\TermsDocument;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        // dd(auth()->user()->getAllPermissions()->pluck('name'));
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'auth.user' => fn () => $request->user()
                ? $request->user()
                : null,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'user_roles' => fn () => auth()->user()
                ? auth()->user()->getRoleNames()->pluck('name')
                : null,
            'user_permissions' => fn () => auth()->user()
                ? auth()->user()->getAllPermissions()->pluck('name')
                : null,
                // dd(auth()->user()->getAllPermissions()->pluck('name')),
            'user'=> fn () => $request->user() ? User::where('id',$request->user()->id)->with('postulant')->get()[0] : null,
            'terms' => fn () => TermsDocument::all()->keyBy('type')->map(function ($doc) {
                return [
                    'url' => '/documents/terms/' . $doc->filename,
                    'name' => $doc->original_name,
                    'mime' => $doc->mime_type,
                ];
            }),
            'csrf_token' => csrf_token(),
            'en_attentes' => fn () => Demande::where('statut_id',1)->count(),
            'verifiees' => fn () => Demande::where('statut_id',2)->count(),
            'approuvees' => fn () => Demande::where('statut_id',3)->count(),
            'autorisees' => fn () => Demande::where('statut_id',4)->count(),
            'rejetees' => fn () => Demande::where('statut_id',5)->count(),
            'renvoyees' => fn () => Demande::where('statut_id',6)->count(),
            'annulees' => fn () => Demande::where('statut_id',7)->count(),
            'revisees' => fn () => Demande::where('statut_id',8)->count(),
            'recaptcha_site_key' => env('RECAPTCHA_SITE_KEY'),
            'annee_encours' => Annee::where('id',1)->first(),
          
        ]);
    }
}
