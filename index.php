<?php



//print_r($_SERVER) ;






// répertoire racine du site web
$baseAPI= __DIR__."/API" ;


//echo "<script>alert('".$baseAPI."');</script>";


include 'Route.php';




// Quand on a un message d'erreur, on revient au début
Route::pathNotFound(function(){
	echo "<H1> Page Not Found. </H1>" ;
	echo "Something in your page is wrong and can't be found" ;
}) ;

Route::methodNotAllowed(function(){
	echo "<H1> Method not Allowed</H1" ;
}) ;





Route::add('/',function()
{
    global   $baseAPI ;
    require __DIR__.'/bonjour.php' ;
});





Route::add('/test',function()
{
    global  $baseAPI ;
    require __DIR__.'/test.php' ;
});



Route::add('/test2',function()
{
    global  $baseAPI ;
    require __DIR__.'/test2.php' ;
});




// API de prod
Route::add('/API/Login',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_login.php' ;
},'post');









// Upload
Route::add('/API/Upload-BusinessCards',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Upload_BusinessCards.php' ;
},'post');

Route::add('/API/Upload-ImageArticle',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Upload_ImageArticle.php' ;
},'post');






// Formation
Route::add('/API/Creer-Formation',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_create.php' ;
},'post');


Route::add('/API/Delete-Formation',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_delete.php' ;
},'post');

Route::add('/API/Modifier-Formation',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_update.php' ;
},'post');



Route::add('/API/Show-Formations',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_showall.php' ;
},'post');

Route::add('/API/Show-CategoriesFormations',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_showallCategories.php' ;
},'post');

Route::add('/API/Show-GroupesFormations',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_showallGroupes.php' ;
},'post');


Route::add('/API/Validate-Formation',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_validate.php' ;
},'post');

Route::add('/API/Invalidate-Formation',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_invalidate.php' ;
},'post');

Route::add('/API/Show-Available-Formations',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Formation_showallAvailable.php' ;
},'post');









// Classement BusinessCards
Route::add('/API/Creer-Classement-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Classement_create.php' ;
},'post');


Route::add('/API/Delete-Classement-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Classement_delete.php' ;
},'post');


Route::add('/API/Show-Classements-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Classement_showall.php' ;
},'post');







// Categories BusinessCards
Route::add('/API/Creer-Categorie-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Categorie_create.php' ;
},'post');


Route::add('/API/Delete-Categorie-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Categorie_delete.php' ;
},'post');


Route::add('/API/Show-Categories-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Categorie_showall.php' ;
},'post');


Route::add('/API/Modifier-Categorie-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_Categorie_update.php' ;
},'post');

Route::add('/API/Update-Classement-BusinessCard-ForNonExistingCategories',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_UpdateForNonExistingCategories.php' ;
},'post');





// BusinessCard
Route::add('/API/Creer-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_create.php' ;
},'post');


Route::add('/API/Delete-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_delete.php' ;
},'post');


Route::add('/API/Show-BusinessCards',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_showall.php' ;
},'post');


Route::add('/API/Modifier-BusinessCard',function()
{
    global  $baseAPI ;
    require $baseAPI.'/BusinessCard_update.php' ;
},'post');






// Interview
Route::add('/API/Show-Questions-For-Interview',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Interview_showQuestions.php' ;
},'post');

Route::add('/API/Show-Interviews-For-User',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Interview_showallForUser.php' ;
},'post');


Route::add('/API/Save-Answer',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Interview_saveAnswer.php' ;
},'post');


Route::add('/API/Show-Answers',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Interview_showAnswers.php' ;
},'post');

Route::add('/API/Validate-Interview',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Interview_validate.php' ;
},'post');

Route::add('/API/Invalidate-Interview',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Interview_invalidate.php' ;
},'post');







// Compte Utilisateur
Route::add('/API/Creer-Compte-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_create.php' ;
},'post');


Route::add('/API/Delete-Compte-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_delete.php' ;
},'post');


Route::add('/API/Show-Comptes-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_showall.php' ;
});


Route::add('/API/Modifier-Password-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_updatePassword.php' ;
},'post');



Route::add('/API/Modifier-Role-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseUtilisateur_updateRole.php' ;
},'post');


Route::add('/API/Modifier-Fonction-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseUtilisateur_updateFonction.php' ;
},'post');


