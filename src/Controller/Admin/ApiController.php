<?php 
	namespace App\Controller\Admin;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;
	use App\Repository\AdminRepository;
	use App\Entity\Admin;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	/**
	* @Route("api/")
	*/
	class ApiController extends AbstractController{
		private $_admin_rep;

		public function __construct(AdminRepository $admin_rep){
			$this->_admin_rep = $admin_rep;
		}
		/* start function for manage admins*/

		/**
		* @Route("viewAdmin/{id}", name="viewAdmin")
		*/
		public function view_admin($id){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException("Vous n'avez pas le droit d'utiliser cette fonctinnalité");
		    }
		    $data = $this->_admin_rep->getAdmin($id);
		    return new JsonResponse($data);
		}
		/**
		* @Route("viewAdminSec/{id}", name="viewAdminSec")
		*/
		public function view_adminSec($id){
		    $data = $this->_admin_rep->getAdminSec($id);
		    return new JsonResponse($data);
		}
		/**
		* @Route("getAdminList/{number}", name="getAdminList", 
		* defaults={"number":10})
		*/
		public function get_admin_list($number,Request $req){
			if (!$req->isXmlHttpRequest() AND !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException("Vous n'avez pas le droit d'utiliser cette fonctinnalité");
		    }
		    //recuperer les 20 premiers 
		    $data_native = $this->_admin_rep->getList($number);
		    //les classer par order alphabetique
		    //grouper les par authorité
			return new JsonResponse($data_native);
		}
		/**
		* @Route("getAdminListSec/{number}", name="getAdminListSec", 
		* defaults={"number":10})
		*/
		public function get_admin_listSec($number,Request $req){
		    //recuperer les 20 premiers 
		    $data_native = $this->_admin_rep->getListSec($number);
		    //les classer par order alphabetique
		    //grouper les par authorité
			return new JsonResponse($data_native);
		}
		/**
		* @Route("createAdmin", name="createAdmin")
		*/
		public function create_admin(Request $req, UserPasswordEncoderInterface $encoder){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException("Vous n'avez pas le droit d'utiliser cette fonctinnalité");
		    }
		    $new_admin = new Admin();
		    $req = $req->request;
		    $em = $this->getDoctrine()->getManager();

		    $new_admin->setUsername($req->get('username'));
		    $new_admin->setFirstname($req->get('name'));
		    $new_admin->setFamilyname($req->get('familyname'));
		    $new_admin->setPassword($encoder->encodePassword($new_admin,$req->get('password')));
		    $new_admin->setTel($req->get('tel'));
		    $new_admin->setEmail($req->get('email'));
		    $new_admin->setNationality($req->get('nationnality'));
		    $new_admin->setSexe('H');
		    $new_admin->setJob($req->get('role'));
		    $new_admin->setRoles($req->get('authority'));
		    $new_admin->setBiography('');
		    $new_admin->setOccupation('');

			$em->persist($new_admin);
			$em->flush();
			return new JsonResponse(true);
		    
		}
		/**
		* @Route("deleteAdmin/{id}", name="deleteAdmin")
		*/
		public function delete_admin($id){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException("Vous n'avez pas le droit d'utiliser cette fonctinnalité");
		    }
		    if($id != 1){
			    if($this->_admin_rep->delete($id)){
			    	return new JsonResponse(true);
			    }
			    else{
			    	return new JsonResponse(false);
			    }
			}
			else{
				return new JsonResponse(false);
			}

		}
		/**
		* @Route("updateAdmin", name="updateAdmin")
		*/
		public function update_admin(){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException("Vous n'avez pas le droit d'utiliser cette fonctinnalité");
		    }
		}
		/**
		* @Route("blockAdmin", name="blockAdmin")
		*/
		public function block_admin(){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException("Vous n'avez pas le droit d'utiliser cette fonctinnalité");
		    }
		}
		/* end function for manage admins*/
	}