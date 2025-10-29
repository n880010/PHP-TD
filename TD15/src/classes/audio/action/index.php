<?php
declare(strict_types=1);
namespace iutnc\deefy\audio\action;

// Démarre la session 
session_start();

// Autoload des classes 
require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

// Import du Dispatcher
use iutnc\deefy\audio\action\Dispatcher;


$dispatcher = new Dispatcher(); // constructeur récupère $_GET['action']
$dispatcher->run();             // lance l'action correspondante et affiche le HTML
