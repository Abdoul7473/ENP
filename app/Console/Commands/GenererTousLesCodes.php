<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Demande;
use App\Models\TypeAutorisation;
use App\Models\Route;
use App\Models\NumAutorisation;
use Carbon\Carbon;

class GenererTousLesCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generer-code-pour-tous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les codes pour tous les enregistrements existants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demandes = Demande::with('type_demande', 'type_vol', 'user.postulant')->get();

        foreach ($demandes as $demande) {
            $frais = getPrixAutorisation($demande); // utilisé si besoin plus tard

            $routeIds = Route::where('demande_id', $demande->id)->pluck('id')->toArray();

            $numeros = NumAutorisation::whereIn('route_id', $routeIds)
                ->with('route.ville_arrive', 'route.ville_depart')
                ->get();

            if ($numeros->isNotEmpty()) {
                $this->info("Traitement de la demande ID: {$demande->id}");

                // Détermination du type d'autorisation
                if ($demande->permanant == 1) {
                    $type_auto = TypeAutorisation::find(3);
                    $caracteres = moisVersCaracteres($demande->nbre_mois);
                } else {
                    $type_auto = match (true) {
                        $demande->type_vol_id == 4 => TypeAutorisation::find(4),
                        $demande->type_demande_id == 1 => TypeAutorisation::find(2),
                        default => TypeAutorisation::find(1),
                    };
                }

                foreach ($numeros as $index => $numero) {
                    if ($numero->code == null) {
                        $type = checkTypeAuto($numero->route->ville_arrive, $numero->route->ville_depart);

                        if ($numero->statut == 1) {
                            $code = $demande->permanant == 1
                                ? "NE-V" . date('y') . "{$numero->numero}R"
                                : "NE-{$type}" . date('y') . "{$numero->numero}R";
                        } else {
                            if ($demande->permanant == 1) {
                                $caractere = $caracteres[$index % count($caracteres)];
                                $code = "NE-{$type}" . date('y') . "{$numero->numero}{$caractere}";
                            } else {
                                $urgence = Carbon::parse($demande->date_demande)->diffInDays($numero->route->date_route) > 4 ? 'N' : 'U';
                                $code = $type_auto->id == 4
                                    ? "NE-" . date('y') . "{$numero->numero}"
                                    : "NE-{$type}" . date('y') . "{$numero->numero}{$urgence}";
                            }
                        }

                        $ref_article = getNumeroFromCode($code);
                        $numero->update([
                            'code' => $code,
                            'ref_article' => $ref_article,
                        ]);
                    }
                }
            }
        }

        $this->info("✅ Tous les codes ont été générés et enregistrés avec succès.");
    }
}
