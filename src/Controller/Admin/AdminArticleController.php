<?php
	namespace App\Controller\Admin;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use App\Repository\ArticleRepository;
	use App\Repository\ArticleCategoryRepository;
	use App\Entity\Article;
	use App\Entity\ArticleCover;
	use App\Entity\ArticleStat;
	use App\Form\ArticleType;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\JsonResponse;

	class AdminArticleController extends AbstractController{
		private $repository;
		private $articlecategoryRepository;

		public function __construct(ArticleRepository $repository, ArticleCategoryRepository $articlecategoryRepository ){
			$this->repository = $repository;
			$this->articlecategoryRepository = $articlecategoryRepository;
		}
		public function writeForm(){
			$article = new Article();
			$form=  $this->createForm(ArticleType::class, $article);
			$data = $this->articlecategoryRepository->findAll();
			$articleCategory_data = [];
			foreach ($data as $data_i){
				array_push(
					$articleCategory_data,array(
						$data_i->getId()=>array(
							'id'=>$data_i->getId(),
							'name'=>$data_i->getName(),
							'subcategorys'=>$data_i->getSubCategory()
						)
					)
				);
			}
			return $this->render('backend/includes/articleBundle/_write_form.html.twig', array(
				'write_form'=>$form->createView(),
				'data'=>$articleCategory_data
			));
		}
		/**
		* @Route("/admin/save-article/", name="save_article")
		*/
		public function saveArticle(Request $request){
			if($request->isMethod('POST')){
				$data=$request->request;
				//getting the cover
				$image = $data->get('image');
				$name = $data->get('title');
				list($type, $image) = explode(';',$image);
				list(, $image) = explode(',',$image);
				$image = base64_decode($image);
				$image_name = sha1($name).'.png';
				$image_rep = 'data/cover/'.$image_name;
				file_put_contents($image_rep, $image);
				//creation du miniature
				$cover = imagecreatefrompng($image_rep); 
				$mini_cover = imagecreatetruecolor(120, 70);
				$width_cover = imagesx($cover);
				$height_cover = imagesy($cover);
				$width_miniCover = imagesx($mini_cover);
				$height_miniCover = imagesy($mini_cover);
				imagecopyresampled($mini_cover,$cover,0,0,0,0,$width_miniCover,$height_miniCover,$width_cover,$height_cover);
				imagepng($mini_cover, 'data/mini_cover/'.$image_name);

				//get the orginal name of category
				$categoryLogo = $this->articlecategoryRepository->getCategoryLogo($data->get('category'));
				$categoryName = $this->articlecategoryRepository->getCategoryName($data->get('category'));
				$article = new Article();
				$cover = new ArticleCover();
				$stat = new ArticleStat();
			
				//affectation des élements de base dans un article
				$article->setLang($data->get('lang'))
						->setCategoryLogo($categoryLogo['logotype'])
						->setCategory($categoryName['name'])
						->setSubCategory($data->get('sub_category'))
						->setTitle($data->get('title'))
						->setIntroduction($data->get('introduction'))
						->setArticle($data->get('article'))
						->setAuthorName($this->getUser()->getFirstname().' '.$this->getUser()->getFamilyname())
						->setAuthorId($this->getUser()->getId());

				$cover->setName($image_name)
					  ->setCopyright($data->get('copyright'))
					  ->setDescription($data->get('description_cover'));

				$stat->setViews(0);

				$article->setCover($cover);
				$article->setArticleStat($stat);
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();
				return new response('done');
			}
			return new Response('error');
		}
	}