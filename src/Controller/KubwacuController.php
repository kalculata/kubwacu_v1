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
	
	class KubwacuController extends AbstractController{
		private $articleRep;
		private $categorysRep;

		public function __construct(ArticleRepository $rep, ArticleCategoryRepository $rep2){
			$this->articleRep = $rep;
			$this->categorysRep = $rep2;
		}
		/**
		* @Route("/sitemap", name="sitemap")
		*/
		public function sitemap(){
			$response = new Response($this->renderView('sitemap.xml.twig'));
			$response->headers->set('Content-Type', 'text/xml');
			return $response;
		}
		/**
		* @Route("/", name="kubwacu")
		*/
		public function kubwacu(){
			return $this->redirectToRoute('newsfeed');
		}
		/**
		* @Route("/home/{page}/{page_id}", name="newsfeed", defaults={"page"="page","page_id"="1"})
		*/
		public function index($page,$page_id){
			return $this->render('frontend/article/newsfeed.html.twig', array(
				'page'=>$page_id,
			));
		}
		/**
		* @Route("/getArticle/{id}", name="getArticle")
		*/
		public function getArticle(Request $req,$id){
			if($req->isMethod('get')){
				if($this->articleRep->find($id)!=null){
					$articleData = $this->articleRep->find($id);
					$data=[];
					$data['id']=$articleData->getId();
					$data['lang']=$articleData->getLang();
					$data['title']=$articleData->getTitle();
					$data['author_id']=$articleData->getAuthorId();
					$data['author']=$articleData->getAuthorName();
					$data['introduction']=$articleData->getIntroduction();
					$data['article']=nl2br($articleData->getArticle());
					$data['category_logo']=$articleData->getcategoryLogo();
					$data['category']=$articleData->getcategory();
					$data['sub_category']=$articleData->getsubCategory();
					$date_i = $articleData->getCreatedAt();
					$dateOfPost = new Blar_DateTime($date_i->format( 'Y-m-d H:i:s'));
					$data['postAt']= $dateOfPost->getMessage($dateOfPost,$date_i);
					$data['cover_name']=$articleData->getCover()->getName();
					$data['views']=$articleData->getArticleStat()->getViews();
					$data['cover_copyright']=$articleData->getCover()->getCopyright();
					$data['cover_description']=$articleData->getCover()->getDescription();

					//update of views
					$em = $this->get('doctrine')
							   ->getManager()
							   ->flush();

					return new JsonResponse($data);
				}
				return new Response('error');	
			}
			return new Response('error');
		}
		/**
		* @Route("/getCategorys", name="getCategorys")
		*/
		public function getCategorys(Request $req){
			if($req->isXmlHttpRequest()){
				$data = $this->categorysRep->findAll();
				$categorys=[];
				foreach ($data as $key => $category) {
					$categorys[$key]['name']=$category->getName();
					$categorys[$key]['sub_categorys']=$category->getSubCategory();
					$categorys[$key]['logotype']=$category->getLogotype();
				}
				return new JsonResponse($categorys);
			}
			throw new NotFoundHttpException();
		}
		/**
		* @Route("/articles/{title}", name="readArticle")
		*/
		public function readArticle(Request $req,$title){
			if($req->query->get('tag')!= null){
				$article_id = $req->query->get('tag');
				$article = $this->articleRep->find($article_id);
				if($article!==null){
					return $this->render('frontend/article/read.html.twig',array(
					"article_id"=>$article_id,
					"article_title"=>$article->getTitle(),
					"article_cover"=>$article->getCover()->getName()
					));
				}
				throw new NotFoundHttpException("L'article que vous recherche est introuvable");	
			}
			throw new NotFoundHttpException("L'article que vous recherche est introuvable");
		}
		/**
		* @Route("/category/{category}/{sub_category}/{page}/{page_id}", name="changeCategory",
		defaults={"sub_category"="all","page"="page","page_id"="1"})
		*/
		public function category(Request $req,$category,$sub_category, $page,$page_id){
			if($this->categorysRep->categoryVerify($category)){
				$data = $this->categorysRep->findOneBy(['name'=>$category]);
				if($this->categorysRep->subcategoryVerify($data->getId(),$sub_category) OR $sub_category=="all"){
					return $this->render('frontend/article/category.html.twig',array(
						"category_id"=>$data->getId(),
						"category"=>$data->getName(),
						"logotype"=>$data->getLogotype(),
						"sub_categorys"=>$data->getSubCategory(),
						"sub_category"=>$sub_category,
						"page"=>$page_id
					));
				}
				else{
					throw new NotFoundHttpException("La sous-catégorie ".$sub_category." n'existe pas");
				}
			}
			throw new NotFoundHttpException("La catégorie ".$category." n'existe pas");
		}
		/**
		* @Route("/getAllArticles", name="getAllArticles")
		*/
		public function getAllArticles(Request $request){
			if($request->isXmlHttpRequest()){
				$category = $request->query->get('ct');
				$sub_category = $request->query->get('sct');	
				$limit = $request->query->get('s');
				$offset = ($limit==1)?0:($limit-1)*10;
				$articles = $this->articleRep->getArticles($category,$sub_category,10,$offset);

				if($articles == null){
					return new JsonResponse(null);
				}
				$data=[];
				$stringNormalizer = new StringNormalizer();
				foreach ($articles as $key => $article) {
					$data[$key]['id']=$article->getId();
					$data[$key]['lang']=$article->getLang();
					$data[$key]['title']=$stringNormalizer->stringLimiter($article->getTitle(),100);
					$data[$key]['title_link']=$stringNormalizer->normalize($article->getTitle());
					$data[$key]['author_id']=$article->getAuthorId();
					$data[$key]['author']=$article->getAuthorName();
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
				$n_articles = $this->articleRep->countArticles($category,$sub_category);
				$elements = count($n_articles);
				$limit = 10;
				$pages = floor($elements/$limit);
				if($elements % $limit != 0 ){
					$pages++;
				}
				return new JsonResponse([$data,$pages]);
			}
			throw new NotFoundHttpException('La page que vous cherchez n\'existe pas');
		}
		/**
		* @Route("/count-articles", name="count-articles")
		*/
		public function countArticles(Request $req){
			if($req->isXmlHttpRequest()){
				$category = $req->query->get('ct');
				$sub_category = $req->query->get('sct');
				$articles = $this->articleRep->countArticles($category,$sub_category);
				$elements = count($articles);
				$limit = 10;
				$pages = floor($elements/$limit);
				if($elements % $limit != 0 ){
					$pages++;
				}
				return new JsonResponse($pages);
			}
			throw new NotFoundHttpException();
		}
		/**
		* @Route("/getMostRead", name="mostReadArticles")
		*/
		public function getMostReadArticles(Request $req){
			if($req->isXmlHttpRequest()){
				$limit = 10;
				$articles = $this->articleRep->getMostRead($limit);
				$data=[];
				$stringNormalizer = new StringNormalizer();
				foreach ($articles as $key => $article) {
					$data[$key]['id']=$article->getId();
					$data[$key]['lang']=$article->getLang();
					$data[$key]['title']=$stringNormalizer->stringLimiter($article->getTitle(),100);
					$data[$key]['title_link']=$stringNormalizer->normalize($article->getTitle());
					$data[$key]['category_logo']=$article->getcategoryLogo();
					$data[$key]['category']=$article->getcategory();
					$data[$key]['sub_category']=$article->getsubCategory();
					$data[$key]['created_at']=$article->getCreatedAt();
					$data[$key]['views']=$article->getArticleStat()->getViews();
					$data[$key]['cover_name']=$article->getCover()->getName();
					$data[$key]['cover_copyright']=$article->getCover()->getCopyright();
					$data[$key]['cover_description']=$article->getCover()->getDescription();
				}
				return new JsonResponse($data);
			}
			throw new NotFoundHttpException();
		}
	}