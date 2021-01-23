<?php 
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use App\Repository\ArticleRepository;
	use App\Service\Blar_DateTime;

	class SearchController extends AbstractController{
		private $articleRep;

		public function __construct(ArticleRepository $rep){
			$this->articleRep = $rep;
		}
		/**
		* @Route("/search/{page}", name="search_bundle", defaults={"page" = 1}))
		*/
		public function searchFonction(Request $req,$page){
			if($req->query->get('q') != null AND !empty($req->query->get('q'))){
				return $this->render('frontend/searchBundle/result.html.twig', [
					'query'=>$req->query->get('q'),
					'title'=>'Résultant de '.$req->query->get('q'),
					'page'=>$page
				]);
			}
			throw new NotFoundHttpException();
		}
		/**
		* @Route("/search_query", name="search_getter")
		*/
		public function search_query(Request $req){
			if($req->isXmlHttpRequest()){
				$query = htmlentities($req->query->get('q'));
				$page = $req->query->get('p');
				$limit = 10;
				$offset = ($page==1)?0:($page-1)*10;
				$results = $this->articleRep->searchResult($limit,$offset,$query);
				if($results == null){
					return new JsonResponse(null);
				}
				$data=[];
				foreach ($results as $key => $article) {
					$data[$key]['id']=$article->getId();
					$data[$key]['lang']=$article->getLang();
					$data[$key]['title']=$article->getTitle();
					$data[$key]['category_logo']=$article->getcategoryLogo();
					$data[$key]['category']=$article->getcategory();
					$data[$key]['sub_category']=$article->getsubCategory();
					$date_i = $article->getCreatedAt();
					$dateOfPost = new Blar_DateTime($date_i->format( 'Y-m-d H:i:s'));
					$data[$key]['postAt']= $dateOfPost->getMessage($dateOfPost,$date_i);
					$data[$key]['views']=$article->getArticleStat()->getViews();
					$data[$key]['cover_name']=$article->getCover()->getName();
					$data[$key]['cover_copyright']=$article->getCover()->getCopyright();
					$data[$key]['cover_description']=$article->getCover()->getDescription();

				}
				$elements = count($this->articleRep->countSearchResult($query));
				$limit = 10;
				$pages = floor($elements/$limit);
				if($elements % $limit != 0 ){
					$pages++;
				}
				return new JsonResponse([$data,$pages,$elements]);
			}
			throw new NotFoundHttpException();
		}
	}