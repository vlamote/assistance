<html><head><title>Passa les variables per POST o GET</title></head><body>
<?

if($_POST)
{
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post)
     {
      $$key_post = $_POST[$key_post];
     }
}

if($_GET)
{
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get)
     {
        $$key_get = $_GET[$key_get];
     }
}

if($_SESSION)
{
    $keys_sesion = array_keys($_SESSION);
    foreach ($keys_sesion as $key_sesion)
     {
       $$key_sesion = $_SESSION[$key_sesion];
     }
}

?>
</body></html>
