<?php

namespace CMSBundle\Controller;

use CMSBundle\Entity\General;
use CMSBundle\Entity\Navbar;
use CMSBundle\Entity\PageCategories;
use CMSBundle\Entity\Pages;
use CMSBundle\Entity\Positions;
use CMSBundle\Entity\Rows;
use CMSBundle\Entity\Styles;
use CMSBundle\Entity\Tags;
use CMSBundle\Entity\User;
use CMSBundle\Form\CategoriesType;
use CMSBundle\Form\EditUserRoles;
use CMSBundle\Form\EditUserRolesType;
use CMSBundle\Form\GeneralSettingsType;
use CMSBundle\Form\NavbarType;
use CMSBundle\Form\PagePropertiesType;
use CMSBundle\Form\PageType;
use CMSBundle\Form\StyleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package CMSBundle\Controller
 * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_EDITOR')")
 */
class EditorController extends Controller
{
    /**
     * @Route("/admin/pages", name="admin_pages")
     */
    public function adminPagesAction()
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $pages = $this->getDoctrine()->getRepository(Pages::class)->findAll();
        return $this->render('@CMS/Admin/adminPages.html.twig',['pages'=>$pages, 'gs'=>$gs]);
    }

    /**
     * @Route("/admin/pages/new", name="new_page")
     */
    public function adminCreateNewPageAction(Request $request)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $categories = $this->getDoctrine()->getRepository(PageCategories::class)->findAll();
        $categoryNames=null;
        if ($categories!=null){
            foreach ($categories as $categoty){
                $categoryNames[$categoty->getName()]=$categoty->getId();
            }
        }
        $page = new Pages();
        $form = $this->createForm(PageType::class,$page,['categories'=>$categoryNames]);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $uploadDir = $this->getParameter('upload_directory');
            $slug = $this->get('slug_survice')->makeSlugs($page->getTitle());
            $page->setSlug($slug);
            $this->get('form_helper_service')->pageCreateNewSetter($page,$em,$uploadDir);
            return $this->redirectToRoute('admin_pages');
        }
        return $this->render('@CMS/Admin/adminNewPage.html.twig', ['form'=>$form->createView(), 'gs'=>$gs]);
    }

    /**
     * @Route("/admin/page/properties/{slug}", name="page_properties")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function adminPagePropertiesAction(Request $request, $slug)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $categories = $this->getDoctrine()->getRepository(PageCategories::class)->findAll();
        if ($categories!=null){
            foreach ($categories as $categoty){
                $categoryNames[$categoty->getName()]=$categoty->getId();
            }
        }else{$categoryNames=null;}
        $page = $this->getDoctrine()->getRepository(Pages::class)->findOneBy(['slug'=>$slug]);
        if($page->getPageCategory()){
            $page->setPageCategory($page->getPageCategory()->getId());
        }
        $allTags = $this->getDoctrine()->getRepository(Tags::class)->findAll();
        $form = $this->createForm(PagePropertiesType::class,$page,['categories'=>$categoryNames]);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $uploadDir = $this->getParameter('upload_directory');
            $this->get('form_helper_service')->pagePropertiesSetter($page,$em,$uploadDir);
            return $this->redirectToRoute('page_properties',['slug'=>$page->getSlug()]);
        }
        return $this->render('@CMS/Admin/adminPageProperties.html.twig', ['form'=>$form->createView(), 'gs'=>$gs, 'page'=>$page, 'allTags'=>$allTags]);
    }

    /**
     * @Route("/admin/page/delete/image/{slug}", name="delete_page_img")
     * @param $slug
     */
    public function deletePageImage($slug){
        $page=$this->getDoctrine()->getRepository(Pages::class)->findOneBy(['slug'=>$slug]);
        $uploarDir = $this->getParameter('upload_directory');
        $file = new File($uploarDir.'/'.$page->getImage());
        $fs = new Filesystem();
        $fs->remove($file);
        $page->setImage(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();
        return $this->redirectToRoute('page_properties',['slug'=>$page->getSlug()]);
    }

    /**
     * @param $slug
     * @Route("/admin/pages/edit/{slug}", name="editPage" )
     * @return Response
     */
    public function adminEditPageAction($slug)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $page = $this->getDoctrine()->getRepository(Pages::class)->findOneBy(['slug'=>$slug]);

        return $this->render('@CMS/Admin/adminEditPage.html.twig', ['page'=>$page, 'gs'=>$gs]);
    }

    /**
     * @Route("/admin/pages/delete/{slug}", name="deletePage")
     */
    public function adminDeletePageAction($slug)
    {
        $page = $this->getDoctrine()->getRepository(Pages::class)->findOneBy(['slug'=>$slug]);
        $tags = $page->getTags();
        $em = $this->getDoctrine()->getManager();
        foreach ($tags as $tag){
            $em->remove($tag);
            $em->flush();
        }
        $em->remove($page);
        $em->flush();
        return $this->redirectToRoute('admin_pages');
    }

    /**
     * @Route("/admin/delete/position/{positionId}", name="delete_position")
     */
    public function adminDeletePositionAction($positionId)
    {
        $em = $this->getDoctrine()->getManager();
        $position = $this->getDoctrine()->getRepository(Positions::class)->find($positionId);
        if ($position->getElementType() != null){
            $element = $em->getRepository('\CMSBundle\Entity\\'.$position->getElementType()->getType())->findOneBy(['positionId'=>$positionId]);
            if($element!= null){$em->remove($element);}
        }
        $style = $position->getStyle();
        if($style!= null){$em->remove($style);}
        $row = $position->getRow();
        $page = $row->getPage();
        $positionCounts = count($row->getPositions());
        if ($positionCounts-1 != 0){
            $newPositionsSize = 'col-sm-'.(12/($positionCounts-1));
            $em->remove($position);
            $em->flush();
            $newPositions = $row->getPositions();
            foreach ($newPositions as $newPosition) {
                $newPosition->setSize($newPositionsSize);
                $em->persist($newPosition);
                $em->flush();}
        }
        else {
            $em->remove($position);
            $em->remove($row);
            $em->flush();
        }
        return $this->redirectToRoute('editPage',['slug'=>$page->getSlug()]);
    }

    /**
     * @Route("/admin/add/position/{rowId}/{pageSlug}", name="add_position")
     */
    public function newColumnAction($rowId,$pageSlug)
    {
        $row = $this->getDoctrine()->getRepository(Rows::class)->find($rowId);
        $newPosition = new Positions();

        $positionCounts = count($row->getPositions());
        $newPositionsSize = 'col-sm-'.(12/($positionCounts+1));
        $newPosition->setSize($newPositionsSize);
        $newPosition->setRowId($rowId);
        $newPosition->setRow($row);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newPosition);
        $em->flush();
        $allPositionsInRow = $row->getPositions();
        foreach ($allPositionsInRow as $position){
            $position->setSize($newPositionsSize);
            $em->persist($position);
            $em->flush();
        }
        return $this->redirectToRoute('editPage',['slug'=>$pageSlug]);
    }

    /**
     * @Route("/admin/addRow/{pageId}",name="add_new_row")
     */
    public function newRowAction($pageId)
    {
        $page = $this->getDoctrine()->getRepository(Pages::class)->find($pageId);
        $newRow = new Rows();
        $newRow->setPage($page);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newRow);
        $em->flush();
        $newPosition = new Positions();
        $newPosition->setRow($newRow);
        $newPosition->setSize('col-sm-12');
        $em->persist($newPosition);
        $em->flush();
        return $this->redirectToRoute("editPage",['slug'=>$page->getSlug()]);
    }

    /**
     * @Route("/admin/style/{positionId}", name="position_styles")
     */
    public function stylesAction(Request $request, $positionId)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $position = $this->getDoctrine()->getRepository(Positions::class)->find($positionId);
        $page = $position->getRow()->getPage();
        $style = $this->getDoctrine()->getRepository(Styles::class)->findOnePopulateBy(['position'=>$position]);
        if ($style == null){
            $style = new Styles();
            $style->setPosition($position);
        }
        $form = $this->createForm(StyleType::class,$style);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $style->setBorders(['top'=>$style->getTopBorder(), 'bottom'=>$style->getBottomBorder(),'left'=>$style->getLeftBorder(), 'right'=>$style->getRightBorder()]);
            $style->setMargin(['top'=>$style->getTopMargin(), 'bottom'=>$style->getBottomMargin(),'left'=>$style->getLeftMargin(), 'right'=>$style->getRightMargin()]);
            $style->setPadding(['top'=>$style->getTopPadding(), 'bottom'=>$style->getBottomPadding(),'left'=>$style->getLeftPadding(), 'right'=>$style->getRightPadding()]);
            $style->setSize(['minWidth'=>$style->getMinWidth(), 'maxWidth'=>$style->getMaxWidth(), 'minHeight'=>$style->getMinHeight(), 'maxHeight'=>$style->getMaxHeight()]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($style);
            $em->flush();
            return $this->redirectToRoute('editPage',['slug'=>$page->getSlug()]);
        }
        return $this->render('@CMS/Admin/adminPositionStyles.html.twig',['gs'=>$gs, 'form'=>$form->createView()]);
    }
}
