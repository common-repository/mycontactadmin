<?php /*

****************************************************************************
 * @package MyContactAdmin
****************************************************************************
 *
 *
 * Plugin Name: MyContactAdmin
 * Description: Un plugin d'information sur les coordonnées de l'administrateur, Webmaster, Concepteur du site.
 * Version:     1.1.6
 * Tested up to: 4.7
 * Author:      <a target="_blank" href="http://www.olsys-mediaweb.fr">Tissier Olivier</a> & <a href="http://www.mdp-informatique.com/">Diot Guillaume</a>
 * Author URI:  http://plugin-wp.olsys-mediaweb.fr/plugin-wordpress
 * Text Domain: MyContactAdmin
 * 
 *
 * Copyright (C) 2016 Tissier Olivier & Diot Guillaume
 *
 *
**************************************************************************/

function MyContactAdmin_settings_action_links( $links, $file ) {


// lien vers la page de config de ce plugin
   array_unshift( $links, sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=MyContactAdmin_menu_admin' ), __( 'Configuration', 'MyContactAdmin' ) ) );

    return $links;
}
add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'MyContactAdmin_settings_action_links', 10, 2 );


function MyContactAdmin_plugin_row_meta( $links, $file ) {
   
    // Site éditeur
    if ( strstr( __FILE__, $file ) != '' )
        $links[] = '<a target="_blank" href="http://www.olsys-mediaweb.fr">' . __( 'Site éditeur', 'MyContactAdmin' ) . '</a>';

    return $links;
}
add_filter( 'plugin_row_meta', 'MyContactAdmin_plugin_row_meta', 100, 2 );
 

/* Ajouter un encart perso */
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
function my_custom_dashboard_widgets() {
global $wp_meta_boxes;
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
wp_add_dashboard_widget('custom_help_widget', 'Aide et support', 'custom_dashboard_help');
}


//Affichage page d'accueil
function custom_dashboard_help() {

//recuperation variable enregistre
   $titre_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_titre_encart')));
   $ecrire_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_ecrire_encart')));
   $info_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_info_encart')));
   $ste_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_ste_encart')));
   $votre_nom_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_votre_nom_encart')));
   $votre_prenom_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_votre_prenom_encart')));
   $tel_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_tel_encart')));
   $jour_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_jour_encart')));
   $heures_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_heures_encart')));



echo '<p><center><big><b>'.$titre_encart.'</b></big></br> 
      <p>'.$ecrire_encart.'</p></br></p>
    <p><span style="text-decoration:underline;"><b>'.$info_encart.'</b></span></br></br>
    <a href="http://'.$ste_encart.'" target="_blank">'.$ste_encart.'</a></br>
       '.$votre_nom_encart.' '.$votre_prenom_encart.'</br> 
       Tel: '.$tel_encart.'</br></br>
       Horaires d\'ouverture:</br>
       '.$jour_encart.'</br>
       '.$heures_encart.'</center></p>
';
}

//Mon css MyContactAdmin
     wp_enqueue_style( 'MyContactAdmin', '/wp-content/plugins/mycontactadmin/css/MyContactAdmin.css');


//Mon menu tableau de bord
add_action( 'admin_menu', 'MyContactAdmin_ajouter_menu_tableau_de_bord' );

function MyContactAdmin_ajouter_menu_tableau_de_bord() {
   add_menu_page( 
      __( 'MyContactAdmin - Configuration', 'My Contact Admin' ), // texte de la balise <title>
      __( 'MyContactAdmin', 'My Contact Admin' ),  // titre de l'option de menu
      'manage_options', // droits requis pour voir l'option de menu
      'MyContactAdmin_menu_admin', // slug
      'MyContactAdmin_creer_page_configuration', // fonction de rappel pour créer la page
      '/wp-content/plugins/mycontactadmin/images/logo/Online_Support_Filled-24.png'
   );


// première option du sous-menu : redéfinit les mêmes critères que le menu
add_submenu_page( 
   'MyContactAdmin_menu_admin',  // slug du menu parent
   __( 'MyContactAdmin - Configuration', 'My Contact Admin' ),  // texte de la balise <title> - même que dans add_menu_page()
   __( 'Configuration', 'My Contact Admin' ),   // titre de l'option de sous-menu
   'manage_options',  // droits requis pour voir l'option de menu
   'MyContactAdmin_menu_admin', // réutiliser le slug du menu parent
   'MyContactAdmin_creer_page_configuration' // fonction de rappel pour créer la page
   );

 }

// on teste la déclaration de nos variables
   if (isset($_POST['titre_encart']) && isset($_POST['ecrire_encart']) && isset($_POST['info_encart']) && isset($_POST['ste_encart']) && isset($_POST['votre_nom_encart']) && isset($_POST['votre_prenom_encart']) && isset($_POST['tel_encart']) && isset($_POST['jour_encart']) && isset($_POST['heures_encart'])) {
  //Enregistrement des variables
        //DOC https://codex.wordpress.org/Function_Reference/add_option
      function save_MyOption($option,$val){
      if ( get_option($option) !== false ) { //On test si l'option déjà si oui on maj
      update_option($option, $val);
       } else { // sinon on créé
      add_option( $option, $val, '', 'yes' );
      } 
    }
    save_MyOption('MyContactAdmin_titre_encart',addslashes($_POST['titre_encart']));
    save_MyOption('MyContactAdmin_ecrire_encart',addslashes($_POST['ecrire_encart']));
    save_MyOption('MyContactAdmin_info_encart',addslashes($_POST['info_encart']));
    save_MyOption('MyContactAdmin_ste_encart',addslashes($_POST['ste_encart']));
    save_MyOption('MyContactAdmin_votre_nom_encart',addslashes($_POST['votre_nom_encart']));
    save_MyOption('MyContactAdmin_votre_prenom_encart',addslashes($_POST['votre_prenom_encart']));
    save_MyOption('MyContactAdmin_tel_encart',addslashes($_POST['tel_encart']));
    save_MyOption('MyContactAdmin_jour_encart',addslashes($_POST['jour_encart']));
    save_MyOption('MyContactAdmin_heures_encart',addslashes($_POST['heures_encart']));
 }