Route::add('/API/Modifier-Fondateur-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseUtilisateur_updateFondateur.php' ;
},'post');












Route::add('/API/Add-Managed-User',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_add.php' ;
},'post');

Route::add('/API/Show-Managed-Users',function()
{
    global  $baseAPI ;
    require $baseAPI.'/CompteUtilisateur_showManaged.php' ;
},'post');


Route::add('/API/Show-Entreprise-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseUtilisateur_showall.php' ;
},'post');












Route::add('/API/Modifier-Langue',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Langue_update.php' ;
},'post');


Route::add('/API/Show-Langue',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Langue_showall.php' ;
},'post');






// Infos Utilisateur
Route::add('/API/Creer-Infos-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Utilisateur_Infos_create.php' ;
},'post');

Route::add('/API/Delete-Infos-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Utilisateur_Infos_delete.php' ;
},'post');



Route::add('/API/Show-Infos-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Utilisateur_Infos_showall.php' ;
});

Route::add('/API/Show-Infos-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Utilisateur_Infos_showall.php' ;
},'post');







// Entreprise
Route::add('/API/Creer-Fiche-Entreprise',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_create.php' ;
},'post');


Route::add('/API/Modifier-Fiche-Entreprise',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_update.php' ;
},'post');


Route::add('/API/getInfo-Entreprise-From-ID',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_getInfoFromID.php' ;
},'post');

Route::add('/API/getInfo-Entreprise-From-SIRET',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_getInfoFromSIRET.php' ;
},'post');



Route::add('/API/getListe-Entreprises-Pour-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_getListForUser.php' ;
},'post');


Route::add('/API/getListe-EntreprisesEtActivites-Pour-Utilisateur',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseEtActivite_getListForUser.php' ;
},'post');


Route::add('/API/Delete-Entreprise',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_delete.php' ;
},'post');

Route::add('/API/Lier-Entreprise',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseUtilisateur_create.php' ;
},'post');

Route::add('/API/Delete-Lien-Entreprise',function()
{
    global  $baseAPI ;
    require $baseAPI.'/EntrepriseUtilisateur_delete.php' ;
},'post');



Route::add('/API/Show-Entreprises',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_showall.php' ;
});

Route::add('/API/Search-Entreprises',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Entreprise_search.php' ;
},'post');







// Event
Route::add('/API/Creer-Event',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Event_create.php' ;
},'post');


Route::add('/API/Delete-Event',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Event_delete.php' ;
},'post');

Route::add('/API/Modifier-Event',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Event_update.php' ;
},'post');



Route::add('/API/Show-Events',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Event_showall.php' ;
},'post');







// Article
Route::add('/API/Creer-Article',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_create.php' ;
},'post');


Route::add('/API/Delete-Article',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_delete.php' ;
},'post');

Route::add('/API/Modifier-Article',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_update.php' ;
},'post');

Route::add('/API/Publier-Article',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_publish.php' ;
},'post');

Route::add('/API/Show-Articles-Publies',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_showPublished.php' ;
},'post');


Route::add('/API/Show-Articles',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_showall.php' ;
},'post');

Route::add('/API/Show-CategoriesArticles',function()
{
    global  $baseAPI ;
    require $baseAPI.'/ArticleCategories_showall.php' ;
},'post');


Route::add('/API/Validate-Article',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_validate.php' ;
},'post');

Route::add('/API/Invalidate-Article',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Article_invalidate.php' ;
},'post');








// Activite
Route::add('/API/Creer-Activite',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Activite_create.php' ;
},'post');


Route::add('/API/Delete-Activite',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Activite_delete.php' ;
},'post');

Route::add('/API/Show-Activites',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Activite_showall.php' ;
});

Route::add('/API/Modifier-Activite',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Activite_update.php' ;
},'post');







// Traduction
Route::add('/API/Show-Traductions',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Traduction_showall.php' ;
});

Route::add('/API/Show-Traductions',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Traduction_showall.php' ;
},'post');

Route::add('/API/Show-SelectBox-Traductions',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Traduction_SelectBox_showall.php' ;
});

Route::add('/API/Show-SelectBox-Traductions',function()
{
    global  $baseAPI ;
    require $baseAPI.'/Traduction_SelectBox_showall.php' ;
},'post');












Route::run('/');


?>


