<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code by HugoTby</title>
    <style>
        .center {display: flex;justify-content: center;align-items: center;height: 100vh;}
        .error {background: rgba(255, 0, 0, 0.4);padding: 10px;border-radius: 5px;}
    </style>
</head>
<body>
    <div class="center">
    
        <?php
        // [FR] Dans le code ci-dessous nous définiront aux lignes 39, 43 et 53 que l'adresse IP de l'utilisateur dois se situer en France.
        // [FR] In the code below we will define in lines 39, 43 and 53 that the IP address of the user must be located in France.


        // [GB] On include le fichier codes.php pour récupérer par la suite le nom et le drapeau du pays d'origine de l'adresse IP
        // [GB] We include the codes.php file to retrieve the name and flag of the country of origin of the IP address
        include("codes.php");




        // [FR] On utilise la fonction `file_get_contents` pour obtenir les informations géographiques à partir de l'adresse IP ( avec -> ipinfo.io )
        // [GB] We use the `file_get_contents` function to get the geographical information from the IP address ( with -> ipinfo.io )
        $ip = $_SERVER['REMOTE_ADDR'];
        $info = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));





        // [FR] On vérifie si la propriété 'country' existe et si oui, si le pays de l'utilisateur est la France ( code = FR )
        // [GB] We check if the 'country' property exists and if so, if the user's country is France ( code = FR )
        if (property_exists($info, 'country') && $info->country === "FR") {

            // [FR] On autorise l'accès au site
            // [GB] Access to the site is allowed
            echo "<div>Bienvenue en France !<br>Votre adresse IP est : " . $ip."</div>";

        } else {

            // [FR] Sinon, on refuse l'accès en affichant l'adresse IP de l'utilisateur, aisni que le nom et le drapeau de son pays récupérés dans le tableau du fichier codes.php
            // [GB] Otherwise, access is denied by displaying the user's IP address, as well as the name and flag of his country retrieved from the table in the codes.php file
            $country = property_exists($info, 'country') ? (array_key_exists($info->country, $countryCodes) ? $countryCodes[$info->country] : 'inconnu') : 'inconnu';
            echo "
                    <div class='error'>
                        Désolé, l'accès à ce site internet n'est autorisé qu'aux utilisateurs ayant une adresse IP localisée en<strong> France 🇫🇷</strong>.<br><br>
                        Votre adresse IP est : <strong>". $ip."</strong>, elle provient de <strong>".$country."</strong>
                    </div>";
        }

        ?>
        
    </div>
</body>
</html>
