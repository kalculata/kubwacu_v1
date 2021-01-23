<?php
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use App\Repository\ArticleRepository;
	use App\Repository\ArticleCategoryRepository;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use App\Service\Blar_DateTime;
	use App\Service\StringNormalizer;
	
	class IndexController extends AbstractController{
		/**
		* @Route("/aboutUs", name="about-us")
		*/
		public function indexAboutUs(){
			return $this->render('aboutUs.html.twig');
		}
		/**
		* @Route("/team", name="team")
		*/
		public function indexTeam(){
			return $this->render('team.html.twig');
		}
		/**
		* @Route("/team/{pseudo}", name="teamMember")
		*/
		public function indexTeamMember($pseudo){
			return $this->render('team_member.html.twig', [
				'title'=>$pseudo
			]);
		} 
	}