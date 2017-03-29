function afficher(){

  var valeur;
  valeur = document.getElementById("critere_stat").value;

  document.getElementById("age").style.display="none";
  document.getElementById("cause").style.display="none";
  document.getElementById("lieu").style.display="none";
  document.getElementById("indigence").style.display="none";
  document.getElementById("nombre").style.display="none";

  // En fonction de l'élément selectionné, afficher le champs à compléter et cacher les autres
  switch (valeur)
  {
    //Cas où l'on veut afficher les Statistiques pas tranches d'âges
    case "1" :
        document.getElementById("age").style.display="inline-block";
        break;

    //Cas où l'on veut afficher les Statistiques par Cause de Décès
    case "2" :
        document.getElementById("cause").style.display="inline-block";
        break;

    //Cas où l'on veut afficher les Statstiques par Lieu de Décès
    case "3" :
        document.getElementById("lieu").style.display="inline-block";
        break;

    //Cas où l'on veut afficher les Statstiques en fontion du Corps (Indigent ou Non)
    case "4" :
        document.getElementById("indigence").style.display="inline-block";
        break;

    //Cas où l'on veut afficher les Statstiques par Nombre de Décès par période d'un an
    case "5" :
        document.getElementById("nombre").style.display="inline-block";
        break;
  }
}
