<?php

declare(strict_types=1);

$playlist = [
    "nom"      => "my personal best of",
    "genre"    => "rock",
    "createur" => "john doe",
    "date"     => "28-08-2022",
    "nbpistes" => 56,
    "duree"    => 10800
];

function display(array $pl): void {
    echo "<br>";
    echo "playlist : " . $pl["nom"] . " (" . $pl["genre"] . ") <br> ";
    echo "par " . $pl["createur"] . " le " . $pl["date"] . "<br>";
    echo $pl["nbpistes"] . " pistes pour une durée totale de " . $pl["duree"] . " s";
}

display($playlist);

$piste1 = [
    "titre"   => "Bohemian Rhapsody",
    "artiste" => "Queen",
    "album"   => "A Night at the Opera",
    "annee"   => 1975,
    "genre"   => "Rock",
    "numero"  => 1,
    "duree"   => 354
];

$piste2 = [
    "titre"   => "Smells Like Teen Spirit",
    "artiste" => "Nirvana",
    "album"   => "Nevermind",
    "annee"   => 1991,
    "genre"   => "Grunge",
    "numero"  => 1,
    "duree"   => 301
];

$piste3 = [
    "titre"   => "Imagine",
    "artiste" => "John Lennon",
    "album"   => "Imagine",
    "annee"   => 1971,
    "genre"   => "Pop Rock",
    "numero"  => 1,
    "duree"   => 183
];

function display_track(array $tr, string $mode="court"): void {
    if ($mode=="court") {
        echo $tr["titre"]. " - " . "by " . $tr["artiste"] . " (from ". $tr["album"].")";
    }
    elseif ($mode=="complet"){
        echo $tr["numero"]."- ".$tr["titre"] . " - " . "by " . $tr["artiste"] . " (from ". $tr["album"].") -" . $tr["duree"] . " s";
    }
    elseif ($mode=="etendu"){
        echo $tr["numero"]."- ".$tr["titre"] . " - " . "by " . $tr["artiste"] . " (from ". $tr["album"].", ". $tr["annee"] . ") -" . $tr["duree"] . " s : " .  $tr["genre"];
    }
}

echo display_track($piste1);
echo "<br>";
echo display_track($piste1,"complet");
echo "<br>";
echo display_track($piste1,"etendu");
echo "<br>";

function play_track(array $piste):void{
    echo "<br>";
    echo $piste["titre"];
    echo "<br>";
    $duree = $piste["duree"];
    for ($i=1;$i<=$duree;$i++){
        echo $i . ".";
    }
}

play_track($piste1);


function add_track(array &$pl,array $tr):array{
    $pl["pistes"][]=$tr;
    $pl["nbpistes"]+=1;
    $pl["duree"]+=$tr["duree"];
    return $pl;
}

$new_playlist = [
    "pistes"   => [],
    "nom"      => "my personal best of",
    "genre"    => "rock",
    "createur" => "john doe",
    "date"     => "28-08-2022",
    "nbpistes" => 56,
    "duree"    => 10800
];

$result1 = add_track($new_playlist,$piste1);


// compléter la fonction d'affichage d'une playlist pour quelle affiche la liste des pistes. Chaque
//piste est affichée en mode court, précédée d'un numéro d'ordre dans la liste :

function display_playlist_2(array $pl): void {
    echo "<br>";
    display($pl);
    $i = 1;
    foreach($pl["pistes"] as $piste) {
        echo "<br>" . $i . ". ";
        display_track($piste); 
        $i++;
    }
}





$result2 = add_track($new_playlist,$piste2);
$result3 = add_track($new_playlist,$piste3);

display_playlist_2($new_playlist);


function play(array $pl): void {
    echo "<br>";
    foreach($pl["pistes"] as $piste) {
        echo "<br>";
        play_track($piste); 
    }
}

play($new_playlist);

function remove_track(array &$playlist, int $numero): void {
    if (isset($playlist["pistes"][$numero-1])){
        $duree_temp = $playlist["pistes"][$numero-1]["duree"];
        unset($playlist["pistes"][$numero-1]);
        $playlist["pistes"]  = array_values($playlist["pistes"]);
        $playlist["nbpistes"] = count($playlist["pistes"]);
        $playlist["duree"] -= $duree_temp;
    }}


