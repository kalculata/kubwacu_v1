<?php 
	namespace App\Controller\Admin;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

	class AdminSecurityController extends AbstractController{
		/**
		* @Route("/admin", name="admin_login_redirect")
		*/
		public function admin(){
			return $this->redirectToRoute('admin_login');
		}
		/**
		* @Route("/main/login", name="admin_login")
		*/
		public function adminLogin(AuthenticationUtils $authenticationUtils){
			$securityContext = $this->container->get('security.authorization_checker');
			if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
				return $this->redirectToRoute('administration_home');
			}
			$error=$authenticationUtils->getLastAuthenticationError();
			$lastname= $authenticationUtils->getLastUserName();
			return $this->render('backend/global/login.html.twig',array(
				'lastname'=>$lastname,
				'error'=>$error
			));
		}
	}