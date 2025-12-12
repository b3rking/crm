<?php

session_start();
define('WEBROOT',str_replace('index.php', "", $_SERVER['SCRIPT_NAME']));
define('ROOT',str_replace('index.php', "", $_SERVER['SCRIPT_FILENAME']));

//$controller = $params[0]; 
//$action = isset($params[1]) ? $params[1] : 'index';

/*header('Cache-Control: no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');*/
 
require_once('model/connection.php');
require_once('controller/login.controller.php');
require_once('controller/client.controller.php');
require_once('controller/equipement.controller.php');
require_once('controller/partenaire.controller.php');
require_once('controller/pannee.controller.php');
require_once('controller/facture.controller.php');
require_once('controller/finance.controller.php');
require_once('controller/mail.controller.php');
require_once('controller/historique.controller.php');
require_once('controller/utilisateur.controller.php');
require_once('controller/typeClient.controller.php');
require_once('controller/service.controller.php');
require_once('controller/contract.controller.php');
require_once('controller/parametre/parametre.controller.php');
require_once('controller/article.controller.php');
require_once('controller/vehicule.controller.php');
require_once('controller/localisation.controller.php');
require_once('controller/marketing.controller.php');
require_once ('controller/dashboard.controller.php');
require_once 'controller/config.controller.php';

