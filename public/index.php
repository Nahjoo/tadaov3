<?php

// déclaration des classes PHP qui seront utilisées
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

// activation de la fonction autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
// activer le mode debug et le mode de variables strictes
$twig = new Twig_Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
    ]);
    
    // charger l'extension Twig_Extension_Debug
    $twig->addExtension(new Twig_Extension_Debug());
    
    // création d'une variable avec une configuration par défaut
    $config = new Configuration();
    
    // création d'un tableau avec les paramètres de connection à la BDD
    $connectionParams = [
        'driver'    => 'pdo_mysql',
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'dbname'    => 'bus',
        'user'      => 'nahjo',
        'password'  => 'J0han/62410',
        'charset'   => 'utf8mb4',
    ];
    
    // connection à la BDD
    // la variable `$conn` permet de communiquer avec la BDD
    $conn = DriverManager::getConnection($connectionParams, $config);
    
    $fp = fopen("tadao/gtf/routes.txt", "r"); 
    while($ligne = fgetcsv($fp))
    {
        
        /* On récupère les champs séparés par , dans liste*/
        
        $listes = $ligne;
        error_log(implode("--",$listes));
        
        $towns = $listes[2];
        $splits = explode(" - ", $towns);

        foreach ($splits as $split) {
            echo $listes[0];
            $town_split = $conn->insert('route', [
                'route_id' => $listes[0],
                'route_short_name ' => $listes[1] ,
                'route_long_name ' => $split,
                'route_desc ' => $listes[3],
                'route_type' => $listes[4],
                'route_url' => $listes[5],
                
            ]);
           
            echo $split;
            echo "<br>";

            
        }
    }
    

echo $twig->render('home.html.twig', [
        
        
]);