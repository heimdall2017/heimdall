		/* Toutes ces fonctions affichent un champ différent selon le choix fait dans la liste déroulante */	
		
	/* MODIFIER CORPS */
/* Modifier corps -> fieldset du référent */
function printInputRef(){
    // Recuperer l'option selectionnée
    var valeur;
    valeur = document.getElementById("champs_ref").value;
	
    document.getElementById("nom_ref").style.display="none";
    document.getElementById("prenom_ref").style.display="none";
    document.getElementById("tel_ref").style.display="none";    
    // En fonction de l'élément selectionné, afficher le champs à compléter et cacher les autres
    switch (valeur) 
	{             
        //Cas où l'on veut modifier le Nom du Référent
        case "1" :
            document.getElementById("nom_ref").style.display="inline-block";
            break;
             
        //Cas où l'on veut modifier le Prénom du Référent
        case "2" :
            document.getElementById("prenom_ref").style.display="inline-block";
            break;
             
        //Cas où l'on veut modifier le Téléphone du Référent
        case "3" :
            document.getElementById("tel_ref").style.display="inline-block";
            break;
    }
}

/* Modifier corps -> fieldset du corps */
function printInput() {
    // Recuperer l'option selectionnée
    var valeur;
    valeur = document.getElementById("champs").value;
    
    // En fonction de l'élément selectionné, afficher le champs à compléter et cacher les autres
    document.getElementById("nom_corps").style.display="none";
    document.getElementById("prenom_corps").style.display="none";
    document.getElementById("cause_deces_corps").style.display="none";
    document.getElementById("d_naiss_corps").style.display="none";
    document.getElementById("l_naiss_corps").style.display="none";
    document.getElementById("d_deces_corps").style.display="none";
    document.getElementById("l_deces_corps").style.display="none";
    document.getElementById("adresse_corps").style.display="none";
    document.getElementById("certif_corps").style.display="none";   
	
    switch (valeur) 
	{          
            // Cas où l'élément à modifier est le Nom du Défunt
            case "1": 
                document.getElementById("nom_corps").style.display="inline-block";
                break;
                                        
            //Cas où l'élément à mdofier est le Prénom du défunt
            case "2" :
                document.getElementById("prenom_corps").style.display="inline-block";
                break;
                
            //Cas où l'élément à modifier est la Cause du décès
            case "3" : 
                document.getElementById("cause_deces_corps").style.display="inline-block";
                break;
            
            //Cas où l'élément à modifier est la Date de Naissance du défunt
            case "4" : 
                document.getElementById("d_naiss_corps").style.display="inline-block";
                break;
                
            //Cas où l'élément à modifer est le Lieu de Naissance du défunt
            case "5" :
                document.getElementById("l_naiss_corps").style.display="inline-block";
                break;
            
            //Cas où l'élement à modifier est la date du Décès
            case "6" :
                document.getElementById("d_deces_corps").style.display="inline-block";
                break;
                
            //Cas où l'élément à modifier est le Lieu du décès
            case "7" :
                document.getElementById("l_deces_corps").style.display="inline-block";
                break;
            
            //Cas où l'élément à modifier est l'Adresse du Défunt
            case "8" : 
                document.getElementById("adresse_corps").style.display="inline-block";
                break;              
            
            //Cas où l'on veut ajouter un certificat de décès
            case "10": 
                document.getElementById("certif_corps").style.display="inline-block";
                break;
    }
}