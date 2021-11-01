<?php
/* INCLUDE FILE IF YOU NEED A CREATE DEFAULT TABLE */
if(file_exists("required/database/table_create.php"))
{
  include("required/database/table_create.php");  
}

if(file_exists("required/database/database.php"))
{/* header('Location : exemple.php");*/}
else
{
    if(isset($_POST['submit'])){
        if(!empty($_POST['db_host'])){
            if(!empty($_POST['db_name'])){
                if(!empty($_POST['db_user'])){
                    if(!empty($_POST['db_password'])){
                        try {
                            $bd_host = $_POST['db_host'];
                            $db_name = $_POST['db_name'];
                            $db_user = $_POST['db_user'];
                            $db_password = $_POST['db_password'];
                            $bd = new PDO("mysql:host=$bd_host;dbname=$db_name", $db_user, $db_password);
                            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $error_msg = "Connected successfully";

                            file_put_contents('required/database/database.php', ""); // FILE WHERE SAVE THE DATABASE DATA
                            $db_file = fopen('required/database/database.php', 'r+');
                            fwrite($db_file, "<?php");
                            fwrite($db_file, "\r\n//////////////////////////////////////////////");
                            fwrite($db_file, "\r\n///////////// PLEASE DON'T TOUCH ////////////");
                            fwrite($db_file, "\r\n////////////////////////////////////////////");
                            fwrite($db_file, "\r\n$"."database_name = \"".$_POST['db_name']."\";");
                            fwrite($db_file, "\r\n$"."database_host = \"".$_POST['db_host']."\";");
                            fwrite($db_file, "\r\n$"."database_user = \"".$_POST['db_user']."\";");
                            fwrite($db_file, "\r\n$"."database_password = \"".$_POST['db_password']."\";");
                            fwrite($db_file, "\r\n?>");

                            fclose($db_file);

                            /* CREATE DEFAULT TABLE  */
                            /* NEED A FILE TABLE_CREATE, IN (required/database/table_create.php) */
                            /* EX: $bd->exec($sql_rq1); */

                        } catch (PDOException $e) {
                            $error_msg = "Connection failed : " . $e->getMessage();
                        }
                    }
                    else
                    {
                        $error_msg = "Please inform the database password";
                    }
                }
                else
                {
                    $error_msg = "Please inform the database user";
                }
            }
            else
            {
                $error_msg = "Please inform the database name";
            }
        }
        else
        {
            $error_msg = "Please inform the database host";
        }
    }
}


?>

<html>
    <head>
        <title>Database config</title>
    </head>
    <body>
    <form method="POST" action="">
        <input type="text" name="db_host" placeholder="Database Host" value="<?php if(isset($_POST['db_host'])){echo $_POST['db_host'];} ?>"/>
        <input type="text" name="db_name" placeholder="Database name" value="<?php if(isset($_POST['db_name'])){echo $_POST['db_name'];} ?>"/>
        <input type="text" name="db_user" placeholder="Database user" value="<?php if(isset($_POST['db_user'])){echo $_POST['db_user'];} ?>"/>
        <input type="password" name="db_password" placeholder="Database Password" value="<?php if(isset($_POST['db_password'])){echo $_POST['db_password'];} ?>"/>

        <input type="submit" name="submit" value="Valider"/>
  </form>

    <?php /* ERROR MESSAGE */ ?>
    <div class="MSG_ERROR"><?php if(isset($error_msg)){ echo $error_msg; } ?></div>
    </body>
</html>
