<?php
require_once('model/connection.php');
require_once('model/ticket.class.php');
require_once('model/client.class.php');
require_once('model/vehicule.class.php');
require_once('model/User.class.php');
require_once('model/contract.class.php');

function inc_panne()
{
	$user = new User();
	$ticket = new ticket();
    $client = new Client();
     $idticket = "";
    $nom_client = "";
    $type_ticket = "";
    $date1 = "";
    $date2 = "";
    $status = "";
  
    $result = $ticket->afficheToustickets();
	require_once("vue/admin/pannee/pannee.php");
}
function filtreTickets($idticket,$nom_client,$type_ticket,$date1,$date2,$status,$print)
{
	$user = new User();
	$ticket = new ticket();
	$client = new Client();

	$condition1 = "";
    $condition2 = "";
    $condition3 = "";
    $condition4 = "";
    $condition5 = "";
    $condition6 = "";
    $condition  = "";

    $condition1 = ($idticket == "" ? "" : " AND t.id=".$idticket);
    $condition2 = ($nom_client == "" ? "" : " AND nom_client LIKE '%".$nom_client."%' ");
    $condition3 = ($type_ticket == "" ? "" : " AND t.ticket_type='".$type_ticket."' ");
    $condition4 = ($date1 == "" ? $date1 : " AND DATE(t.created_at)='".$date1."' ");

    if ($date2 == "") 
    {
        $condition5 = "";
    }
    else
    {
        if ($date1 !== "") 
        {
            $condition5 = " AND DATE(t.created_at) BETWEEN '".$date1."' AND '".$date2."'";
            $condition4 = '';
        }
        else $condition4 = " AND DATE(t.created_at)='".$date2."' ";
    }
    $condition6 = ($status == "" ? "" : " AND t.status = '".$status."' ");
    $condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6;
    
    $result = $ticket->filtreTickets($condition);
    if ($print == 1) 
		
    	require_once('printing/fiches/printFiltreTicket.php');
    else
    {
    	//$result = $ticket->filtreTickets($condition);
		require_once("vue/admin/pannee/pannee.php");
    }
} 
function detailTicket($id)
{
	$user = new User();
	$ticket = new ticket();
	$client = new Client();
	require_once('vue/admin/pannee/detailTicket.php');
}
function ticketouvert()
{
	$statut = 'ouvert';
	$ticket = new ticket();
	require_once 'vue/admin/pannee/ticketParEtat.php';
}
function ticketfermer()
{
	$statut = 'fermer';
	$ticket = new ticket();
	require_once 'vue/admin/pannee/ticketParEtat.php';
}
function viewFiches()
{   $client = new Client();
	$ticket = new ticket();
	$vehicule = new Vehicule();
    $user = new User();
	require_once('vue/admin/fiches/viewFiches.php');
}
function inc_ficheinstallation()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
	$result = $ticket->recupererFicheInstallations();
    $customers = $client->getClientToCreateTicket();
	require_once('vue/admin/fiches/ficheinstallation.php');
}
function filtreInstallation($nom_client,$date1,$date2)
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();

	$condition1 = ($date1 == "" ? "" : " f.date_creation='".$date1."'");
	
	if ($date2 == '') 
	{
		$condition2 = '';
	}
	else
	{
		if ($date1 != '') 
		{
			$condition2 = " f.date_creation BETWEEN '".$date1."' AND '".$date2."'";
			$condition1 = '';
		}
		else $condition2 = " f.date_creation='".$date2."' ";
	}
	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = $nom_client == '' ? '' : "AND Nom_client LIKE '%".$nom_client."%' ";
	$condition = $condition1.$condition2.$condition3;
    //die(print_r($condition));
	$result = $ticket->filtreInstallation($condition);
    $customers = $client->getClientToCreateTicket();
	require_once('vue/admin/fiches/ficheinstallation.php');
}
function inc_fichedemenagement()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
    $result = $ticket->recupererFicheDemenagements();
	require_once('vue/admin/fiches/ficheDemenagement.php');
}
function filtreDemenagement($nom_client,$date1,$date2)
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();

	$condition1 = ($date1 == "" ? "" : " f.date_creation='".$date1."'");
	
	if ($date2 == '') 
	{
		$condition2 = '';
	}
	else
	{
		if ($date1 != '') 
		{
			$condition2 = " f.date_creation BETWEEN '".$date1."' AND '".$date2."'";
			$condition1 = '';
		}
		else $condition2 = " f.date_creation='".$date2."' ";
	}
	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = $nom_client == '' ? '' : "AND nom_client LIKE '%".$nom_client."%' ";
	$condition = $condition1.$condition2.$condition3;
	//die(print_r($condition));
	$result = $ticket->filtreDemenagement($condition);
	require_once('vue/admin/fiches/ficheDemenagement.php');
}
function inc_ficherecuperation()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
    $result = $ticket->recupererFicheRecuperations();
	require_once('vue/admin/fiches/ficheRecuperation.php');
}
function filtreFicheRecuperation($nom_client,$date1,$date2)
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();

	$condition1 = ($date1 == "" ? "" : " f.date_creation='".$date1."'");
	
	if ($date2 == '') 
	{
		$condition2 = '';
	}
	else
	{
		if ($date1 != '') 
		{
			$condition2 = " f.date_creation BETWEEN '".$date1."' AND '".$date2."'";
			$condition1 = '';
		}
		else $condition2 = " f.date_creation='".$date2."' ";
	}
	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = $nom_client == '' ? '' : "AND nom_client LIKE '%".$nom_client."%' ";
	$condition = $condition1.$condition2.$condition3;
	//die(print_r($condition));
	$result = $ticket->filtreFicheRecuperation($condition);
	require_once('vue/admin/fiches/ficheRecuperation.php');
}
function inc_ficheintervention()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
	$vehicule = new Vehicule();
	$result = $ticket->getFichesInterventions();
	require_once('vue/admin/fiches/ficheIntervention.php');
}
function filtreFicheIntervention($date_creation,$technicien)
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
	$vehicule = new Vehicule();

	$condition1 = ($date_creation == "" ? "" : " f.date_creation='".$date_creation."' ");
	$condition2 = ($technicien == "" ? "" : " f.technicien = '".$technicien."'");
	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition = $condition1.$condition2;
    //$condition = substr($condition, 3);
    $result = $ticket->filtreFicheIntervention($condition);
    require_once('vue/admin/fiches/ficheIntervention.php');
}
function inc_ficheaugmentationbp()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
    $result = $ticket->recupererFicheBandepanssantes();
	require_once('vue/admin/fiches/ficheAugmentationBp.php');
}
function filtreAugmentationBp($nom_client,$date1,$date2)
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();

	$condition1 = ($date1 == "" ? "" : " f.date_creation='".$date1."'");
	
	if ($date2 == '') 
	{
		$condition2 = '';
	}
	else
	{
		if ($date1 != '') 
		{
			$condition2 = " f.date_creation BETWEEN '".$date1."' AND '".$date2."'";
			$condition1 = '';
		}
		else $condition2 = " f.date_creation='".$date2."' ";
	}
	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = $nom_client == '' ? '' : "AND nom_client LIKE '%".$nom_client."%' ";
	$condition = $condition1.$condition2.$condition3;
	//die(print_r($condition));
	$result = $ticket->filtreAugmentationBp($condition);
	require_once('vue/admin/fiches/ficheAugmentationBp.php');
}
function inc_fichediminutionbp()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
    $result = $ticket->recupererFicheDiminution_Bandepanssantes();
	require_once('vue/admin/fiches/ficheDiminutionBp.php');
}
function filtreFicheDiminutionBp($nom_client,$date1,$date2)
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
	$condition1 = ($date1 == "" ? "" : " f.date_creation='".$date1."'");
	
	if ($date2 == '') 
	{
		$condition2 = '';
	}
	else
	{
		if ($date1 != '') 
		{
			$condition2 = " f.date_creation BETWEEN '".$date1."' AND '".$date2."'";
			$condition1 = '';
		}
		else $condition2 = " f.date_creation='".$date2."' ";
	}
	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = $nom_client == '' ? '' : "AND nom_client LIKE '%".$nom_client."%' ";
	$condition = $condition1.$condition2.$condition3;
	//die(print_r($condition));
	$result = $ticket->filtreFicheDiminutionBp($condition);
	require_once('vue/admin/fiches/ficheDiminutionBp.php');
}
function inc_fichedemission()
{
	$user = new User();
	$client = new Client();
	$ticket = new Ticket();
	require_once('vue/admin/fiches/ficheMission.php');
}
function genficheinstallation($idclient)
{
	//$idclient = preg_split("#[-]+#",$idclient);  
	$client = new Client();
	$ticket = new ticket();
    
    date_default_timezone_set("Africa/Bujumbura");
	//$created_at = date("Y-m-d H:i:s");
	$started_at = date('H:i:s');
    
	//$d = new DateTime();
	$datecreation = date("Y-m-d H:i:s");
	$etat =0;
	//if ($dataClient = $client->afficherUnClientPourCree_fiche($idclient)->fetch()) 
	//{
//saveTicket($idclient,$probleme,$closed_by,$idUser,$created_at,$updated_at,$description,$ticket_type,$status)			
		/*if ($ticket->saveTicket($idclient,"installation",$datecreation,$_SESSION['ID_user'],$datecreation,$datecreation,"installation","installation","ouvert")) 
		{
		    $data = $ticket->recuperationIdticket()->fetch();
		    $ticket_id = $data['id'];
		  
		    if ($ticket->insertionDescription($ticket_id,"installation","in_door",$_SESSION['ID_user'],$started_at,$started_at,$datecreation,$datecreation,$last_action ='non')) 
		    {
		    	if ($ticket->creerFiche($_SESSION['ID_user'],"installation",$datecreation)) 
				{

					if ($ticket->contenuFiche($ticket_id,"","0000-00-00","0000-00-00","",$datecreation,"0000-00-00","0000-00-00",$etat)) 
					{
						$generer = true;
						
						require_once('printing/fiches/fiche_d_installation.php');
					}
				}
		    }
		}
		else 
		{
		    echo "Insertion echoue";
		}*/
	//}
    if ($ticket->creerFiche($_SESSION['ID_user'],"installation",$datecreation)) 
    {
        $idfiche = $ticket->getMaxIdFicheByType("installation");
            
        if ($ticket->contenuFiche($idfiche,$ticket_id=NULL,"",null,null,"",$datecreation,null,null,$etat)) 
        {
            if ($ticket->saveTicket($idfiche,$idclient,"installation",$datecreation,$_SESSION['ID_user'],$datecreation,$datecreation,"installation","installation","ouvert")) 
            {
                $data = $ticket->recuperationIdticket()->fetch();
                $ticket_id = $data['id'];
                
                if ($ticket->insertionDescription($ticket_id,"installation","in_door",$_SESSION['ID_user'],$started_at,$started_at,$datecreation,$datecreation,$last_action ='non')) 
                {
                    header('location:regenficheinstallation-'.$idfiche);
                    /*if ($dataClient = $ticket->recupererFicheInstallation($idfiche)->fetch()) 
                    {
                        //$datecreation = $dataClient['date_creation'];
                        require_once('printing/fiches/fiche_d_installation.php');
                    }*/
                }
            }

            //require_once('printing/fiches/fiche_d_installation.php');
        }
    }
}
function updateFicheInstallation($idfiche,$idticket,$idclient)
{
	$ticket = new ticket();

	if ($ticket->changeCustomersToTickets($idticket,$idclient) > 0) 
	{
		header('location:regenficheinstallation-'.$idfiche);
	}
}
function regenficheinstallation($idfiche)
{
	$ticket = new ticket();
	if ($dataClient = $ticket->recupererFicheInstallation($idfiche)->fetch()) 
	{
		$generer = false;
		$datecreation = $dataClient['date_creation'];
		require_once('printing/fiches/fiche_d_installation.php');
	}
}
function inc_ficheAugmentionBP()
{
	$user = new User();
	require_once('vue/admin/pannee/ficheAugmentionBP.php');
}
function genficheBP($idclient,$datedebut,$datefin,$bandepassante)
{
	//$idclient = preg_split("#[-]+#",$idclient);
	$client = new Client();
	$ticket = new ticket();
	//$d = new DateTime();
	$etat =0;
	date_default_timezone_set("Africa/Bujumbura");
	$created_at = date("Y-m-d H:i:s");
	$started_at = date('H:i:s');

	/*if ($dataClient = $client->afficherUnClientPourCree_fiche($idclient)->fetch())
	{   	
		if ($ticket->saveTicket($idclient,"augmentationBP",$created_at,$_SESSION['ID_user'],$created_at,$created_at,"augmentationBP","augmentationBP","ouvert")) 
		{
		    $data = $ticket->recuperationIdticket()->fetch();
		    $id_ticket = $data['id'];
		    if ($ticket->insertionDescription($id_ticket,"augmentationBP","in_door",$_SESSION['ID_user'],$started_at,$started_at,$created_at,$created_at,$last_action ='non'))
		    {
		    	if ($ticket->creerFiche($_SESSION['ID_user'],"augmentationBP",date('Y-m-d'))) 
				{
			
					if ($ticket->contenuFiche($id_ticket,$bandepassante,$datedebut,$datefin,null,null,null,null,$etat)) 
					{
						$generer = true;
						require_once('printing/fiches/fiche_augmentationBP.php');
					}
				}
		    }
		}
		else 
		{
		    echo "Insertion echoue";
		}
	}*/
    if ($ticket->creerFiche($_SESSION['ID_user'],"augmentationBP",date('Y-m-d'))) 
    {
        $idfiche = $ticket->getMaxIdFicheByType("augmentationBP");
            
        if ($ticket->contenuFiche($idfiche,$id_ticket=NULL,$bandepassante,$datedebut,$datefin,null,null,null,null,$etat)) 
        {
            if ($ticket->saveTicket($idfiche,$idclient,"augmentationBP",$created_at,$_SESSION['ID_user'],$created_at,$created_at,"augmentationBP","augmentationBP","ouvert")) 
            {
                $data = $ticket->recuperationIdticket()->fetch();
                $id_ticket = $data['id'];
                if ($ticket->insertionDescription($id_ticket,"augmentationBP","in_door",$_SESSION['ID_user'],$started_at,$started_at,$created_at,$created_at,$last_action ='non'))
                {}
            }
            if ($dataClient = $ticket->recupererFicheBandepanssante($idfiche)->fetch()) 
            {
                require_once('printing/fiches/fiche_augmentationBP.php');
            }
        }
    }
}
function regenfichebandepassante($idfiche)
{
	$ticket = new ticket();
	if ($dataClient = $ticket->recupererFicheBandepanssante($idfiche)->fetch()) 
	{
		$generer = false;
		$datedebut = $dataClient['dateDebut'];
		$datefin = $dataClient['dateFin'];
		$bandepassante = $dataClient['bandeP'];
		require_once('printing/fiches/fiche_augmentationBP.php');
	}
}
function regenficheintervention($idfiche)
{
	$ticket = new ticket();
    $fiche = $ticket->getUserCreerFicheByFicheId($idfiche)->fetch();
	$nom_user = $fiche['nom_user'];
	$date_creation = $fiche['date_creation'];
	require_once('printing/fiches/fiche_de_panne.php');
}
function interventionT($message ="")
{
	$ticket = new ticket();
	$vehicule = new Vehicule();
	$user = new User();
	require_once('vue/admin/pannee/intervention.php');
}
function fichepanne($tb_ticket,$createurFiche,$technicien,$plaque)
{
	//verifier si toutes les variables sont vide
	$ticket = new ticket();
	$insertioncotenu = false;
	$etat =0;
	//echo "insertion reusie je valide dans la base de donnee";

	/*if ($ticket->creerFiche($_SESSION['ID_user'],"intervention",date('Y-m-d'),$technicien))
    {
    	$idfiche = $ticket->getMaxIdFicheByType("intervention");
		foreach ($tb_ticket as $key => $value) 
		{                       
		   	if ($ticket->contenuFiche($value,null,null,null,$plaque,null,null,null,$etat)) 
		   	{
		   		if ($ticket->updateEtatContenuFiche($value)) 
		   		{
		   			$insertioncotenu = true;
		   		}	    	
		   	}		    
	    }
	}
	if ($insertioncotenu) 
	{
        $fiche = $ticket->getUserCreerFicheByFicheId($idfiche)->fetch();
		$nom_user = $fiche['nom_user'];
		$date_creation = $fiche['date_creation'];
	 	require_once('printing/fiches/fiche_de_panne.php');
	}*/
    if ($ticket->creerFiche($_SESSION['ID_user'],"intervention",date('Y-m-d'),$technicien))
    {
    	$idfiche = $ticket->getMaxIdFicheByType("intervention");
		foreach ($tb_ticket as $key => $value) 
		{                       
		   	if ($ticket->contenuFiche($idfiche,$value,null,null,null,$plaque,null,null,null,$etat)) 
		   	{
		   		/*if ($ticket->updateEtatContenuFiche($value)) 
		   		{
		   			$insertioncotenu = true;
		   		}*/
		   		$insertioncotenu = true;	    	
		   	}		    
	    }
	}
	if ($insertioncotenu) 
	{
		header('location:regenficheintervention-'.$idfiche);
        /*$fiche = $ticket->getUserCreerFicheByFicheId($idfiche)->fetch();
		$nom_user = $fiche['nom_user'];
		$date_creation = $fiche['date_creation'];
	 	require_once('printing/fiches/fiche_de_panne.php');*/
	}
}
//************************************************************* FICHE DEMENAGEMENT*********************************************************************
function generer_fiche_demenagement()
{   
	require_once('vue/admin/pannee/generer_fiche_demenagement.php');
}

