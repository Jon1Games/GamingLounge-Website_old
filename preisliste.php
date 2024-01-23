<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/database.css" rel="stylesheet">
    <link href="color/auto.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/navigation.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    <title>Gaming Lounge</title>
</head>
<body onload="initPage()">
<header>
  <a class="logo-name"><span style="color: #ff0000; ">G</span><span style="color: #ff1100">a</span><span style="color: #ff2200">m</span><span style="color: #ff3300">i</span><span style="color: #ff4400">n</span><span style="color:#ff5500">g</span> <span style="color: #ff6600">L</span><span style="color: #ff7700">o</span><span style="color: #ff8800">u</span><span style="color: #ff9900">n</span><span style="color: #ffaa00">g</span><span style="color: #ffbb00">e</span> <span style="color: #ffcc00">N</span><span style="color: #ffdd00">e</span><span style="color: #ffee00">t</span><span style="color: #ffff00">z</span><span style="color: #ffee00">w</span><span style="color: #ffdd00">e</span><span style="color: #ffcc00">r</span><span style="color: #ffbb00">k</span></a>
  <a class="logo"><img src="icon/gl.png" alt="logo"></a>
  <nav>
    <ul class="nav__links">
      <li><a href="features.html">Features</a></li>
      <li><a href="regeln.html">Regeln</a></li>
      <li><a href="map.html">Karten</a></li>
      <li><a href="freebuild.html">FreeBuild</a></li>
      <li><a href="testblock.html">TestBlock</a></li>
      <li><a href="hardware.html">Hardware</a></li>
      <li><a href="preisliste.php?search=alle">Preis-Liste</a></li>
    </ul>
  </nav>
  <a class="cta" href="kontakt.html">Kontakt</a>
  <p class="menu cta">Menu</p>
</header>
<div id="mobile__menu" class="overlay">
  <a class="close">&times;</a>
  <div class="overlay__content">
    <a href="features.html">Features</a>
    <a href="regeln.html">Regeln</a>
    <a href="map.html">Karten</a>
    <a href="freebuild.html">FreeBuild</a>
    <a href="testblock.html">Test Block</a>
    <a href="hardware.html">Hardware</a>
    <a href="kontakt.html">Kontakt</a>
    <a href="preisliste.php?search=alle">Preis-Liste</a>
  </div>
</div>

<div class="base">
    <div>
        <div class="block">
        <h2>Bitte beachtet, dass wir noch dabei sind diese Tabelle zu ver. Wen manche Gegenstände nicht aufgeführt sind sich aber leicht von der Tabelle ab </h2>
        </div>
        <form action="" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" required value="" class="form-control" placeholder="Such Parameter auf Englisch und Deutsch (für alle Inhalte [ alle | all | * | % ] )" id="searchInput">
                <button type="submit" class="btn btn-primary">Suche</button>
            </div>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Minimal Preis</th>
                <th>Maximal Preis</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $con = mysqli_connect("192.168.178.31","preise","^s1FptokR$6MtHoZ7[bmA,DdRzQs^B#tNcYcq?h|uMUji;Ji;TmM8^qX|#ioJE)an{<9#(0_GX-fT(8MopkGG.oo6&E=jOSmT8bw1Hz>3+.{/1x)6/~r9bXss.%`1Ur3","preise");

                if(isset($_GET['search']))
                {
                    if($_GET['search'] == "alle") {
                        $filtervalues = "%";
                    } else if($_GET['search'] == "all") {
                       $filtervalues = "%";
                   } else if($_GET['search'] == "Alle") {
                          $filtervalues = "%";
                   } else if($_GET['search'] == "All") {
                         $filtervalues = "%";
                   } else if($_GET['search'] == "*") {
                      $filtervalues = "%";
                  } else {
                    $filtervalues = "%{$_GET['search']}%";
                    }
                    $query = $con->prepare("SELECT * FROM minmax WHERE CONCAT(de_de,min_price,max_price,item_id) LIKE ? ");
                    $query->bind_param('s', $filtervalues);
                    $query->execute();
                    $query_run = $query->get_result();

                    if($query_run->num_rows > 0)
                    {
                        foreach($query_run as $items)
                        {
                            ?>
                            <tr>
                                <td><?= $items['de_de']; ?></td>
                                <td><?= $items['min_price']; ?> Coins</td>
                                <td><?= $items['max_price']; ?> Coins</td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                            <tr>
                                <td colspan="4"><h4>Keine Daten zu der Suche</h4> <br> <h1><?php echo "{$_GET['search']}"; ?></h1> <br> </td>
                            </tr>
                        <?php
                    }
                }
            ?>
        </tbody>
    </table>

    <script type="text/javascript" src="scripts/mobile.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        function initPage() {
            var urlQuerry = new URLSearchParams(document.location.search);
            if(urlQuerry.has("search")) document.getElementById("searchInput").value = urlQuerry.get("search");
        }
    </script>
</body>
</html>