if (isset($_GET['p'])) 
{
	$params = explode('/', $_GET['p']); 
	//die(print_r($params));
	$_SESSION['action'] = '';
	$action = $params[0];
	$d = preg_split("#[-]+#", $action);
	$n = count($d);    
	if ($n > 1) 
	{
		$action = $d[0];
	}
	
	if ($action == 'login') 
	{
        //importDataFacture();
		//importFactureService();
		$remember_me = (isset($_POST['remember_me']) ? $_POST['remember_me'] : "");
		traiterLogin($_POST['login'],$_POST['password'],$remember_me);
	}
    elseif ($action == 'resetpwd') 
	{
		resetPassword($_POST['emailrecover']);
	}
	elseif ($action == 'recoverpwdform') 
	{
		inc_recoverpwdform($d[1]);
	}
	else
	{
		if (isset($_SESSION['ID_user'])) 
		{
			$_SESSION['action'] = $action;
			$_SESSION['facture_auto'] = 0;
			if ($action == 'ok') 
			{
				inc_homeAdmin();
				//inc_dashboard();
			}
			//GESTION CLIENT
			elseif ($action == 'client') 
			{
				inc_client();
			}
            elseif ($action == 'sendMailToClient') 
			{
//                generateMacAddress();
//                updateAmountContract();
				$sendmode = $_POST['sendmode'];
				$sujet = $_POST[''];
				$message = $_POST['message'];
				$sendsecteur = $_POST['sendsecteur'];
				$sendForAll = (isset($_POST['sendForAll']) ? true : false);
                if (isset($_FILES['attachFile']) && $_FILES['attachFile']['error'] == UPLOAD_ERR_OK) 
				{
					$file = $_FILES['attachFile']['tmp_name'];
					$fileName = $_FILES['attachFile']['name'];
				}
				
				sendMailToClient($sendmode,$sujet,$message,$sendsecteur,$sendForAll,$file,$fileName);
			}
			elseif ($action =='update_solde') 
				{
					miseajoursolde();
				}
            elseif($action == 'filtreClient')
			{
				$billing_number = $_GET['billing_number'];
				$nom_client = $_GET['nom_client'];
				$secteur = $_GET['secteur'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$type = $_GET['filter_type'];
				$status = $_GET['status'];
				$print = $_GET['print'];
                $asExcel = $_GET['asExcel'];

				filtreClient($billing_number,$nom_client,$secteur,$date1,$date2,$type,$status,$print,$asExcel);
			}
			elseif ($action == 'detailClient') 
			{
				detailClient($d[1]);
			}
			elseif ($action == 'printFiltreClient') 
			{
				printFiltreClient($_POST['cond']);
			}
			elseif ($action == 'resumeclient') 
			{
				resumeclient($d[1]);
			}
			elseif ($action == 'sendmail') 
			{
				sendmail($_POST['sujet'],$_POST['message']);
			}
			elseif ($action =='print_clientSanscontrat') 
			{
				print_clientSanscontrat();
			}
			elseif($action == 'printCustomer')
			{
				printCustomer();
			}
			elseif($action == 'verso')
			{
				verso_articleContrat();
			}
			elseif($action =='verso_contrat')
			{
				printVeso_contrat($d[1]);
			}
			//TYPE CLIENT

			elseif ($action == 'typeClient') 
			{
				typeClient();
			}
			/*
			* SERVICE
			*/
			elseif ($action == 'service') 
			{
				service();
			}
			/*
			* CONTRACT
			*/
			elseif ($action == 'contract') 
			{
				contract();
			}
            elseif ($action == 'filtreContract') 
			{
				$nom_client = $_GET['nom_client'];
				$service = $_GET['service'];
				$datecreation = $_GET['datecreation'];
				$numero = $_GET['numero'];
				$billing_number = $_GET['billing_number'];
                $status = $_GET['status'];
                $print = $_GET['print'];
				filtre_contract($numero,$billing_number,$nom_client,$service,$datecreation,$status,$print);
			}
			elseif ($action == 'fichier_client') 
			{
				fichier_client();
			}
            elseif ($action == 'customer_under_contract') 
			{
				customer_under_contract();
			}
			elseif ($action == 'filtreCustomerChild') 
			{
				$name = $_GET['name'];
				$billing_number = $_GET['billing_number'];
				filtreCustomerChild($name,$billing_number);
			}
            elseif ($action == 'filtreFichierAttacher') 
			{
				$billing_number = $_GET['billing_number'];
				$nom_client = $_GET['nom_client'];
				$date_creation = $_GET['date_creation'];
				$file_name = $_GET['file_name'];
				filtreFichierAttacher($billing_number,$nom_client,$date_creation,$file_name);
			}
			elseif ($action == 'detailContract') 
			{
				detailContract($d[1]);
			}
			/*elseif ($action == 'detailClient_fichier_contract') 
			{
				detailClient_fichier_contract($d[1]);
			}*/
			elseif ($action == 'printContract') 
			{
				printContract($d[1]);
			}
			elseif ($action =='voirfichier') 
			{
				voirfichier($d[1]);
			}
			elseif ($action == 'parametre') 
			{
				parametre();
			}

			elseif ($action == 'fichierclient') 
			{
				if (isset($_POST['idclient']) AND isset($_POST['nom']))
	            {
	            	$errors = []; // Store all foreseen and unforseen errors here
		            if (!empty($_POST['idclient']) AND !empty($_POST['nom'])) 
		            {
		              $currentDir = getcwd();
		              $uploadDirectory = "/uploads/customer_file/file/";
		              $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
		              //$fileName = $_FILES['fichier']['name'];
		              $fileSize = $_FILES['fichier']['size'];
		              $fileTmpName = $_FILES['fichier']['tmp_name'];
		              $fileType = $_FILES['fichier']['type'];
		              $extension = explode('/', $fileType);
		              //$new_name = $_POST['nom'].'.'.$extension[1];
		              //$fileExtension = strtolower(end(explode('.',$fileName)));
		              $uploadPath = $currentDir . $uploadDirectory;
		              $fileName = $_POST['nom'].'.'.$extension[1];
		              
		              if ($fileType != 'image/jpg' AND $fileType != 'image/jpeg' AND $fileType != 'image/png') 
		              {
		                $errors[] = "Ce fichier n'est supporté! Veuillez choisir l'extension JPEG(jpg) ou PNG";
		              }
		              if ($fileSize > 2000000) 
		              {
		                $errors[] = "Ce fichier depasse 2MB";
		              }
		              if (empty($errors)) 
		              {
		                creerfichier_client($_POST['idclient'],$_POST['nom'],$fileTmpName,$uploadPath,$fileName);
		              }
		              else
		              {
		                $url = "vue/admin/contract/fichier_client.php";
		                sendMsg($errors,$url);
		              } 
		            }
		            else
		            {
		              $url = "vue/admin/contract/fichier_client.php";
		              $errors[] = "Veillez remplir tous les champs";
		              sendMsg($errors,$url);
		            }
	          	} 
			}
			elseif ($action == 'update_file') 
			{
				if (isset($_POST['idfichier']) AND isset($_POST['nom_fichier'])) 
	         	{
	           		$errors = ''; // Store all foreseen and unforseen errors here
	            	if (!empty($_POST['idfichier']) AND !empty($_POST['nom_fichier'])) 
			        {
			        	$currentDir = getcwd();
			            $uploadDirectory = "/uploads/customer_file/file/";
			            $uploadPath = $currentDir . $uploadDirectory;
			        	if (!empty($_FILES['fichier']['name'])) 
		         		{
				            $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
				              //$fileName = $_FILES['fichier']['name'];
				            $fileSize = $_FILES['fichier']['size'];
				            $fileTmpName = $_FILES['fichier']['tmp_name'];
				            $fileType = $_FILES['fichier']['type'];
				            $extension = explode('/', $fileType);
				              //$new_name = $_POST['nom'].'.'.$extension[1];
				              //$fileExtension = strtolower(end(explode('.',$fileName)));
				              
				            $fileName = $_POST['nom_fichier'].'.'.$extension[1];
				              
				            if ($fileType != 'image/jpg' AND $fileType != 'image/jpeg' AND $fileType != 'image/png') 
				            {
				                $errors .= "\nCe fichier n'est supporté! Veuillez choisir l'extension JPEG(jpg) ou PNG ";
				            }
				            if ($fileSize > 2000000) 
				            {
				                $errors .= "\nCe fichier depasse 2MB";
				            }
				            Modifier_fichier_client($_POST['idfichier'],$_POST['nom_fichier'],$fileTmpName,$uploadPath,$fileName,$_POST['oldFileName'],$errors);
		         		}
			            else
			            {
			            	Modifier_fichier_client($_POST['idfichier'],$_POST['nom_fichier'],$fileTmpName=null,$uploadPath,$fileName=null,$_POST['oldFileName'],$errors);
			            }
		            }
		            else
		            {
		              $url = "vue/admin/contract/fichier_client.php";
		              $errors[] = "Veillez entreer le nom du fichier";
		              sendMsg($errors,$url);
		            }
	            } 
			}

			/*
			elseif ($_GET['action'] == 'inc_contact') 
			{
				inc_contact();
			}
			elseif ($_GET['action'] == 'in_article') 
			{
				in_article();
			}
			elseif ($_GET['action'] == 'inc_connexion') 
			{
				inc_connexion();
			}
			elseif ($_GET['action'] == 'inc_location') 
			{
				inc_location();
			}
			elseif ($_GET['action'] == 'inc_fichier_client') 
			{
				inc_fichier_client();
			}
			elseif ($_GET['action'] == 'inc_message') 
			{
				inc_message();
			}*/

			//GESTION EQUIPEMENT
			elseif ($action == 'creerstock') 
			{
				creerstock();
			}
			elseif ($action == 'voirstock') 
			{
				voirstock();
			}
			elseif ($action == 'point_acces') 
			{
				inc_point_acces();
			}
			elseif ($action == 'switch') 
			{
				switchs();
			}
			elseif ($action == 'secteur') 
			{
				inc_secteur();
			}
			elseif ($action == 'trace_materiels')
		    {
				trace_materiels();
			}
			elseif ($action == 'routeur') 
			{
				inc_routeur();
			}
            elseif ($action == 'rapport_routeur') 
			{
				rapport_routeur($_GET['marque'],$_GET['date1'],$_GET['date2'],$_GET['mois'],$_GET['annee']);
			}
			elseif ($action == 'antenne') 
			{
				inc_antenne();
			}
            elseif ($action == 'rapport_antenne') 
			{
				rapport_antenne($_GET['marque'],$_GET['date1'],$_GET['date2'],$_GET['mois'],$_GET['annee']);
			}
			elseif ($action == 'adresse_mac') 
			{
				inc_adresse_mac();
			}
			elseif ($action == 'technique')
		    {
				technique();
			}
			elseif ($action == 'radio')
		    {
				inc_radio();
			}
            elseif ($action == 'categorieAccessoire') 
			{
				inc_categorieAccessoire();
			}
			elseif ($action == 'accessoire')
		    {
				in_accessoire();
			}
            elseif ($action == 'filtreAccessoire') 
			{
				$categorie_id = $_GET['categorie_id'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$mois = $_GET['mois'];
				$annee = $_GET['annee'];
				$print = $_GET['print'];
				filtreAccessoire($categorie_id,$date1,$date2,$mois,$annee,$print);
			}
			elseif ($action == 'etat_Stock')
		    {
				etat_Stock();
			}
            elseif ($action == 'sortie_accessoire') 
			{
				inc_sortie_accessoire();
			}
            elseif ($action == 'filtreSortieAccessoire') 
			{
				$demander_par = $_GET['demander_par'];
				$destination = $_GET['destination'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$mois = $_GET['mois'];
				$annee = $_GET['annee'];
				$print = $_GET['print'];
				filtreSortieAccessoire($demander_par,$destination,$date1,$date2,$mois,$annee,$print);
			}
            elseif ($action == 'sortie_equipement') 
			{
				inc_sortie_equipement();
			}
            elseif ($action == 'filtreSortie_equipement') 
			{
				$demander_par = $_GET['demander_par'];
				$destination = $_GET['destination'];
                $type_equipement = $_GET['type_equipement'];
                $mac_address = $_GET['mac_address'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$mois = $_GET['mois'];
				$annee = $_GET['annee'];
				$print = $_GET['print'];
				filtreSortie_equipement($demander_par,$destination,$type_equipement,$mac_address,$date1,$date2,$mois,$annee,$print);
			}
            elseif ($action == 'equipement_recover') 
			{
				equipement_recover_view();
			}
            elseif ($action == 'filtreRecuperation') 
			{
				$client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$mois = $_GET['mois'];
				$annee = $_GET['annee'];
				$type_equipement = $_GET['type_equipement'];
                $mac_address = $_GET['mac_address'];
				$print = $_GET['print'];
				filtreRecuperation($client,$date1,$date2,$mois,$annee,$type_equipement,$mac_address,$print);
			}
			elseif ($action == 'attribution_materiel_client')
		    {
				attribution_materiel_client();
			}
			elseif ($action == 'attribution_equipement')
		    {
				attribuerEquipement();
			}
            elseif ($action == 'fiche_de_stock_equipement')
			{
				getFiche_de_stock_equipement($_POST['cond']);
			}
			elseif ($action == 'fiche_de_sortie_accessoire')
			{
				getfiche_de_sortie_accessoire($_POST['cond']);
			}
			elseif ($action == 'ajout_carburant') 
			{
				ajout_stock_carburant();
			}
			elseif ($action == 'detailcarburant') 
			{
				detailcarburant($d[1]);
			}
			elseif ($action == 'distribution_carburant') 
			{
				distribution_carburant();
			}
			elseif ($action == 'printrapport_carburant') 
			{
				printrapport_carburant($_POST['mois'],$_POST['annee']);
			}
			elseif ($action == 'Secteurtotal') 
			{
				nombretotalsecteur();
			}
			elseif ($action =='basetotal') 
			{
				nombretotalbase();
			}
			elseif ($action == 'rapportStock') 
			{
				
				generer_pdf_sock($_POST['accessoireStock']);
			}
			elseif ($action == 'detailstock') 
			{
				inc_detailstock($d[1]);
			}

			/*
			* VEHICULE
			*/
			elseif ($action == 'vehicule') 
			{
				inc_vehicule();
			}

			/*
			*
			* ARTICLE
			*
			*/

			elseif ($action == 'article') 
			{
				article();
			}
			elseif ($action == 'octroi_article') 
			{
				if (isset($_POST['profil_id']) && isset($_POST['affiche']))
			        {
			        	foreach ($_POST['affiche'] as $value)  
			        	{
		        		//echo 'num article: '.preg_split("#[-]+#", $value) [0];
		        		$numarticle = preg_split("#[-]+#", $value) [0];
		        		$i = preg_split("#[-]+#", $value) [1];
		        		//echo "ordre: ".$_POST['ordre'.$i];
		        		$num_titre =$_POST['ordre'.$i];
		        		$ordre = ($num_titre < 10 ? '0'.$num_titre : $num_titre);
		        		//echo "Voici : ".$ordre;

		        		article_selectionne($_POST['profil_id'],$numarticle,$ordre);
			        		// echo "ref profil : ".$_POST['profil_id'].'/id article:'.$numarticle.'/no ordre :'.$ordre.'</br>';
			        	}
			        }
					else 
					{
						header("location:attibuer_article");
						//echo "ATTENTION PAS DE VALEUR";
					} 
			}
			elseif ($action =='attibuer_article') 
			{
				article_global();
			}
			elseif ($action == 'modifierSuprime_profil') 
			{
				inclure_pagemodif();
			}
			elseif ($action == 'set_profil_global') 
			{
				set_profil();
			}

			/*
			* LOCALISATION
			*/
			elseif ($action == 'localisation') 
			{
				inc_location();
			}

			//PARTENAIRE

			elseif ($action == 'companie') 
			{
				inc_companie();
			}
			elseif ($action == 'partenaire') 
			{
				inc_partenaire();
			}

			// PANNEES

			
			elseif ($action =='client_recuperer') 
			{
				clientRecuperer();
			}
			elseif ($action =='clientinstallerdumois') 
			{
				installation_dumois();
			}
			elseif ($action =='installer') 
			{
				client_installer();
			}
			elseif ($action == 'getinstalationDmois') 
			{
				
				getinstalation_du_mois($d[1],$d[2]);
			}
			elseif ($action =='printclient_demenager') 
			{
				client_voulantdemenager();
			}
			elseif ($action =='pannes_client') 
			{
				detail_panneclient();
			}
			elseif ($action == 'tickets') 
			{
				inc_panne();
			}
            /*elseif ($action == 'filtreTickets') 
			{
				$idticket = $_GET['idticket'];
				$nom_client = $_GET['nom_client'];
				$type_ticket = $_GET['type_ticket'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$status = $_GET['status'];
				filtreTickets($idticket,$nom_client,$type_ticket,$date1,$date2,$status);
			}*/
			elseif ($action == 'filtreTickets') 
			{
				$idticket = $_GET['idticket'];
				$nom_client = $_GET['nom_client'];
				$type_ticket = $_GET['type_ticket'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$status = $_GET['status'];
				$print = $_GET['print'];
				filtreTickets($idticket,$nom_client,$type_ticket,$date1,$date2,$status,$print);
			}
			elseif ($action == 'detailTicket') 
			{
				detailTicket($d[1]);
			}
			elseif ($action =='WEBROOTdetailTicket') 
			{
				detailTicket($d[1]);
			}
			elseif ($action == 'ticketouvert') 
			{
				ticketouvert();
			}
			elseif ($action == 'ticketfermer') 
			{
				ticketfermer();
			}
			elseif ($action == 'fiches') 
			{
				viewFiches();
			}
            elseif ($action == 'inc_ficheinstation') 
			{
				inc_ficheinstallation();
			}
            elseif ($action == 'filtreInstallation')
			{
                $nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				filtreInstallation($nom_client,$date1,$date2);
			}
			elseif($action == 'inc_fichedemenagement')
			{
				inc_fichedemenagement();
			}
            elseif ($action == 'filtreDemenagement')
			{
				$nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				filtreDemenagement($nom_client,$date1,$date2);
			}
			elseif($action == 'inc_ficherecuperation')
			{
				inc_ficherecuperation();
			}
            elseif ($action == 'filtreFicheRecuperation')
			{
				$nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				filtreFicheRecuperation($nom_client,$date1,$date2);
			}
			elseif($action == 'inc_ficheintervention')
			{
				inc_ficheintervention();
			}
            elseif($action == 'filtreFicheIntervention')
            {
                $date_creation = $_GET['date_creation'];
                $technicien = $_GET['technicien'];
                filtreFicheIntervention($date_creation,$technicien);
            }
			elseif ($action == 'inc_ficheaugmentationbp') 
			{
				inc_ficheaugmentationbp();
			}
            elseif ($action == 'filtreAugmentationBp')
			{
				$nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				filtreAugmentationBp($nom_client,$date1,$date2);
			}
			elseif($action == 'inc_fichediminutionbp')
			{
				inc_fichediminutionbp();
			}
            elseif ($action == 'filtreDiminutionBd')
			{
				$nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				filtreFicheDiminutionBp($nom_client,$date1,$date2);
			}
			elseif ($action == 'inc_fichedemission') 
			{
				inc_fichedemission();
			}
			elseif ($action == 'ficheinstallation') 
			{
				inc_ficheinstallation();
			}
			elseif ($action == 'genficheinstallation') 
			{
				if (isset($_POST['idclient'])) 
				{
					genficheinstallation($_POST['idclient']);

				}
				else header('location:ficheinstallation');
			}
            elseif ($action == 'updateficheinstallation') 
			{
				if (isset($_POST['idclient']))
				{
					updateFicheInstallation($_POST['idfiche'],$_POST['idticket'],$_POST['idclient']);

				}
				else header('location:ficheinstallation');
			}
			elseif ($action == 'ficheAugmentionBP') 
			{
				inc_ficheAugmentionBP();
			}
				elseif ($action == 'genficheDiminutionBP') 
			{
				//echo "Vous etes sur la diminution bande panssante";
				if (isset($_POST['idclient']) && isset($_POST['datedebut']) && isset($_POST['datefin']) && isset($_POST['bandepassante'])) 
					{
						//echo "string".$_POST['idclient'].' '.$_POST['datedebut'].' '.$_POST['datefin'].' '.$_POST['bandepassante'];die();
						genfiche_diminuBP($_POST['idclient'],$_POST['datedebut'],$_POST['datefin'],$_POST['bandepassante']);

					}
					else header('location:inc_fichediminutionbp');
			}
			
				elseif ($action == 'genficheBP') 
				{
					if (isset($_POST['idclient']) && isset($_POST['datedebut']) && isset($_POST['datefin']) && isset($_POST['bandepassante'])) 
					{
						genficheBP($_POST['idclient'],$_POST['datedebut'],$_POST['datefin'],$_POST['bandepassante']);
					}
					else header('location:inc_ficheaugmentationbp');
				}
				elseif ($action == 'regenfichebandepassante') 
				{
					regenfichebandepassante($d[1]);
				}
                elseif($action == 'regenficheintervention')
				{
					regenficheintervention($d[1]);
				}
				elseif ($action == 'intervention') 
				{
					interventionT();
				}
				elseif ($action =='fiche_diminution_bp') 
				{
					regenfichediminution_bp($d[1]);
				}
				elseif ($action == 'fichepanne') 
				{
					/*if (isset($_POST['ticket']) && is_array($_POST['ticket']) && isset($_POST['technicien']) && isset($_POST['createurFiche']) && isset($_POST['plaque']) && !empty($_POST['plaque']) && !empty($_POST['technicien'])) 
					{*/  

						fichepanne($_POST['ticket'],$_POST['createurFiche'],$_POST['technicien'],$_POST['plaque']);
					/*}
					else 
					{
						$message = "Veillez renseigner les informations en * ";
						//interventionT($message,$url);
					}*/
				}
				//si action dans l'url = generer_fiche_demenagement alors on appel la fonction dans le controleur
				elseif ($action == 'generer_fiche_demenagement') 
				{
					generer_fiche_demenagement();
				}
				elseif ($action == 'fichedemenagement') 
				{
					fichedemenagement($_POST['client'],$_POST['new_adress'],$_POST['oldAdresse'],$_POST['dates']);
				}
                elseif ($action == 'updateFicheDemenagement') 
				{
					updateFicheDemenagement($_POST['idclient'],$_POST['new_adress'],$_POST['oldAdresse'],$_POST['dates'],$_POST['idfiche']);
				}
				elseif ($action == 'generefichepanne') 
				{
					generefichepanne();	
				}
				elseif ($action == 'recuperation')
			    {
					genererFiche_recuperation();
				}
				elseif ($action == 'fiche_de_recuperation')
			    {
                    fiche_de_recuperation($_POST['idclient'],$_POST['dates'],$_POST['status']);
			    	/*if (isset($_POST['dates'])  && !empty($_POST['dates']))
				    {
						fiche_de_recuperation($_POST['idclient'],$_POST['dates']);
					}
					else
					{
						genererFiche_recuperation();
					}*/
				}
                elseif ($action == 'update_fiche_de_recuperation')
			    {
			    	if (isset($_POST['dates'])  && !empty($_POST['dates']))
				    {
						update_fiche_de_recuperation($_POST['idclient'],$_POST['dates'],$_POST['idfiche'],$_POST['idticket'],$_POST['idContenuFiche']);
					}
					else header('location:inc_ficherecuperation');
				}
				elseif ($action == 'filtreTickets') 
                {
                    $idticket = $_GET['idticket'];
                    $nom_client = $_GET['nom_client'];
                    $type_ticket = $_GET['type_ticket'];
                    $date1 = $_GET['date1'];
                    $date2 = $_GET['date2'];
                    $status = $_GET['status'];
                    $print = $_GET['print'];
                    filtreTickets($idticket,$nom_client,$type_ticket,$date1,$date2,$status,$print);
                }
				elseif ($action == 'regenficherecuperation') 
				{
					regenficherecuperation($d[1]);
				}
				elseif ($action == 'regenficheinstallation') 
				{
					regenficheinstallation($d[1]);
				}
				elseif ($action == 'regenfichedemenagement') 
				{
					regenfichedemenagement($d[1]);
				}
				elseif ($action =='genereOrdremission')
			    {
			    	if (isset($_POST['dateMission']) && isset($_POST['dateRetour']) && isset($_POST['technicien']) && is_array($_POST['technicien']))
			        {
			        	//echo "vous avez bien choisi le tecnicien et la date de mission";
			    		genereOrdremission($_POST['dateMission'],$_POST['dateRetour'],$_POST['technicien']);
			    	}
					else
					{
						echo "vous devez selectionner le technicien et cocher un client";
						//$message = "vous devez selectionner le technicien et cocher un client";
						genereOrdremission();
						//ficheMission($message);
					} 
				}

			// TAUX

			elseif ($action == 'taux') 
			{
				viewTaux();
			}

			// FACTURE
			
			elseif ($action == 'facture_client') 
			{
				inc_facture_client();
			}
            elseif ($action == 'filtreFacture') 
			{
				$billing_number=$_GET['billing_number'];
				$nom_client=$_GET['nom_client'];
				$date1=$_GET['date1'];
				$date2=$_GET['date2'];
				$mode_creation=$_GET['mode_creation'];
				$mois_creation=$_GET['mois_creation'];
				$annee_creation=$_GET['annee_creation'];
				$print = $_GET['print'];
				
			    filtreFactures($billing_number,$nom_client,$date1,$date2,$mode_creation,$mois_creation,$annee_creation,$print);
			}
            elseif ($action == 'incomeingInvoices') 
			{
				incomeingInvoices();
			}
			elseif ($action == 'raportFact') 
			{
				inc_factureReport();
			}
            elseif ($action == 'printInvoiceMonthlyCollected')
			{
				$repport_id = $d[1].'-'.$d[2];
				printInvoiceMonthlyCollected($repport_id);
			}
			elseif ($action == 'nouveauclient') 
			{
				//echo $_POST['mois'].$_POST['annee'];
				nouveauclient($_POST['mois'],$_POST['annee']);
			}
			elseif ($action =='print_client_derogation') 
			{
				print_client_derogation();
			}
			elseif ($action == 'printclient_coupure') 
			{
				client_coupures();
			}
			elseif ($action == 'client_sansdette') 
			{
				client_sansdette();
			}
			elseif ($action == 'clientSoldeNegatif') 
			{
				clientSoldeNegatif();
			}
			elseif ($action == 'cPartiAvecDette') 
			{
				clientPartiAvecDette();
			}
			elseif ($action == 'cPartiSansDette') 
			{
				clientPartiSansDette();
			}
			elseif ($action == 'client_delinquant') 
			{
				client_delinquant();
			}
			elseif ($action == 'client_actif') 
			{
				client_actif();
			}
			elseif ($action == 'print_client_en_pause') 
			{
				print_client_en_pause();
			}
            elseif ($action == 'chiffreAffaire') 
			{
				chiffreAffaire();
			}
            elseif ($action == 'factureAnnuelle') 
			{
				factureAnnuelle();
			}
			elseif ($action =='print_clientSans_facture') 
			{
				client_sansfacture();
			}
			/*elseif ($action == 'print_clientSans_facture') 
			{
				printfactureApreCreerContract();
			}*/
			elseif ($action == 'client_speciaux') 
			{
				client_super();
			}
				elseif ($action == 'printraport_client_parmois') 
			{
				//var_dump($_POST['mois_creation'].$_POST['annee_fact'].$_POST['cond'].' / '.$_POST['type']);die();

				printraportclient($_POST['mois_creation'],$_POST['annee_fact']/*$_POST['cond'],$_POST['type']*/);
			}
			elseif ($action == 'new_customer') 
			{
				newClient();
			}
			elseif ($action == 'printfact') 
			{
				if (count($params) >1) $facture_id = $d[1].'/'.$params[1];
				else $facture_id = $d[1];
				imprimerfactureParId($facture_id);
			}
			elseif ($action == 'printProforma') 
			{
				if (count($params) >1) $facture_id = $d[1].'/'.$params[1];
				else $facture_id = $d[1];
				imprimerProformatParId($facture_id);
			}
			elseif ($action == 'printMassInvoice') 
			{
				//importDataFacture();
				//setMoisFacture();
				creatMassInvoice($_POST['mode_mass_invoice'],$_POST['datefacture_masse'],$_POST['mois_choisi'],$_POST['annee_factureEnMass'],$_POST['taux_mass_invoice'],$_POST['userName']);
			}
			elseif ($action == 'printInvoiceMonth') 
			{
				printInvoiceMonthly($_POST['mois_choisi'],$_POST['annee_raport'],$_POST['mode_mass_invoice_print']);
				//printInvoiceCreerAuneDate($_POST['date_creation']);
			}
			elseif ($action == 'print_rapport_mois') 
			{
				print_rapport_mois($_POST['mois_selectionné'],$_POST['annee_raport']);
			}
			elseif ($action == 'report_fact') 
			{
				if (isset($_POST['cond'])) 
				{
					report_fact($_POST['cond']);
				}
			}
			elseif ($action == 'printraportfactPayerImp') 
			{
				printraportfactPayerImpayer($_POST['cond'],$_POST['type']);
			}
			elseif ($action == 'balance_initiale') 
			{
				inc_balance_initiale();
			}
			
			elseif ($action == 'suspension') 
			{
				inc_suspension();
			}
			elseif ($action == 'coupure') 
			{
				inc_coupure();
			}
			elseif ($action == 'creerDerogation') 
			{
				genererListeDesClientsAderoguer();
			}
			elseif ($action == 'couper' || $action == 'recouvrer') 
			{
				//$action = $d[0];
				$cutoff_id = $d[1];
				detail_coupure($action,$cutoff_id);
			}
			elseif ($action == 'print_coupure_action') 
			{
				print_coupure_action($_POST['action'],$_POST['coupure_id']);
			}
			elseif ($action == 'proforma_facture') 
			{
				inc_proforma_facture();
			}
            elseif($action == 'filtreFactureProformat')
			{
				$numero = $_GET['num_fact'];
				$nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				filtreProformats($numero,$nom_client,$date1,$date2);
			}
			elseif ($action == 'ordre_d_achat') 
			{
				inc_ordre_d_achat();
			}
			elseif ($action == 'genere_rapport_choisi_par_mois') 
			{
				genere_rapport_choisi_par_mois();
			}

			//TOUS RAPPORTS
			elseif ($action == 'rapports') 
			{
				rapports_etat_client();
			}
			
			//FINANCE

			elseif ($action == 'monnaie') 
			{
                //updateMontantFacture();
                importDataFacture();
				monnaie();
			}
			elseif ($action == 'paiement') 
			{
				inc_paiement();
			}
            elseif ($action == 'exportToCSV') {
                // Extract parameters from the URL
                $billing_number = $_GET['billing_number'] ?? '';
                $nom_client = $_GET['nom_client'] ?? '';
                $date1 = $_GET['date1'] ?? '';
                $date2 = $_GET['date2'] ?? '';
                $mois_payement = $_GET['mois_payement'] ?? '';
                $mois_facture = $_GET['mois_facture'] ?? '';
                $annee = $_GET['annee'] ?? '';
                $mode_payement = $_GET['mode_payement'] ?? '';
            
                // Call the exportToCSV function with the extracted parameters
                exportToCSV($billing_number, $nom_client, $date1, $date2, $mois_payement, $mois_facture, $annee, $mode_payement);
            }
            elseif ($action == 'payment_summary_report') 
			{
				$year = $_GET['year'];
				payment_summary_report($year);
			}
            elseif($action == 'filtrePayement')
			{
				$billing_number = $_GET['billing_number'];
				$nom_client = $_GET['nom_client'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$mois_payement = $_GET['mois_payement'];
				$annee = $_GET['annee'];
				$mois_facture = $_GET['mois_facture'];
                $mode_payement = $_GET['mode_payement'];
				$print = $_GET['print'];
			    filtrePayement($billing_number,$nom_client,$date1,$date2,$mois_payement,$mois_facture,$annee,$mode_payement,$print);
			}
			elseif ($action == 'recu_paiement_facture') 
			{
				recu_paiement_facture($d[1]); 
			}
			elseif ($action =='print_filter_payement') 
			{
				if (isset($_POST['cond'])) 
				print_filter_payement($_POST['cond']);
			else header("location:paiement");
			}
			elseif ($action == 'rapport_payement_mensuel') 
			{
				rapport_payement_mensuel($_POST['mois'],$_POST['annee']);
			}
			elseif ($action == 'banque_de_versement') 
			{
				inc_banque_de_versement();
			}
            elseif ($action == 'filtreVerssement') 
			{
				$banque = $_GET['banque'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
                $reference = $_GET['reference'];
				filtreVerssement($banque,$date1,$date2,$reference);
			}
			elseif ($action == 'saveVersement') 
			{
				if (isset($_POST['reference']) AND isset($_POST['dateversement']) AND isset($_POST['paiement']) AND isset($_POST['montant_total'])) 
				{
					//$idDestination;
					//$monnaiedestination;
					$banque = preg_split("#[-]+#", $_POST['banque']);
		            $idDestination = $banque[0];
		            $monnaiedestination = $banque[2];
					/*if ($_POST['destination'] == 'banque') 
			        {
			            $banque = preg_split("#[_]+#", $_POST['banque']);
			            $idDestination = $banque[0];
			            $monnaiedestination = $banque[2];
			        }
			        else
			        {
			            $caisse = preg_split("#[_]+#", $_POST['caisse']);
			            $idDestination = $caisse[0];
			            $monnaiedestination = $caisse[2];
			        }*/
					saveVersement($idDestination,$monnaiedestination,$_POST['reference'],$_POST['dateversement'],$_POST['paiement'],$_POST['montant_total']);
				}
				//else sendMsgError('Tous les champs doivent etre remplis et verifiez si vou avez selectionne le payement','banque_de_versement');
			}
            elseif ($action == 'addPayementToVerssement') 
			{
				addPayementToVerssement($_POST['add_verssement_id'],$_POST['paiement']);
			}
            elseif ($action == 'updateVerssement') 
			{
				if (isset($_POST['idverssement']) AND isset($_POST['banque']) AND isset($_POST['reference']) AND isset($_POST['dateversement']) AND isset($_POST['payement']) AND isset($_POST['deletePayement'])) 
				{
					$banque = preg_split("#[_]+#", $_POST['banque']);
		            $idbanque = $banque[0];
		            $monnaie = $banque[2];
					updateVerssement($_POST['idverssement'],$idbanque,$monnaie,$_POST['reference'],$_POST['dateversement'],$_POST['payement'],$_POST['deletePayement']);
				}
			}
			elseif ($action == 'versementouvert') 
			{
				versementouvert();
			}
			elseif ($action == 'banque') 
			{
				inc_banque();
			}
			elseif ($action == 'printVersement') 
			{
				printVersement($d[1]);
			}
			elseif ($action == 'detailbanque') 
			{
				detailbanque($d[1]);
			}
            elseif($action == 'bankReport')
			{
				$mois = $_GET['mois'];
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$annee = $_GET['annee'];
				$banque = $_GET['banque'];
				generateBankRepport($date1,$date2,$mois,$annee,$banque);
			}
			elseif ($action == 'caisse')  
			{
				inc_caisse();
			}
            elseif ($action == 'approvisionnement') 
			{
				inc_approvisionnement();
			}
			elseif ($action == 'detailcaisse') 
			{
				detailcaisse($d[1]);
			}
			elseif ($action == 'ajoutcompte') 
			{
				ajoutcompte();
			}
			elseif ($action == 'transaction') 
			{
				inc_transaction();
			}
            elseif ($action == 'petitedepense') 
			{
				inc_petite_depense();
			}
			elseif ($action == 'depense_administrative') 
			{
				inc_depense_administrative();
			}
            elseif ($action == 'filtreDepense') 
			{
				$date1 = $_GET['date1'];
				$date2 = $_GET['date2'];
				$mois = $_GET['mois'];
				$annee = $_GET['annee'];
				$banque = $_GET['banque'];
				$print = $_GET['print'];

				filtreDepense($date1,$date2,$mois,$annee,$banque,$print);
				/*if (!isset($_POST['condition']))
					header("location:depense_administrative");
				else
					genererPdfRapportDepense($_POST['date1'],$_POST['date2'],$_POST['mois'],$_POST['annee'],$_POST['banque']);*/
			}
			elseif ($action == 'rapportDepense') 
			{
				if (!isset($_POST['condition']))
					header("location:depense_administrative");
				else
					genererPdfRapportDepense($_POST['condition']);
			}
            elseif ($action == 'rapportPetiteDepense') 
			{
				if (!isset($_POST['condition']))
					header("location:petitedepense");
				else
					genererPdfRapportPetiteDepense($_POST['condition']);
			}
			elseif ($action == 'rapportSortieCaisse') 
			{
				if (!isset($_POST['condition']))
					header("location:detailcaisse-".$_POST['idcaisse']);
				else
					genererPdfSortieCaisse($_POST['condition'],$_POST['idcaisse']);
			}
			elseif ($action == 'rapportEntrerCaisse') 
			{
				if (!isset($_POST['conditionEntrees']))
					header("location:detailcaisse-".$_POST['idcaisseEntree']);
				else
					genererPdfEntrerCaisse($_POST['conditionEntrees'],$_POST['idcaisseEntree']);
			}
			elseif ($action == 'rapportEntrerBanque') 
			{
				if (!isset($_POST['condition']))
					header("location:detailbanque-".$_POST['idbanque']);
				else
					genererPdfEntrerBanque($_POST['condition'],$_POST['idbanque']);
			}
			elseif ($action == 'rapportSortieBanque') 
			{
				if (!isset($_POST['conditionSortie']))
					header("location:detailbanque-".$_POST['idbanqueSortie']);
				else
					genererPdfSortieBanque($_POST['conditionSortie'],$_POST['idbanqueSortie']);
			}
			elseif ($action == 'printHistoriqueDette') 
			{
				if (!isset($_POST['condition'])) 
				{
					header("location:creance");
				}
				else printHistoriquePayementDette($_POST['condition']);
			}
			/*elseif ($action == 'facture_fournisseur') 
			{
				inc_facture_fournisseur();
			}*/
			elseif ($action == 'extrat') 
			{
				extrat();
			}
			elseif ($action =='type_extrat') 
			{
				type_extrat();
			}
            elseif ($action == 'prevision') 
			{
				prevision();
			}
			elseif ($action == 'prevision_report_print') 
			{
				if(!isset($_POST['report_data']))
					header('location:prevision');
				prevision_report_print(unserialize($_POST['report_data']));
			}
			elseif ($action =='categorieDepense') 
			{
				categorieDepense();
			}
			elseif ($action =='creance') 
			{
				creance();
			}

			//***************     MARKETING  ********************//

			
			elseif ($action == 'marketing')
		    {
				marketing();
			}
			elseif ($action == 'prospection')
		    {
				prospection();
			}
            elseif ($action == 'filtreProspect') 
			{
				$nom = $_GET['nom'];
				$dateprospection = $_GET['dateprospection'];
				$daterendezvous = $_GET['daterendezvous'];
				$status = $_GET['status'];
                $suivi_par = isset($_GET['suivi_par']) ? $_GET['suivi_par'] : '';

				filtreProspect($nom,$dateprospection,$daterendezvous,$status,$suivi_par);
			}
			elseif ($action == 'agenda') 
			{
				agenda();
			}
			elseif ($action == 'visiteclient')
		    {
				visiteclient();
			}
			elseif ($action == 'validation')
			{
				validationProspect();
			}
			elseif ($action == 'ajoutstock')
		    {
				ajoutstock();
			}
			elseif ($action == 'affichestock')
		    {
				affichestock();
			}
			elseif ($action == 'sponsor')
		    {
				sponsor();
			}
			elseif ($action == 'visibilite')
		    {
				visibilite();
			}
			elseif ($action == 'detailprospect')
			{
				detailprospect($d[1]);
			}
			elseif ($action == 'attribution_materielSponsor') 
			{
				attribution_materielSponsor();
			}

			// HISTORIQUE

			elseif ($action == 'historique') 
			{
				inc_historique($d[1],$d[2]);
			}
			elseif ($action == 'historiques') 
			{
				inc_historiques();
			}

			// GESTION UTILISATEUR

			elseif ($action == 'utilisateur') 
			{
				inc_utilisateur();
			}
			elseif ($action =='monprofil') 
			{
				monprofil();
			}
			elseif ($action == 'Changer_motpasse')
			{
				Changer_motpasse();
			}
			elseif ($action == 'photo_profil') 
			{
				photo_profil();
			
			}
			elseif ($action == 'photoprofil') 
			{
				
				if(!file_exists($_FILES['photo']['tmp_name']) || !is_uploaded_file($_FILES['photo']['tmp_name'])) 
				{
					$message= 'Veiillez selectionner une photo SVP !';
					//$url = "vue/admin/utilisateur/photo_profil.php";
					afficherMessage($message,$url='vue/admin/utilisateur/mon_profil.php');
				}   
				else
				{ 
					if (isset($_POST['idutilisateur'])) 
         		    {
	            		$message = []; // Store all foreseen and unforseen errors here
	            		if (!empty($_POST['idutilisateur'])) 
	           			{
			              	$currentDir = getcwd();
			              	$uploadDirectory = "/image_profil/";
			              	$fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
			              	$fileName = $_FILES['photo']['name'];
			              	$fileSize = $_FILES['photo']['size'];
			              	$fileTmpName = $_FILES['photo']['tmp_name'];
			              	$fileType = $_FILES['photo']['type'];
			              	$uploadPath = $currentDir.$uploadDirectory.basename($fileName);

				            if ($fileType != 'image/jpg' AND $fileType != 'image/jpeg' AND $fileType != 'image/png') 
         					{
     					 		$message ="Ce fichier ne pas supporté! Veuillez choisir l'extension JPEG ou PNG"; //echo"Ce fichier n'est supporté! Veuillez choisir l'extension JPEG ou PNG";
         					}
             				if ($fileSize > 1000000) 
          					{
         					   $message ="Cette photo depasse 1MB";
        				    }
	            			if (empty($message)) 
         					{
          						creerphoto_profil($_POST['idutilisateur'],$fileTmpName,$uploadPath,$fileName);
        					}
            				else
         					{
          						  $url = "vue/admin/utilisateur/photo_profil.php";
           						  afficherMessage($message,$url);
          					} 
        			    }
        				else
   						{
         					$url = "vue/admin/utilisateur/photo_profil.php";
         					$message[] = "Veillez remplir tous les champs";
         					 afficherMessage($message,$url);
   						}
  					} 
									//echo 'upload';
				}
			}
			elseif ($action == 'setprofiluser') 
			{
				$page = array();
				$page = $_SESSION['page'];
				$nb = count($page);
				$page_accept = 0;
				for ($i=0; $i < $nb; $i++) 
				{
					$ll = 'l'.$i;
					$cc = 'c'.$i;
					$mm = 'm'.$i;
					$ss = 's'.$i; 
					if (isset($_POST['l'.$i])) 
					{
						$l = 1;
						$page_accept = 1;
					}
					else $l = 0;
					if (isset($_POST['c'.$i])) 
					{
						$c = 1;
						$page_accept = 1;
					}
					else $c = 0;
					if (isset($_POST['m'.$i])) 
					{
						$m = 1;
						$page_accept = 1;
					}
					else $m = 0;
					if (isset($_POST['s'.$i])) 
					{
						$s = 1;
						$page_accept = 1;
					}
					else $s = 0;
					setProfilUser($_POST['profile_name'],$page[$i],$l,$c,$m,$s,$i,$page_accept,$nb);
						$page_accept = 0;
					/*if ($page_accept == 1) 
					{
						setProfilUser($_POST['profile_name'],$page[$i],$l,$c,$m,$s,$i,$page_accept);
						$page_accept = 0;
					}*/
				}
			}
			elseif ($action == 'voir_profil') 
			{
				voir_profil();
			}
			elseif ($action == 'voir_utilisateur') 
			{
				voir_utilisateur();
			}
			elseif ($action == 'dashboardgest') 
			{
				gestion_dashboard();
			}
			elseif ($action == 'modification') 
			{
				modification();
			}
			elseif ($action =='societe') 
			{
				societe();
			}
			/*
			* TABLEAU DE BORD
			*/
		
			elseif ($action == 'dashboard') 
			{ 
				if (!empty($d[1])) 
				{
					inc_dashboardByPage($d[1]);
				}
				else
				inc_dashboard();
			}
			elseif ($action == 'printclientactif') 
			{
				printClientActif();
			}
			elseif ($action == 'deconnexion') 
			{
				deconnexion();
			}

			/*
			* INFORMATION D"ENTREPRISE
			*/

			else if ($action == 'info') 
			{
				infoSocieteView();
			}
			else
			{
				session_destroy();
				login();
			}

			
		}// END IF SESSION USER EXISTE
		else
		{
			session_destroy();
			login();
		}
	}// END ELSE ACTION == LOGIN
	
}
else
{
	session_destroy();
	login();
	//require_once('vue/admin/home.admin.php');
}