function MyContactAdmin_creer_page_configuration() {
   global $title;   // titre de la page du menu, tel que spécifié dans la fonction add_menu_page
   //recuperation variable enregistre
   $titre_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_titre_encart')));
   $ecrire_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_ecrire_encart')));
   $info_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_info_encart')));
   $ste_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_ste_encart')));
   $votre_nom_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_votre_nom_encart')));
   $votre_prenom_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_votre_prenom_encart')));
   $tel_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_tel_encart')));
   $jour_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_jour_encart')));
   $heures_encart = htmlspecialchars(stripslashes(get_option('MyContactAdmin_heures_encart')));


   ?>

   <div class='wrap'>
      <h2><?php echo $title; ?></h2>
      </br>
      </br>

<!-- Mon formulaire-->
   <div id='mca' class='full'>
   <div id='info' class='gauche'>
   <fieldset id = 'mca' class='full'>
   <script type="text/javascript">
    //Javascript gere uniquement affichage en temps reel du preview !
    function majPreview(){
    var titre_encart = document.getElementsByName("titre_encart")[0].value;
    var ecrire_encart = document.getElementsByName("ecrire_encart")[0].value;
    var info_encart = document.getElementsByName("info_encart")[0].value;
    var ste_encart = document.getElementsByName("ste_encart")[0].value;
    var votre_nom_encart = document.getElementsByName("votre_nom_encart")[0].value;
    var votre_prenom_encart = document.getElementsByName("votre_prenom_encart")[0].value;
    var tel_encart = document.getElementsByName("tel_encart")[0].value;
    var jour_encart = document.getElementsByName("jour_encart")[0].value;
    var heures_encart = document.getElementsByName("heures_encart")[0].value;
    
    document.getElementById("container_preview").innerHTML="<p><center><big><b>"+titre_encart+"</b></big></br><p>"+ecrire_encart+"</p></br></p><p><span style='text-decoration:underline;'><b>"+info_encart+"</b></span></br></br>"+ste_encart+"</a></br>"+votre_nom_encart+" "+votre_prenom_encart+"</br>"+tel_encart+"</br></br><p>Horaires d'ouverture:</p></br>"+jour_encart+"</br>"+heures_encart+"</div>";
    
    
    }
   </script>

<form method='post' action=''>

      Titre de l'encart : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='titre_encart' value="<?php if (isset($titre_encart)){echo $titre_encart;} ?>" placeholder="Bienvenu dans votre espace d'administration !"></textarea></br></br>

      Ecrivez un message : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='ecrire_encart' value="<?php if (isset($ecrire_encart)){echo $ecrire_encart;} ?>" placeholder="Si vous avez besoin d'aide à la soumission d'un article, ou que vous rencontrez un BUG n'hésitez pas à consulter le support technique."></textarea></br></br>

      Info : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='info_encart' value='<?php if (isset($info_encart)){echo $info_encart;} ?>' placeholder='Pour rappel:'></textarea></br></br>

      Votre Société : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='ste_encart' value='<?php if (isset($ste_encart)){echo $ste_encart;} ?>' placeholder='olsys-mediaweb'></textarea></br></br>

      Nom : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='votre_nom_encart' value='<?php if (isset($votre_nom_encart)){echo $votre_nom_encart;} ?>' placeholder='Votre nom'></textarea></br></br>

      Prénom : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='votre_prenom_encart' value='<?php if (isset($votre_prenom_encart)){echo $votre_prenom_encart;} ?>' placeholder='Votre prenom'></br></br>

      Télephone : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='tel_encart' value='<?php if (isset($tel_encart)){echo $tel_encart;} ?>' placeholder='06 07 08 09 10'></br></br>

      Jours d'ouverture : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='jour_encart' value='<?php if (isset($jour_encart)){echo $jour_encart;} ?>' placeholder='du lundi au vendredi'></textarea></br></br>

      Horaires d'ouverture : 
      <input type='texte' onkeyup="majPreview()" class='inputForm' name='heures_encart' value='<?php if (isset($heures_encart)){echo $heures_encart;} ?>' placeholder='de 09h00 à 17h30'></textarea></br></br>

<input type = 'submit' name = 'envoyer' value = 'Valider'>
</form>
   </div>
   </fieldset>
  </div>

<div id='resume' class='droite'>
   <fieldset id = 'resume' class='full'>
         
         <fieldset id = 'title' class='center'>
            <h1>APERÇU</h1>
         </fieldset></br>

<div id='resume' class='center'>
<!-- Mon aperçu -->
      <?php     
   
// on affiche nos résultats
   echo'<div id="container_preview"><p><center><big><b>'.$titre_encart.'</b></big></br><p>'.$ecrire_encart.'</p></br></p>
    <p><span style="text-decoration:underline;"><b>'.$info_encart.'</b></span></br></br><a href="http://'.$ste_encart.'" target="_blank">'.$ste_encart.'</a></br>'.$votre_nom_encart.' '.$votre_prenom_encart.'</br>
</br>Tel : '.$tel_encart.'</br>'.$jour_encart.'</br>'.$heures_encart.'</div>';

?>

</div>
   </div>
   </fieldset>

<fieldset id = 'paypal' class='paypal'>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="QWBXM9AZJSEUC">
<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>

         </fieldset></br>
  </div>

   <?php
}