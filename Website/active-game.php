<DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <? include("modules/nav-bar-main-page.php"); ?>
    
    <div class="row">
        <? for ($i = 0; $i < 5; $i++) { ?>
            <div class="col s4">
                <? 
                $tableCardName = $i;
                include("modules/table-card.php");  
                ?>
            </div>
        <? } ?>        
    </div>

    <div class="row">
        <? for ($x = 0; $x < 5; $x++) { ?>
            <div class="col s12">
                <? include("modules/chip-value.php");  ?>
            </div>
        <? } ?>      
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>