function fichedemenagement($customer,$new_adress,$oldAdresse,$dates)
{
	$customer = preg_split("#[_]+#", $customer);
	$idclient = $customer[0];
	$oldAdresse = strtoupper($customer[1]);
	//echo "idclient = ".$idclient."new_adress = ".$new_adress." oldAresse ".$oldAdresse."dates = ".$dates;
   
	$client = new Client();
	$ticket = new ticket();

	date_default_timezone_set("Africa/Bujumbura");
    $datecreation = date("Y-m-d");
    $created_at = date("Y-m-d H:i:s");
	$started_at = date('H:i:s');
	$etat=0;

	/*if ($client->updateAdresseClient($idclient,$new_adress,$oldAdresse) > 0)
    {	
    	if ($ticket->saveTicket($idclient,"demenagement",$created_at,$_SESSION['ID_user'],$created_at,$created_at,"demenagement","demenagement","ouvert"))  
    	{
    		$data = $ticket->recuperationIdticket()->fetch();

    		if ($ticket->insertionDescription($data['id'],"demenagement","in_door",$_SESSION['ID_user'],$started_at,$started_at,$created_at,$created_at,$last_action ='non')) 
    		{
    			if ($ticket->creerFiche($_SESSION['ID_user'],"demenagement",$dates))
    			{	
                    $idfiche = $ticket->getMaxIdFicheByType("demenagement");
    				if ($ticket->creerFicheDemanagement($idfiche,$dates,$data['id'])) 
    				{
    					if ($tb_client = $ticket->recupererFicheDemenagement($idfiche)->fetch()) 
						{
							$generer = false;
							$dates = $tb_client['dateDemenager'];
							$new_adress = $tb_client['adresse'];
							require_once('printing/fiches/fiche_demenagement.php');
						}
	    				//$generer = true;
	    				//require_once('printing/fiches/fiche_demenagement.php');
    				}
    			}
    		}
    	}

	}*/
    if ($client->updateAdresseClient($idclient,$new_adress,$oldAdresse) > 0)
    {	
        if ($ticket->creerFiche($_SESSION['ID_user'],"demenagement",$datecreation))
        {
            $idfiche = $ticket->getMaxIdFicheByType("demenagement");
            if ($ticket->contenuFiche($idfiche,NULL,"",NULL,NULL,"",null,null,$dates,$etat)) 
            {
                if ($ticket->saveTicket($idfiche,$idclient,"demenagement",$created_at,$_SESSION['ID_user'],$created_at,$created_at,"demenagement","demenagement","ouvert"))  
                {
                    $data = $ticket->recuperationIdticket()->fetch();
                    if ($ticket->insertionDescription($data['id'],"demenagement","in_door",$_SESSION['ID_user'],$started_at,$started_at,$created_at,$created_at,$last_action ='non')) 
                    {
                        header('location:regenfichedemenagement-'.$idfiche);
                    }
                }
            }
        }
	}
}
function updateFicheDemenagement($idclient,$new_adress,$oldAdresse,$dates,$idfiche)
{
	$oldAdresse = strtoupper($oldAdresse);
	$new_adress = strtoupper($new_adress);
	//echo "idclient = ".$idclient[1]."new_adress = ".$new_adress."dates = ".$dates;
	$client = new Client();
	$ticket = new ticket();

	if ($client->updateAdresseClient($idclient,$new_adress,$oldAdresse) > 0)
    {
		if ($ticket->updateContenuFicheDemenagement($idfiche,$dates) > 0) 
		{
			$_SESSION['success'] = 'Modification reusie';
			header('location:inc_fichedemenagement');
		}
	}
}
function fiche_de_recuperation($idclient,$dates,$status)
{
	//$idclient = preg_split("#[-]+#", $idclient);
	
	$client = new Client();
    $contract = new Contract();
	$ticket = new ticket();
	$old_adresse;

	date_default_timezone_set("Africa/Bujumbura");
	$created_at = date("Y-m-d H:i:s");
	$started_at = date('H:i:s');

	//$d = new DateTime();
	$datecreation = date("Y-m-d");
	$etat =0;
	/*if( $tb_client = $client->afficherUnClientPourCree_fiche($idclient)->fetch()) 
	{
		
    	if ($ticket->saveTicket($idclient,"recuperation",$dates,$_SESSION['ID_user'],$datecreation,$datecreation,"recuperation","recuperation","ouvert")) 
    	{
    		$data = $ticket->recuperationIdticket()->fetch();


    		if ($ticket->insertionDescription($data['id'],"recuperation","in_door",$_SESSION['ID_user'],$started_at,$started_at,$datecreation,$datecreation,$last_action ='non')) 
    		{
    			if ($ticket->creerFiche($_SESSION['ID_user'],"recuperation",$dates))
    			{

    				if ($ticket->contenuFiche($data['id'],"","0000-00-00","0000-00-00","","0000-00-00",$dates,"0000-00-00",$etat)) 
    				{
    					$generer = true;
    					require_once('printing/fiches/ficheRecuperation_de_materiels.php');
    				}
    			}
    		}
    	}
	}
	else echo "Le client n'existe pas";*/
    if ($ticket->creerFiche($_SESSION['ID_user'],"recuperation",$datecreation))
    {
        $idfiche = $ticket->getMaxIdFicheByType("recuperation");
        if ($ticket->contenuFiche($idfiche,NULL,"",NULL,NULL,"",NULL,$dates,NULL,$etat)) 
        {
            if ($ticket->saveTicket($idfiche,$idclient,"recuperation",$created_at,$_SESSION['ID_user'],$created_at,$created_at,"recuperation","recuperation","ouvert")) 
            {
                $data = $ticket->recuperationIdticket()->fetch();
                if ($ticket->insertionDescription($data['id'],"recuperation","in_door",$_SESSION['ID_user'],$started_at,$started_at,$created_at,$created_at,$last_action ='non')) 
                {
                    if ($status == 'terminer') 
					{
						if ($client->updateTypeAndEtat($idclient,'gone','terminer') > 0) 
						{
							/*$solde = $client->getSoldeClient($idclient);
	        				$cutoff_order = $contract->get_max_cutoff_order()+1;
							if ($contract->setCutoff_detail($cutoff_order,$idclient,$solde,'terminer','BIF','',date('Y-m-d'),$created_at,'oui')) 
							{
								# code...
							}*/
						}
						if ($contract->updateEtatContract($idclient,'terminer') > 0) 
						{	
						}
					}
                    header('location:regenficherecuperation-'.$idfiche);
                }
            }
        }
    }
}
function update_fiche_de_recuperation($idclient,$date_creation,$idfiche,$idticket,$idContenuFiche)
{
	$client = new Client();
	$ticket = new ticket();
	
	if ($ticket->updateFiche($idfiche,$date_creation) > 0)
	{
		if ($ticket->updateContenuFicheRecuperation($idContenuFiche,$date_creation) > 0) 
		{
			if ($ticket->updateTicketsCreatedAt($idticket,$date_creation) > 0) 
	    	{
	    		if ($ticket->updateTicketActionCreatedAt($idticket,$date_creation) > 0) 
				{
					header('location:regenficherecuperation-'.$idfiche);
				}
	    	}
		}
	}
}
function genfiche_diminuBP($idclient,$datedebut,$datefin,$bandepassante)
{
	/*if (empty($idclient) || empty($datedebut) || empty($datefin) || empty($bandepassante)) 
	{
		//$msg = "Vous devez renseigner toutes les informations";
		require_once('vue/admin/pannee/ficheDiminutionBandeP.php');
		//header("location:ficheinstallation");
	}
	elseif ($datedebut < date('Y-m-d') || $datefin < date('Y-m-d')) 
	{
		$msg = "Vous avez choisi une date anterieure";
		require_once('vue/admin/pannee/ficheDiminutionBandeP.php');
	}
	elseif ($datedebut > $datefin) 
	{
		$msg = "La deuxieme date doit etre superieure à la premieure";
	}
	else
	{*/
		//$idclient = preg_split("#[-]+#",$idclient);
		$client = new Client();
		$ticket = new ticket();

		date_default_timezone_set("Africa/Bujumbura");
		//$created_at = date("Y-m-d H:i:s");
		$started_at = date('H:i:s');
		//$d = new DateTime();
		$etat =0;
		$datecreation = date("Y-m-d H:i:s");
		/*if ($dataClient = $client->afficherUnClientPourCree_fiche($idclient)->fetch())
		{   	

			if ($ticket->saveTicket($idclient,"diminutionBP",$datecreation,$_SESSION['ID_user'],$datecreation,$datecreation,"diminutionBP","diminutionBP","ouvert")) 
			{
			    $data = $ticket->recuperationIdticket()->fetch();
			    $id_ticket = $data['id'];
			    if ($ticket->insertionDescription($id_ticket,"diminutionBP","in_door",$_SESSION['ID_user'],$started_at,$started_at,$datecreation,$datecreation,$last_action ='non'))
			    {
			    	if ($ticket->creerFiche($_SESSION['ID_user'],"diminutionBP",date('Y-m-d'))) 
					{
						if ($ticket->contenuFiche($id_ticket,$bandepassante,$datedebut,$datefin,null,null,null,null,$etat)) 
						{
							$generer = true;
							require_once('printing/fiches/fiche_diminutionBP.php');
						}
					}
			    }
			}
			else 
			{
			    echo "Insertion echoue";
			}
		}*/
	//}
    if ($ticket->creerFiche($_SESSION['ID_user'],"diminutionBP",date('Y-m-d'))) 
    {
        $idfiche = $ticket->getMaxIdFiche()->fetch()['ID_fiches'];
        if ($ticket->contenuFiche($idfiche,$id_ticket=null,$bandepassante,$datedebut,$datefin,null,null,null,null,$etat)) 
        {
            if ($ticket->saveTicket($idfiche,$idclient,"diminutionBP",$datecreation,$_SESSION['ID_user'],$datecreation,$datecreation,"diminutionBP","diminutionBP","ouvert")) 
            {
                $data = $ticket->recuperationIdticket()->fetch();
                $id_ticket = $data['id'];
                if ($ticket->insertionDescription($id_ticket,"diminutionBP","in_door",$_SESSION['ID_user'],$started_at,$started_at,$datecreation,$datecreation,$last_action ='non'))
                {
                    $generer = true;
                    $dataClient = $ticket->regenfichediminution_bp($idfiche)->fetch();
                    require_once('printing/fiches/fiche_diminutionBP.php');
                }
            }
        }
    }
}
function regenfichediminution_bp($idfiche)
{
	
	$ticket = new Ticket();
	$client = new Client();


	if ($dataClient = $ticket->regenfichediminution_bp($idfiche)->fetch()) 
	{
		//echo "voici id fiche ".' '.$idfiche;
		$generer = false;
		$datedebut = $dataClient['dateDebut']; 
		$datefin = $dataClient['dateFin'];
		$bandepassante = $dataClient['bandeP'];
		//print_r($datedebut.' '.$datefin.' '.$bandepassante);
		require_once('printing/fiches/fiche_diminutionBP.php');
	}
}
function regenfichedemenagement($idfiche)
{
	$ticket = new ticket();
	if ($tb_client = $ticket->recupererFicheDemenagement($idfiche)->fetch()) 
	{
		//$generer = false;
		//$dates = $tb_client['dateDemenager'];
		//$new_adress = $tb_client['adresse'];
		require_once('printing/fiches/fiche_demenagement.php');
	}
}
function genereOrdremission($datemission,$dateRetour,$technicien)
{ 
	//die(print_r($technicien));
	$user = new User();
	require_once('printing/fiches/ordreMission.php');
}
function generefichepanne()
{
	require_once('printing/fiches/fichePanneCommrntaireclient.php');
}
function genererFiche_recuperation()
{
	require_once('vue/admin/pannee/recuperation_materiels.php');
}

function regenficherecuperation($idfiche)
{
	$ticket = new ticket();
	if ($tb_client = $ticket->recupererFicheRecuperation($idfiche)->fetch()) 
	{
		$generer = false;
		$dates = $tb_client['dateRecuperation'];
		require_once('printing/fiches/ficheRecuperation_de_materiels.php');
	}
}
function getinstalation_du_mois($mois,$annee)
{
	//echo "Bonjour ".$mois.'---'.$annee;
    $ticket = new ticket();
	$client = new Client();
	require_once('printing/fiches/installation_dumois.php');
}
