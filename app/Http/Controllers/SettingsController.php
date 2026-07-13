<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $maxUnpaid = AppSetting::where('key', 'max_unpaid_demandes')->value('value');

        return Inertia::render('settings/index', [
            'max_unpaid_demandes' => $maxUnpaid !== null ? (int) $maxUnpaid : 2,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'max_unpaid_demandes' => ['required', 'integer', 'min:0', 'max:100'],
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'integer' => 'Le champ :attribute doit être un entier.',
            'min' => 'Le champ :attribute doit être supérieur ou égal à 0.',
            'max' => 'Le champ :attribute doit être inférieur ou égal à 100.',
        ]);

        AppSetting::updateOrCreate(
            ['key' => 'max_unpaid_demandes'],
            ['value' => (string) $request->max_unpaid_demandes]
        );

        return redirect()->back()->with('success', 'Configuration mise à jour.');
    }
}
