<?php
class Db_model extends CI_Model {
	// se connecter à la base de données.
	public function __construct()
	{
		$this->load->database();
	}

	/* fonction qui recupère les données d'un compte */
	public function get_compte($pseudo){

		$query = $this->db->query("SELECT * FROM T_COMPTE_CPT join T_PROFIL_PFL using(cpt_id) where cpt_pseudo='".$pseudo."' ;");
		return $query->row() ;

	}
	/* fonction qui récupère tous les pseudos de comptes */
	public function get_all_compte()
	{
		$query = $this->db->query("SELECT cpt_pseudo FROM T_COMPTE_CPT;");
		return $query->result_array();
	}
	/* fonction qui récupère le nombre de comptes  */
	public function get_number_compte()
	{
		$query = $this->db->query("SELECT count(*) as number_accounts FROM T_COMPTE_CPT;");
		return $query->row();
	}
	/* fonction qui récupère une actualité dont on connait l'identifiant */
	public function get_actualite($numero)
	{
		$query = $this->db->query("SELECT new_id , new_description FROM T_NEWS_NEW WHERE
		new_id=".$numero.";");
		return $query->row();
	}
	/* fonction qui recupère tous les actualités */
	public function get_all_news()
	{
		$query =$this->db->query("select new_id,new_intitule,new_description,new_date,cpt_pseudo from T_NEWS_NEW join T_COMPTE_CPT using(cpt_id) ;");
		return $query->result_array();
	}
	// fonction qui recupère l'intitulé , les questions et  les réponses  d'un match 
	public function get_match($code)

	{
		$query =$this->db->query("select mat_id ,mat_intitule ,qui_intitule, que_intitule ,rep_texte from T_MATCH_MAT join T_QUIZ_QUI using (qui_id) join T_QUESTION_QUE using(qui_id) join T_REPONSE_REP using (que_id) where mat_code='".$code."';");

		return $query->result_array();
	}

	// fonction qui recupère tous les matchs de quizs activés et leurs données

	public function get_all_match(){

		$query=$this->db->query("select pseudo(T_QUIZ_QUI.cpt_id) as quiz_auteur , qui_id, qui_etat, qui_intitule,pseudo(T_MATCH_MAT.cpt_id) as match_auteur, mat_intitule,mat_debut,mat_fin,mat_code from T_QUIZ_QUI left outer join T_MATCH_MAT using (qui_id) where qui_etat='A';");
		return $query->result_array() ;
	}

    // fonction qui recupère les données d'un match 
	public function get_data_match($code){

		$query =$this->db->query("select mat_etat , mat_fin , mat_debut from T_MATCH_MAT where mat_code='".$code."';");

		return $query->row();

	}

	// Fonction qui insère une ligne dans la table des comptes
	public function set_compte()
	{
		$this->load->helper('url');

		$id=$this->input->post('id');
		$mdp=$this->input->post('mdp');
		$etat=$this->input->post('etat');
		$role=$this->input->post('role');

		$req="INSERT INTO T_COMPTE_CPT VALUES (NULL,'".$id."','".$mdp."','".$etat."','".$role."');";
		$query = $this->db->query($req);
		return ($query);
	}

	// fonction qui insère une ligne dans la table joueur
	public function add_joueur()
	{
		$this->load->helper('url');

		$pseudo=$this->input->post('pseudo');
		$code=$this->input->post('code');

		
		$query1=$this->db->query("SELECT mat_id FROM T_MATCH_MAT where mat_code='".$code."';");
		$result=$query1->row();
		$id=$result->mat_id ;

		$req1="INSERT INTO T_JOUEUR_JOU VALUES (NULL,'".$pseudo."',".$id.",0);";
		$query = $this->db->query($req1);
		return ($query);

	}

	// fonction qui recupère le nombre de joueur ayany le même pseudo pendant le même match  
	public function verif_pseudo($code)
	{
		$this->load->helper('url');

		$pseudo=$this->input->post('pseudo');

		$query1=$this->db->query("SELECT mat_id FROM T_MATCH_MAT where mat_code='".$code."';");
		$result=$query1->row();
		$id=$result->mat_id ;
		

	   $query2=$this->db->query("SELECT count(*) as existe FROM T_JOUEUR_JOU where mat_id=".$id." and jou_pseudo='".$pseudo."' ;");
	  	return $query2->row();
	}



	//fonction qui véifie l'identifiant et le mot de passe saisie pour la connexion 
	public function connect_compte($username, $password)
	{
		$query =$this->db->query("SELECT cpt_pseudo,cpt_mdp FROM T_COMPTE_CPT WHERE cpt_pseudo='".$username."' AND cpt_mdp='".$password."';");
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	// fonction qui recupère l'état du profil (activé ou desactivé).
	public function state_compte($username){

		$query =$this->db->query("SELECT cpt_etat from T_COMPTE_CPT where cpt_pseudo='".$username."';");
		return $query->row();
	}


	// fonction qui recupère le rôle du profil (administrateur ou formateur )
	public function role_compte($username){

		$query =$this->db->query("SELECT cpt_role from T_COMPTE_CPT where cpt_pseudo='".$username."';");
		return $query->row();

	}

	// fonction qui modifie un mot de passe d'un utilisateur
	public function update_password($username,$password){

		$query=$this->db->query("UPDATE T_COMPTE_CPT set cpt_mdp='".$password."' where cpt_pseudo='".$username."';") ;
		return($query) ;
	}

	// fonction  qui renvoie le score d'un match donné.
	public function get_score($code){

		
		$query=$this->db->query("select taux_reussite_globale('".$code."') as score ") ;
		return $query->row();
	}


}
?>