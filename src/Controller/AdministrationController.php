<?php 
	
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use App\Form\AdminType;
	use App\Entity\Admin;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;

	/**
	* @Route("/admin")
	*/
	class AdministrationController extends AbstractController{
		/**
		* @Route("/home", name="administration_home")
		*/
		public function home(){
			return $this->render('backend/global/home.html.twig');
		}
		/**
		* @Route("/article/write", name="write_article")
		*/
		public function writeArticle(){
			return $this->render('backend/articleBundle/write.html.twig');
		}
		/**
		* @Route("/articles/display", name="get_articles")
		*/
		public function displayArticles(){
			return $this->render('backend/articleBundle/get.html.twig');
		}
		/**
		* @Route("/manage", name="manage_home")
		*/
		public function manage(){
			return $this->redirectToRoute("manage_user_add");
		}
		/**
		* @Route("/manage/user/add", name="manage_user_add")
		*/
		public function manageUserAdd(Request $req, UserPasswordEncoderInterface $encoder){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException('Accès limité aux administrateurs.');
		    }
			$user = new Admin();
			$form=$this->createForm(AdminType::class, $user);
			if($req->isMethod('POST')){
				$form->handleRequest($req);			
				$em = $this->getDoctrine()->getManager();
				$user->setPassword($encoder->encodePassword($user,$user->getPassword()));
				$user->setRoles($req->request->get('admin')['roles']);
				$em->persist($user);
				$em->flush();
				$this->addFlash('success', $user->getFirstname().' '.$user->getFamilyname());
				return $this->redirectToRoute('manage_user_add');
			}
			return $this->render('backend/manageBundle/manage_user_add.html.twig', array(
				'add_user_form'=>$form->createView()
			));
		}
		/**
		* @Route("/manage/categorys", name="manage_categorys")
		*/
		public function manageCategorys(){
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
		    	throw new AccessDeniedException('Accès limité aux administrateurs.');
		    }
			return $this->render('backend/manageBundle/categorys.html.twig');
		}
	}