<?php
declare(strict_types=1);

require_once 'AlbumTrack.php';
require_once 'AudioTrackRenderer.php';




class AlbumTrackRenderer extends AudioTrackRenderer{
    private AlbumTrack $track;

    // Constructeur : on reçoit un objet AlbumTrack
    public function __construct(AlbumTrack $track) {
        $this->track = $track;
    }

    /**
     * Génère le HTML de la piste selon le mode sélectionné
     * @param int $selector 1 = compact, 2 = long
     * @return string HTML de la piste
     */

    // Mode compact : affichage simple en liste
    public function renderCompact(): string {
        return <<<HTML
<div class="album-track compact">
    <strong>{$this->track->titre}</strong> - {$this->track->artiste}
    <audio controls>
        <source src="{$this->track->nom_fichier_audio}" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio>
</div>
HTML;
    }

    // Mode long : affichage détaillé
    public function renderLong(): string {
        return <<<HTML
<div class="album-track long">
    <h2>{$this->track->titre}</h2>
    <p>Artiste : {$this->track->artiste}</p>
    <p>Album : {$this->track->album}</p>
    <p>Numéro de piste : {$this->track->num_piste}</p>
    <p>Année : {$thxis->track->annee}</p>
    <p>Genre : {$this->track->genre}</p>
    <p>Durée : {$this->track->duree} secondes</p>
    <audio controls>
        <source src="{$this->track->nom_fichier_audio}" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio>
</div>
HTML;
    }
}
