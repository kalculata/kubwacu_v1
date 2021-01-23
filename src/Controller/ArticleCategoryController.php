<?php 
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use App\Entity\ArticleCategory;
	use App\Form\ArticleCategoryType;
	use App\Form\ArticleSubCategoryType;
	use App\Repository\ArticleCategoryRepository;

	class ArticleCategoryController extends AbstractController{
		private $repository;

		public function __construct(ArticleCategoryRepository $repository){
			$this->repository = $repository;
		}
		/**
		* @Route("admin/manage/add-category", name="add_category")
		*/
		public function saveCategory(Request $request){
			$articleCategory= new ArticleCategory();
	    	$form = $this->createForm(ArticleCategoryType::class, $articleCategory);

		    if($request->isMethod('POST')){
		    	$form->handleRequest($request);
		  		$em = $this->getDoctrine()
		  				   ->getManager();
		  				   
				$category = $articleCategory->getName();
				$categoryExist = $this->repository->categoryVerify($category);
				if($categoryExist){
					$this->addFlash('error', 'Désolé, la catégorie "'.$category.'" existe déjà');
					return $this->redirectToRoute('manage_categorys');
				}
				$em->persist($articleCategory);
				$em->flush();
				$this->addFlash('success', 'La catégorie "'.$category.'" est créée');
				return $this->redirectToRoute('manage_categorys');		
		    }
		}
		
		/**
		* @Route("admin/manage/add-sub-category", name="add.sub_category")
		*/
		public function  saveSubcategory(Request $request){
			if($request->isMethod('post')){
				$categoryId = $request->request->get('article_sub_category')['name'];
				$sub_category = $request->request->get('article_sub_category')['sub_category'];

				$em = $this->getDoctrine()
						   ->getManager();

				$data = $this->repository->find($categoryId);
				$subcategoryExist = $this->repository->subcategoryVerify($categoryId,$sub_category);
				if($subcategoryExist){
					$this->addFlash('error','Désolé, la sous-catégorie "'.$sub_category.'" existe déjà dans la catégorie "'.$data->getName().'"');
					return $this->redirectToRoute('manage_categorys'); 
				}

				$sub_categorys=[];
				foreach ($data->getSubCategory() as $subcategory) {
					$sub_categorys[]=$subcategory;
				}

				array_push($sub_categorys, $sub_category);
				$data->setSubCategory($sub_categorys);
				$em->flush();
				//message de confirmation
				$this->addFlash('success','La sous-catégorie "'.$sub_category.'" est ajoutée à la catégorie "'.$data->getName().'"');
				return $this->redirectToRoute('manage_categorys'); 
			}
			return $this->redirectToRoute('manage_categorys');
		}
		/**
		* @Route("/admin/manage/del-subcategory/", name="admin.del-subcategory")
		*/
		public function delSubCategory(Request $request){
			if(null !== $request->query->get('subcategory') AND null !== $request->query->get('in') AND null !== $request->query->get('category')){
				$subcategory = $request->query->get('subcategory');
				$category = $request->query->get('category');
				$categoryId = $request->query->get('in');
		
				$categoryExist = $this->repository->categoryVerify($category);
				if($categoryExist){
					$subcategoryExist = $this->repository->subcategoryVerify($categoryId,$subcategory);
					if($subcategoryExist){
						$em = $this->getDoctrine()
								   ->getManager();	
						$data = $this->repository->find($categoryId);
						$sub_categorys = $data->getSubCategory();
						$a = $sub_categorys;

						//suppression de la sous-catégorie et reformulation du tableau
						unset($sub_categorys[array_search($subcategory, $sub_categorys)]);
						sort($sub_categorys);
						
						$data->setSubCategory($sub_categorys);
						$em->flush();
						//message
						$this->addFlash('error','La sous-catégorie "'.$subcategory.'" est supprimée dans la catégorie "'.$data->getName().'"');
						return $this->redirectToRoute('manage_categorys');
					}
					else{
						return $this->redirectToRoute('manage_categorys');
					}
				}
				
			}
		}
		public function viewAllCategory(){
			$categoryList = $this->repository->findAllCategory();
			return $this->render('backend/includes/manageBundle/_manage_view_categorys.html.twig', array(
				'data'=>$categoryList
			));
		}
		public function addCategory(){
			$articleCategory= new ArticleCategory();

			$form = $this->createForm(ArticleCategoryType::class, $articleCategory);
			
			return $this->render('backend/includes/manageBundle/_add_category_form.html.twig', array(
				'addCategoryForm'=>$form->createView()));
		}
		public function addSubCategory(){
			$articleSubCategory= new ArticleCategory();

			$form = $this->createForm(ArticleSubCategoryType::class, $articleSubCategory);

			return $this->render('backend/includes/manageBundle/_add_SubCategory_form.html.twig', array(
				'addSubCategoryForm'=>$form->createView()));
		}

	}