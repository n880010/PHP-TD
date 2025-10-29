<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\PodcastTrack;

class PodcastTrackRenderer extends AudioTrackRenderer {
    private PodcastTrack $pod;

    public function __construct(PodcastTrack $pod) {
        $this->pod = $pod;
    }

    public function renderCompact(): string {
        return <<<HTML
<div class="podcast-track compact">
    <strong>{$this->pod->__get('titre')}</strong> - {$this->pod->__get('nom_emission')}
    <audio controls>
        <source src="{$this->pod->__get('nom_fichier_audio')}" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio>
</div>
HTML;
    }

    public function renderLong(): string {
        return <<<HTML
<div class="podcast-track long">
    <h2>{$this->pod->__get('titre')}</h2>
    <p>Émission : {$this->pod->__get('nom_emission')}</p>
    <p>Animateur : {$this->pod->__get('animateur')}</p>
    <p>Artiste : {$this->pod->__get('artiste')}</p>
    <p>Durée : {$this->pod->__get('duree')} secondes</p>
    <p>Genre : {$this->pod->__get('genre')}</p>
    <audio controls>
        <source src="{$this->pod->__get('nom_fichier_audio')}" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio>
</div>
HTML;
    }
}