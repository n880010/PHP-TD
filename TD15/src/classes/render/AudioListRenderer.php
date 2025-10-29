<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AudioTrack;

class AudioListRenderer implements Renderer {
    private AudioList $al;

    public function __construct(AudioList $a) {
        $this->al = $a;
    }

    public function render(int $selector = 1): string {
        // récupérer les propriétés
        $nom = $this->al->__get('nom');
        $pistes = $this->al->__get('tabAudio');
        $nbPistesAudio = $this->al->__get('nbPistesAudio');
        $dureeTotalAudio = $this->al->__get('dureeTotalAudio');

        // construire le HTML
        $html = "<div class='audio-list'>";
        $html .= "<h2>$nom</h2>";

        // afficher chaque piste
        foreach ($pistes as $piste) {
            if ($piste instanceof AudioTrack) {
                $html .= "<p>" . $piste->__get('titre') . " - " . $piste->__get('artiste') . " (" . $piste->__get('duree') . "s)</p>";
            }
        }

        // infos de fin
        $html .= "<p>Nombre de pistes : $nbPistesAudio</p>";
        $html .= "<p>Durée totale : $dureeTotalAudio secondes</p>";
        $html .= "</div>";

        return $html;
    }
}