<?php
echo "<!DOCTYPE html>\n";
echo "<html lang='fr'>\n";
echo "<head>\n";
echo "  <meta charset='UTF-8'>\n";
echo "  <title>Exercice PHP</title>\n";
echo "</head>\n";
echo "<body>\n";

$v1 = 42;
$v2 = 73;

echo "<h2>Somme et différence</h2>\n";
echo "<p>La somme de v1 et v2 est : " . ($v1 + $v2) . "</p>\n";
echo "<p>La différence de v1 et v2 est : " . ($v1 - $v2) . "</p>\n";

echo "<h2>Types initiaux</h2>\n";
echo "<p>Le type de v1 est : " . gettype($v1) . "</p>\n";
echo "<p>Le type de v2 est : " . gettype($v2) . "</p>\n";

$v1 = "442";
echo "<h2>Après affectation</h2>\n";
echo "<p>La nouvelle valeur de v1 est : $v1</p>\n";
echo "<p>Le type de v1 est maintenant : " . gettype($v1) . "</p>\n";
echo "<p>La somme de v1 et v2 est : " . ($v1 + $v2) . "</p>\n";
echo "<p>Ici, PHP a converti la chaîne \"442\" en entier pour faire l’addition.</p>\n";

$v3 = 1337;
echo "<p>La variable v3 est de type " . gettype($v3) . " et a pour valeur : $v3</p>\n";

$v4 = 01337;
echo "<p>La variable v4 est de type " . gettype($v4) . " et a pour valeur : $v4</p>\n";

$v5 = 0x1337;
echo "<p>La variable v5 est de type " . gettype($v5) . " et a pour valeur : $v5</p>\n";

$v6 = 3.14159;
echo "<p>La variable v6 est de type " . gettype($v6) . " et a pour valeur : $v6</p>\n";

$v7 = "yopyop";
echo "<p>La variable v7 est de type " . gettype($v7) . " et a pour valeur : $v7</p>\n";

$v8 = 'yepyep';
echo "<p>La variable v8 est de type " . gettype($v8) . " et a pour valeur : $v8</p>\n";

$v9 = true;
echo "<p>La variable v9 est de type " . gettype($v9) . " et a pour valeur : ";
echo $v9;
echo "</p>\n";

$v10 = false;
echo "<p>La variable v10 est de type " . gettype($v10) . " et a pour valeur : ";
echo $v10;
echo "</p>\n";

echo "<h2>Affichage avec quotes</h2>\n";
echo "variable v1 : $v1<br>\n";   // double quotes → interprète la variable
echo 'variable v2 : $v2<br>' . "\n"; // simple quotes → affiche littéralement $v2 ( ne marche pas)

echo "<h2>Sans concaténation</h2>\n";
printf("la variable \$v1 vaut %d<br>\n", 42);
printf("la variable \"\$v2\" vaut %d<br>\n", 73);

echo "</body>\n";
echo "</html>\n";
