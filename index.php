<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code by HugoTby</title>
    <style>
        .center {text-align:center;display: flex;justify-content: center;align-items: center;height: 100vh;}
        .error {background: rgba(255, 0, 0, 0.4);padding: 10px;border-radius: 5px;}
    </style>
</head>
<body>
    <div class="center">
    
        <?php
        // [FR] Dans le code ci-dessous nous définiront aux lignes 53, 57 et 66 que l'adresse IP de l'utilisateur dois se situer en France.
        // [GB] In the code below we will define in lines 53, 57 and 66 that the IP address of the user must be located in France.


        // [FR] On include les fichiers codes.php, black_list.php, white_list.php pour récupérer par la suite le nom et le drapeau du pays d'origine de l'adresse IP et l'autorisation d'accès si elle existe
        // [GB] We include the codes.php, black_list.php, white_list.php files to retrieve the name and flag of the country of origin of the IP address and the access authorisation if it exists
        include("codes.php");
        include("black_list.php");
        include("white_list.php");




        // [FR] On utilise la fonction `file_get_contents` pour obtenir les informations géographiques à partir de l'adresse IP ( avec -> ipinfo.io )
        // [GB] We use the `file_get_contents` function to get the geographical information from the IP address ( with -> ipinfo.io )
        $ip = $_SERVER['REMOTE_ADDR'];
        $info = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));



        // [FR] On vérifie si l'ip correspond a une adresse bloquée dans la liste donnée dans le tableau `blacklist` présent dans le fichier 'black_list.php'
        // [GB] We check if the ip corresponds to a blocked address in the list given in the `blacklist` table in the 'black_list.php' file
        if (array_key_exists($ip, $blacklist)) {
            $ip_adress_list = $blacklist[$ip];
            echo "
                    <div class='error'>
                        Sorry, you have been <strong>**denied access**</strong> to this website<br><br>
                        Your IP address is : <strong>". $ip."</strong>, and it comes from <strong><mark style='border-radius:2px;padding:2px'>".$ip_adress_list."</mark></strong><br><br>
                        If this error appears, it is likely that your IP address has been blacklisted by the developers of this site, or that it is incompatible with the use of the site.<br><br>
                        To correct this error, please contact a site administrator or your network administrator.
                    </div>";

        } 
        
        // [FR] On vérifie si la propriété 'country' existe et si oui, si le pays de l'utilisateur est la France ( code = FR ) ou si il est dans la liste des IP autorisées.
        // [GB] We check if the 'country' property exists and if so, if the user's country is France ( code = FR ) or if it is in the list of authorised IPs.
        elseif (property_exists($info, 'country') && $info->country === "FR" or in_array($ip, $whitelist)) {

            // [FR] On autorise l'accès au site
            // [GB] Access to the site is allowed
            echo "<div>Your IP address is from France! Welcome to our website :D<br>Your IP address is : " . $ip."</div>";

        } else {

            // [FR] Sinon, on refuse l'accès en affichant l'adresse IP de l'utilisateur, aisni que le nom et le drapeau de son pays récupérés dans le tableau du fichier codes.php
            // [GB] Otherwise, access is denied by displaying the user's IP address, as well as the name and flag of his country retrieved from the table in the codes.php file
            $country = property_exists($info, 'country') ? (array_key_exists($info->country, $countryCodes) ? $countryCodes[$info->country] : 'Unknown location') : 'Unknown location';
            echo "
                    <div class='error'>
                        Sorry, this website is only accessible to users with an IP address located in<strong> France 🇫🇷</strong><br><br>
                        Your IP address is : <strong>". $ip."</strong>, and it comes from <strong>".$country."</strong>
                    </div>";
        }

        ?>
        
    </div>
</body>
</html>