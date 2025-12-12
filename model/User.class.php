<?php
/**
 * classe utilisateur
 */
class User
{
	
	/*function recupererUnUser($login,$password)
	{
		$con = connection();
		$query = $con->prepare('SELECT ID_user,nom_user,profil_user.profil_id,profil_name FROM user,profil_user WHERE login = :login AND password = :password AND user.profil_id = profil_user.profil_id');
		$query->execute(array('login' => $login,'password' => $password)) or die(print_r($query->errorInfo()));
		return $query;
	}*/
	function recupererUnUser($login, $password) 
{
    $con = connection();

    // Récupère l'utilisateur par login seulement
    $query = $con->prepare('
        SELECT 
            user.ID_user,
            user.nom_user,
            user.password,           -- <--- ajouté ici
            profil_user.profil_id,
            profil_user.profil_name,
            user.must_change_password
        FROM user
        JOIN profil_user ON user.profil_id = profil_user.profil_id
        WHERE user.login = :login
    ');

    $query->execute(['login' => $login]) or die(print_r($query->errorInfo()));
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user; // mot de passe correct
    }

    return false; // login inexistant ou mot de passe incorrect
}
    function getUserInfoByEmail($email)
	{
		$con = connection();
		$query = $con->prepare('SELECT * FROM user WHERE email = :email');
		$query->execute(['email' => $email]) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function updateRecoveryToken($email,$recovery_date,$token)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET password_recovery_date =:recovery_date,token =:token WHERE email = :email");
		$res = $query->execute(['recovery_date' => $recovery_date,'token' => $token,'email' => $email]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updatePasswordByToken($password,$token)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET password =:password,token ='' WHERE token = :token");
		$res = $query->execute(['password' => $password,'token' => $token]) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function recupereRole()
	{
	 	$con = connection();
		$query = $con->prepare("SELECT ID_user,role FROM user");
		$query->execute();
		$rs = array();
		while ($data =$query->fetchObject()) {
			# code...
			$rs[] = $data;
		}
		return $rs;
	}*/
	function update_etat($iduser,$etat)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET statut =:etat WHERE ID_user =:iduser");
		$res = $query->execute(['etat' => $etat,'iduser' => $iduser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function update_user_desactiver($iduser,$new_etat)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET statut =:new_etat WHERE ID_user =:iduser");
		$res = $query->execute(['new_etat' => $new_etat,'iduser' => $iduser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function ajout_User($nomuser,$mail_user,$prenom,$password,$profil_id,$login,$date_creation,$etat)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO user(nom_user,prenom,email,login,password,profil_id,date_creation,statut) VALUES (:nomuser,:prenom,:mail_user,:login,:password,:profil_id,:date_creation,:etat)");
		$rs = $query->execute(array('nomuser' =>$nomuser,'prenom'=>$prenom,'mail_user' =>$mail_user,'password' =>$password,'profil_id' =>$profil_id,'login' => $login,'date_creation'=>$date_creation,'etat'=>$etat)) or die(print_r($query->errorInfo()));
		return $rs;
	}
    function getUserById($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM user WHERE ID_user = ?");
		$query->execute([$iduser]);
		return $query;
	}
	function afficheUser($iduser)
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM user WHERE ID_user = ?");
	 	$query->execute(array($iduser));
	 	$rs = array();
	 	while ( $data = $query->fetchObject()) 
	 	{
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function afficheUsers()
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT ID_user,nom_user,profil_name FROM user,profil_user pu WHERE user.profil_id = pu.profil_id");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getLastUser()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_user) as ID_user FROM user");
		$query->execute();
		return $query;
	}
	function getID_societe()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_societe  FROM info_societe");
		$query->execute();
		return $query;
	}
	function getID_fournisseur()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_fournisseur  FROM fournisseur");
		$query->execute();
		return $query;
	}
	
	function selectionUser()
	{
		$con = connection();
		$query = $con->prepare("SELECT user.ID_user,profil_name,nom_user,prenom FROM `profil_user`,`user` WHERE `profil_user`.profil_id =`user`.profil_id AND `profil_user`.profil_name = 'technicien'");
		$query->execute();
		$rs = array();
		while ($data =$query->fetchObject()) {
			# code..
			$rs[] = $data;
		}
		return $rs;
	}
    function getTechniciens()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_user,nom_user,prenom FROM user WHERE role = 'technicien'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getMaxProfilIdUser()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(profil_id) AS profil_id FROM profil_user");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query;
	}
	function get_utulisateur()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM user");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getAllProfilUser()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM profil_user");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function getProfilUserNotHaveDashboard()
	{
		$con = connection();
		$query = $con->prepare("SELECT profil_id,profil_name FROM profil_user WHERE profil_user.profil_id NOT IN (SELECT profil_id FROM dashboard)");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getProfilUserWithDashboard()
	{
		$con = connection();
		$query = $con->prepare("SELECT p.profil_id,p.profil_name,page FROM profil_user p,dashboard d WHERE p.profil_id = d.profil_id");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function affiche_permission_par_profil($profil_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,profil_user.profil_id,page,L,C,M,S FROM `profil_user_permission`,`profil_user` WHERE profil_user_permission.profil_id = profil_user.profil_id AND profil_user.profil_id = ?");
		$query->execute(array($profil_id)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function affiche_user_avec_profil()
	{
		$con = connection();
		$query =$con->prepare("SELECT * FROM user,profil_user WHERE user.profil_id = profil_user.profil_id AND nom_user <> 'crm'");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function afficheprofilUser($iduser)
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT nom_user,prenom,profil_user.profil_id,profil_name,email,login,photo FROM user,profil_user WHERE user.profil_id = profil_user.profil_id AND user.ID_user =?");
	 	$query->execute(array($iduser));
	 	$rs = array();
	 	while ( $data = $query->fetchObject()) 
	 	{
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function image_user($iduser)
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT photo FROM user WHERE ID_user =?");
	 	$query->execute(array($iduser));
	 	$rs = array();
	 	while ( $data = $query->fetchObject()) 
	 	{
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function setProfil_user($profil_name)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO profil_user(profil_name) VALUES(:profil_name)");
		$query->execute(array('profil_name' => $profil_name));
		return $query->errorInfo();
	}
	function setProfil_user_permession($profil_id,$page,$L,$C,$M,$S,$page_accept)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO profil_user_permission(profil_id,page,L,C,M,S,page_accept) VALUES(:profil_id,:page,:L,:C,:M,:S,:page_accept)");
		$res = $query->execute(array('profil_id' => $profil_id,'page' => $page,'L' => $L,'C' => $C,'M' => $M,'S' => $S,'page_accept' => $page_accept)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getPermissionDunUser($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT user.ID_user,nom_user,page,L,C,M,S FROM profil_user pu,user,profil_user_permission pup WHERE user.profil_id = pu.profil_id AND pu.profil_id = pup.profil_id AND user.ID_user = ? AND page_accept = 1");
		$query->execute(array($iduser)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{ 
			$res[] = $data;
		}
		return $res;
	}
	function verifierPermissionDunePage($page,$iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT page,L,C,M,S FROM user,profil_user pu,profil_user_permission pup WHERE user.profil_id = pu.profil_id AND pu.profil_id = pup.profil_id AND page = :page AND user.ID_user =:iduser AND page_accept = 1");
		$query->execute(array('page' => $page,'iduser' => $iduser)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function update_permission($idpermission,$lire,$creer,$modifier,$supprimer,$page_accept)
	{
		$con = connection();
		$query = $con->prepare("UPDATE profil_user_permission SET L=:L,C=:C,M=:M,S=:S,page_accept=:page_accept WHERE id=:idpermission");
		$res = $query->execute(array('L' => $lire,'C' => $creer,'M' => $modifier,'S' => $supprimer,'page_accept' => $page_accept,'idpermission' => $idpermission)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getDashboardPage($profil_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM dashboard WHERE profil_id = ?");
		$query->execute([$profil_id]);
		return $query;
	}
	function setDashboardToProfil($profil_id,$dashboard)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO dashboard(profil_id,page) VALUES(:profil_id,:page)");
		$res = $query->execute(['profil_id' => $profil_id,'page' => $dashboard]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateDashboardToProfil($profil_id,$dashboard)
	{
		$con = connection();
		$query = $con->prepare("UPDATE dashboard SET page =:page WHERE profil_id =:profil_id");
		$res = $query->execute(['page' => $dashboard,'profil_id' => $profil_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function UpdateUser($iduser,$nomuser,$mail_user,$role)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET nom_user = :nomuser,email = :mail_user,role =:role WHERE ID_user = :iduser");
		$rs = $query->execute(array('nomuser' => $nomuser,'mail_user' => $mail_user,'role'=>$role,'iduser' =>$iduser)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function deleteUser($iduser)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM user WHERE ID_user = ?");
	 	$rs = $query->execute(array($iduser)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function creerTaux($taux,$description,$date_ajout)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO taux(taux,description,date_ajout) VALUES(:taux,:description,:date_ajout)");
		$res = $query->execute(array('taux' => $taux,'description' => $description,'date_ajout' => $date_ajout)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getTaux()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM taux");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query;
	}
	function updateTaux($taux,$description,$date_ajout)
	{
		$con = connection();
		$query = $con->prepare("UPDATE taux SET taux =:taux,description =:description,date_ajout =:date_ajout");
		$res = $query->execute(array('taux' => $taux,'description' => $description,'date_ajout' => $date_ajout)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function update_profil($iduser,$profil_id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET profil_id = :profil_id WHERE ID_user = :iduser");
		$rs = $query->execute(array('profil_id' => $profil_id,'iduser' => $iduser)) or die(print_r($query->errorInfo()));
		return $rs;
	}
    function deletecet_utilisateur($iduser_delete)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM user WHERE ID_user = ?");
	 	$rs = $query->execute(array($iduser_delete)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function changemp($nomss,$nouveaupassword)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET  password = :nouveaupassword WHERE nom_user = :nomss");
		$rs = $query->execute(array('nouveaupassword' => $nouveaupassword,'nomss' => $nomss)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function modifier_profil($idprof,$nomprofil)
	{
		$con = connection();
		$query = $con->prepare("UPDATE profil_user SET  profil_name = :nomprofil WHERE profil_id = :idprof");
		$rs = $query->execute(array('nomprofil' => $nomprofil,'idprof' => $idprof)) or die(print_r($query->errorInfo()));
		return $rs; 
	}
	function supprimeprofil($numprof) 
	{
		$con = connection();
	 	$query = $con->prepare("DELETE FROM profil_user WHERE profil_id = ?");
	 	$rs = $query->execute(array($numprof)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function modif_detailprofil($identifiant,$nomuser,$prenomuser,$adresmail,$loginuser)
	{
		$con = connection();
		$query = $con->prepare("UPDATE user SET  nom_user = :nomuser,prenom = :prenomuser,email = :adresmail,login = :loginuser WHERE ID_user = :identifiant");
		$rs = $query->execute(array('nomuser' => $nomuser,'prenomuser' => $prenomuser,'adresmail' => $adresmail,'loginuser' => $loginuser,'identifiant' => $identifiant)) or die(print_r($query->errorInfo()));
		return $rs; 
	}
	function modifierphotoprofil($idutilisateur,$photo)
 	{
 		$con = connection();
		$query = $con->prepare("UPDATE user SET photo = :photo WHERE ID_user = :idutilisateur");
		$rs = $query->execute(array('photo' => $photo,'idutilisateur' =>$idutilisateur)) or die(print_r($query->errorInfo()));
		return $rs;
 	}
 	function image_profil($iduser)
 	{
 		$con = connection();
	 	$query = $con->prepare("SELECT * FROM photoprofil WHERE ID_user = ?");
	 	$query->execute(array($iduser));
	 	$rs = array();
	 	while ( $data = $query->fetchObject()) 
	 	{
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
 
	/****************
	**  INFO SOCIETE
	*****************/
	function getInfoSociete()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM info_societe");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getNomSociete()
	{
		$con = connection();
		$query = $con->prepare("SELECT nom FROM info_societe");
		$query->execute();
		return $query;
	}
	function get_ville()
	{
		$con = connection();
		$query = $con->prepare("SELECT ville FROM info_societe");
		$query->execute();
		return $query;
	}
	function get_nif()
	{
		$con = connection();
		$query = $con->prepare("SELECT nif FROM info_societe");
		$query->execute();
		return $query;
	}
	function get_phone()
	{
		$con = connection();
		$query = $con->prepare("SELECT phone FROM info_societe");
		$query->execute();
		return $query;
	}
	function get_mail()
	{
		$con = connection();
		$query = $con->prepare("SELECT email FROM info_societe");
		$query->execute();
		return $query;
	}
	function get_adresse()
	{
		$con = connection();
		$query = $con->prepare("SELECT localisation FROM info_societe");
		$query->execute();
		return $query;
	}
	function setInfoSociete($nom,$adresse,$ville,$phone,$email,$nif,$centreFiscal,$secteur,$boiteP,$forme)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO info_societe(nom,localisation,ville,phone,email,boitePostal,nif,centreFiscal,secteurActivite,formeJuridique) VALUES(:nom,:adresse,:phone,:email,:boitePostal,:nif,:centreFiscal,:secteur,:forme)");
		$res = $query->execute(['nom'=>$nom,'adresse'=>$adresse,'ville'=>$ville,'phone'=>$phone,'email'=>$email,'boitePostal'=>$boiteP,'nif'=>$nif,'centreFiscal'=>$centreFiscal,'secteur'=>$secteur,'forme'=>$forme]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateInfoSociete($id,$nom,$adresse,$ville,$phone,$email,$nif,$centreFiscal,$secteur,$boiteP,$forme)
	{
		$con = connection();
		$query = $con->prepare("UPDATE info_societe SET nom=:nom,localisation=:adresse,ville =:ville,phone=:phone,email=:email,boitePostal=:boitePostal,nif=:nif,centreFiscal=:centreFiscal,secteurActivite=:secteur,formeJuridique=:forme WHERE ID_societe=:id");
		$res = $query->execute(['id'=>$id,'nom'=>$nom,'adresse'=>$adresse,'ville'=>$ville,'phone'=>$phone,'email'=>$email,'boitePostal'=>$boiteP,'nif'=>$nif,'centreFiscal'=>$centreFiscal,'secteur'=>$secteur,'forme'=>$forme]) or die(print_r($query->errorInfo()));
		return $res;
	}
function ajouter_fournisseur($nom,$prenom,$adres,$phone,$mail,$fonction,$datecreation,$userName)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO fournisseur(nom,prenom,adres,phone,mail,fonction,datecreation,userName) VALUES(:nom,:prenom,:adres,:phone,:mail,:fonction,:datecreation,:userName)");
		$res = $query->execute(['nom'=>$nom,'prenom'=>$prenom,'adres'=>$adres,'phone'=>$phone,'mail'=>$mail,'fonction'=>$fonction,'datecreation'=>$datecreation,'userName'=>$userName]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getfourniseur()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM fournisseur");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function modifier_fournisseur($idfournisseur,$nom,$prenom,$adres,$phone,$mail,$fonction,$datecreation)
	{
		$con = connection();
		$query = $con->prepare("UPDATE fournisseur SET nom=:nom,prenom=:prenom,adres =:adres,phone=:phone,mail=:mail,fonction=:fonction,datecreation=:datecreation WHERE ID_fournisseur=:idfournisseur");
		$res = $query->execute(['idfournisseur'=>$idfournisseur,'nom'=>$nom,'prenom'=>$prenom,'adres'=>$adres,'phone'=>$phone,'mail'=>$mail,'fonction'=>$fonction,'datecreation'=>$datecreation]) or die(print_r($query->errorInfo()));
		return $res;
	}
}                    

?>