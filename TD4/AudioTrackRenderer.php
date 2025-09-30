<?php
declare(strict_types=1);

require_once 'Renderer.php';
abstract class AudioTrackRenderer implements Renderer{
    public function render(int $selector): string {
        switch ($selector) {
            case 1:
                return $this->renderCompact();
            case 2:
                return $this->renderLong();
            default:
                return "<p>Mode d'affichage inconnu.</p>";
        }
    }

}
