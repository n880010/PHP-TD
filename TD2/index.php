<?php 
// Exercice  Construire une fonction qui reçoit deux nombre en paramètre et retourne le plus grand. 
// La fonction s'applique à des entiers et des float uniquement.

declare(strict_types=1);

function maximum(int|float $a , int|float $b):int|float{
    $c = ($a>$b) ? $a : $b;
    return $c;
}
echo "Le maximum de 2 et 5 est " . maximum(2,5);


// Construire une fonction php qui affiche les entiers de $max (argument de la fonction) à 0.
//De plus, lorsque l'entier courant est divisible par $div (argument de la fonction, avec une
//valeur par défaut de 2) affiche à côté de l'entier la chaine "divisible par div".
function afficherEntiers(int $max , int $div=2):void{
    for ($i=$max;$i>=0;$i--){
        echo "<br>$i ";
        if ($i % $div ==0){
            echo "divisible par $div";
        }
    }
}
echo "<br>";
echo "Les entiers de 5 inclus a 0 sont : ";
afficherEntiers(5);
//Exercice 3
//Construire une fonction php qui reçoit deux nombres x et n et retourne xn
//. Le calcul doit être
//réalisé en utilisant une boucle while.
function puissance(int|float $x, int $n): int|float {
    $i = $n;
    $result = 1;

    while ($i != 0) {
        $result = $result * $x;
        $i--;
    }

    return $result;
}

echo "<br>";
echo "<br>";
echo "2 puissance 5 fait : " . puissance(2,5);

// Exercice 4
//Construire une fonction qui reçoit 3 paramètres qui sont des nombres.
//n utilisant la construction switch, la fonction appelle :
// lorsque le premier argument vaut 1 : la fonction de l'exercice 1 en lui passant les deux
//arguments suivants en paramètre,
// lorsque le premier argument vaut 2 : la fonction de l'exercice 2 en lui passant les deux
//arguments suivants en paramètre,
// lorsque le premier argument vaut 3 : la fonction de l'exercice 3 en lui passant les deux
//arguments suivants en paramètre.
//Faites en sorte d'éviter les erreurs de types en contrôlant quand c'est nécessaire les types des
//valeurs avant de les transmettre aux fonctions appelées. Pour cela, vous pouvez chercher dans
//la documentation et utiliser des fonctions de test de type : is_type( mixed $v): bool

function exo4(int $a, int|float $b, int|float $c): void {
    echo "<br>";
    switch ($a) {
        case 1:
            echo "Résultat maximum : " . maximum($b, $c) . "<br>";
            break;
        case 2:
            echo "Affichage des entiers :<br>";
            afficherEntiers((int)$b, (int)$c); 
            break;
        case 3:
            echo ((is_int($b)||is_float($b))&&is_int($c))?"Bon Type \n".puissance($b,$c):"Type Error";
            break;
        default:
            echo "Valeur de \$a non valide (1, 2 ou 3)<br>";
    }
}


exo4(1,4,5);
echo "<br>";
exo4(2,4,5.5);
echo "<br>";

exo4(3,4,5);
echo "<br>";

exo4(3,4,5.5);
echo "<br>";
