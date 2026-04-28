<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Police d'écritures -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <!-- Icônes Bootstrap -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <title>Lycée Marcel Rudloff - Menu de la semaine</title>
   <!-- Styles -->
   <link rel="stylesheet" href="style2.css">
   <link rel="stylesheet" href="menu_hebdomadaire.css">
   <?php
      require '../../../bdd/db.php';
      require '../../utilisateurs/auth.php';


      $dateDebut = $_GET['date_debut'];
      $dateFin = $_GET['date_fin'];

      // On récupère le PDO et on prépare la requête d'insertion
      try {
         $stmt = $pdo->prepare("
            SELECT
               m.id AS menu_id,
               m.jour,

               -- Entrée
               e.id AS entree_id,
               e.nom AS entree_nom,
               e.fait_maison AS entree_fait_maison,
               e.bio AS entree_bio,
               e.circuit_court AS entree_circuit_court,
               e.sans_viande AS entree_sans_viande,

               -- Plat principal
               p.id AS plat_id,
               p.nom AS plat_nom,
               p.fait_maison AS plat_fait_maison,
               p.bio AS plat_bio,
               p.circuit_court AS plat_circuit_court,
               p.sans_viande AS plat_sans_viande,

               -- Laitage
               l.id AS laitage_id,
               l.nom AS laitage_nom,
               l.fait_maison AS laitage_fait_maison,
               l.bio AS laitage_bio,
               l.circuit_court AS laitage_circuit_court,
               l.sans_viande AS laitage_sans_viande,

               -- Dessert
               d.id AS dessert_id,
               d.nom AS dessert_nom,
               d.fait_maison AS dessert_fait_maison,
               d.bio AS dessert_bio,
               d.circuit_court AS dessert_circuit_court,
               d.sans_viande AS dessert_sans_viande

            FROM Menu m
            LEFT JOIN Plat e ON m.id_entree = e.id
            LEFT JOIN Plat p ON m.id_plat_principal = p.id
            LEFT JOIN Plat l ON m.id_laitage = l.id
            LEFT JOIN Plat d ON m.id_dessert = d.id

            WHERE :date_debut <= m.jour AND :date_fin >= m.jour AND m.id_etablissement = :id_etablissement
         ");

         $stmt->execute(array(
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'id_etablissement' => $_SESSION["id_etablissement"]
         ));
      } catch (Exception $e) {
         die('Erreur lors de l\'enregistrement : ' . $e->getMessage());
      }


      $menuSemaine = array();
      while ($menuJour = $stmt->fetch(PDO::FETCH_ASSOC)) {
         // Ajouter le menu dans le tableau des menus
         $menuSemaine[] = $menuJour;
      }
      $stmt->closeCursor();

   ?>
</head>
<body>
   <div class="page-wrapper">
      <!-- Logo du lycée -->
      <img src="img/logo_lycee.png" id="logo_lycee" alt="Logo lycée Marcel Rudloff">
      <div>
         <!-- Titre du menu -->
         <?php 
            // Liste des jours de la semaine
            $jour = ["DIMANCHE", "LUNDI", "MARDI", "MERCREDI", "JEUDI", "VENDREDI", "SAMEDI"];
            // Liste des mois de l'année
            $mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
            // Jour de début du menu
            $indexJourDebut = date('j', strtotime($dateDebut));
            $indexMoisDebut = date('n', strtotime($dateDebut)) - 1;
            // Jour de fin du menu
            $indexJourFin = date('j', strtotime($dateFin));
            $indexMoisFin = date('n', strtotime($dateFin)) - 1;

            // Afficher la date
            echo "<h1 id='titre-menu'>Menu du ". $indexJourDebut ." ". $mois[$indexMoisDebut] ." au ". $indexJourFin ." ". $mois[$indexMoisFin] ."</h1>"; 
         ?>
      
         <div id="mot-du-chef-wrapper">
            <p>Le chef et son équipe privilègient</p>
            <img src="img/fait_maison.png" alt="">
            <p>l'approvisionnement en</p>
            <img src="img/circuit_court.png" alt="">
            <p>ainsi que</p>
            <img src="img/bio.png" alt="">
         </div>
      </div>

      <!-- Tableau du menu -->
      <table>
         <thead>
            <tr>
               <th></th>
               <?php 
                  foreach ($menuSemaine as $menuJour) {
                     // Transformer la date (string) en timestamp 
                     $dateMenu = strtotime($menuJour['jour']);

                     // Jour dans la semaine de ce repas
                     $indexJourSemaine = date('w', $dateMenu);
                     // Index du jour dans le mois de ce repas
                     $indexJourMoisMenu = date('j', $dateMenu);
                     // Index du mois dans l'année de ce repas
                     $indexMoisMenu = date('n', strtotime($dateFin)) - 1;
                     // Année du menu
                     $indexAnneeMenu = date('Y', strtotime($dateFin));
                     
                     // Afficher la date du menu
                     echo "<th>". $jour[$indexJourSemaine] ."<br>". $indexJourMoisMenu ." ". $mois[$indexMoisMenu] ."</th>";
                  }
               ?>
            </tr>
         </thead>
         <tbody>          
            <?php 
               // Entrées
               echo "<tr>
                  <td>ENTRÉE</td>
               ";
               foreach ($menuSemaine as $ligne) {
                  // Affiche l'entrée
                  echo "<td>". $ligne['entree_nom'] ."<br>";
                  // Icônes de l'entrée
                  if ($ligne["entree_sans_viande"] == 1){
                     echo "<img src='img/vegan.png' style='max-width : 2vw; max-height : 2vh;' alt='Végan'>";
                  }
                  if ($ligne["entree_circuit_court"] == 1){
                     echo "<img src='img/circuit_court.png' style='max-width : 2vw; max-height : 2vh;'>";
                  }
                  if ($ligne["entree_bio"] == 1){
                     echo "<img src='img/bio.png' style='max-width : 2vw; max-height : 2vh;' alt='Bio'>";
                  }
                  if ($ligne["entree_fait_maison"] == 1){
                     echo "<img src='img/fait_maison.png' style='max-width : 2vw; max-height : 2vh;' alt='fait maison'>";
                  }
                  echo "</td>";
               }
               echo "</tr>";
                                  
               // Plats
               echo "<tr>
                  <td>PLAT</td>
               ";
               foreach ($menuSemaine as $ligne) {
                  // Afficher le plat
                  echo "<td>". $ligne["plat_nom"] ."<br>";
                  // Icônes du plat
                  if ($ligne["plat_sans_viande"] == 1){
                     echo "<img src='img/vegan.png' style='max-width : 2vw; max-height : 2vh;' alt='Végan'>";
                  }
                  if ($ligne["plat_circuit_court"] == 1){
                     echo "<img src='img/circuit_court.png' style='max-width : 2vw; max-height : 2vh;'>";
                  }
                  if ($ligne["plat_bio"] == 1){
                     echo "<img src='img/bio.png' style='max-width : 2vw; max-height : 2vh;'' alt='Bio'>";
                  }
                  if ($ligne["plat_fait_maison"] == 1){
                     echo "<img src='img/fait_maison.png' style='max-width : 2vw; max-height : 2vh;' alt='fait maison'>";
                  }
                  echo "</td>";
               }
               echo "</tr>";                  
                                    
               // Laitages
               echo "<tr>
                  <td>LAITAGE</td>
               ";
               foreach ($menuSemaine as $ligne) {
                  // Afficher le laitage
                  echo "<td>". $ligne["laitage_nom"] ."<br>";
                  // Icônes du laitage
                  if ($ligne["laitage_sans_viande"] == 1){
                     echo "<img src='img/vegan.png' style='max-width : 2vw; max-height : 2vh;' alt='Végan'>";
                  }
                  if ($ligne["laitage_circuit_court"] == 1){
                     echo "<img src='img/circuit_court.png' style='max-width : 2vw; max-height : 2vh;'>";
                  }
                  if ($ligne["laitage_bio"] == 1){
                     echo "<img src='img/bio.png' style='max-width : 2vw; max-height : 2vh;'' alt='Bio'>";
                  }
                  if ($ligne["laitage_fait_maison"] == 1){
                     echo "<img src='img/fait_maison.png' style='max-width : 2vw; max-height : 2vh;' alt='fait maison'>";
                  }
                  echo "</td>";
               }
               echo "</tr>";
            
               // Desserts
               echo "<tr>
                  <td>DESSERT</td>
               ";
               foreach ($menuSemaine as $ligne) {
                  // Afficher le dessert
                  echo "<td>". $ligne["dessert_nom"] ."<br>";
                  // Icônes du dessert
                  if ($ligne["dessert_sans_viande"] == 1){
                     echo "<img src='img/vegan.png' style='max-width : 2vw; max-height : 2vh;' alt='Végan'>";
                  }
                  if ($ligne["dessert_circuit_court"] == 1){
                     echo "<img src='img/circuit_court.png' style='max-width : 2vw; max-height : 2vh;'>";
                  }
                  if ($ligne["dessert_bio"] == 1){
                     echo "<img src='img/bio.png' style='max-width : 2vw; max-height : 2vh;'' alt='Bio'>";
                  }
                  if ($ligne["dessert_fait_maison"] == 1){
                     echo "<img src='img/fait_maison.png' style='max-width : 2vw; max-height : 2vh;' alt='fait maison'>";
                  }
                  echo "</td>";
               }
               echo "</tr>";
            ?>
         </tbody>
      </table>

      <!-- Pied de page -->
      <footer>
         <div>
            <!-- <p>Le Gestionnaire,</p>
            <p>Cherif DIALLO</p> -->
         </div>
         <div>
            <p>Le Proviseur,</p>
            <p>Rodolphe RAFFIN-MARCHETTI</p>
         </div>
      </footer>                                           
   </div>
   
   <script>
      // Attendre 200 ms pour que la page charge
      setTimeout(function(){
         // Ouvrir la fenêtre pour imprimer la page
         window.print();
      }, 200);

      // Attendre que la page ai été imprimée
      window.onafterprint = function(){
         // Rediriger vers la page précédente
         window.history.back();
      };    
   </script>
</body>
</html>