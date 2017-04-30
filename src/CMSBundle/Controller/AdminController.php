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
 * @Security("has_role('ROLE_ADMIN')")
 */
class AdminController extends Controller
{

    /**
     * @Route("/admin", name="general_settings")
     */
    public function adminGeneralAction(Request $request)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        if ($gs == null){
            $gs= new General();
        }
        if ($gs->getBgImageFile()!=null){
            $gs->setBgImageFile(new File($this->getParameter('upload_directory').'/'.$gs->getBgImage()));
        }
        $gsForm = $this->createForm(GeneralSettingsType::class,$gs);
        $gsForm->handleRequest($request);
        if ($gsForm->isSubmitted() && $gsForm->isValid()){
            if ($gs->getBgImageFile()!=null){
                $image = $gs->getBgImageFile();
                $fileName ='bg.' . $image->guessExtension();
                $image->move($this->getParameter('upload_directory'),$fileName);
                $gs->setBgImage($fileName);
            }
            $this->get('css_writer_service')->writeGeneralCss($gs);
            $em = $this->getDoctrine()->getManager();
            $em->persist($gs);
            $em->flush();
            if ($gs->getBgImage()!=null){
                $gs->setBgImage(new File($this->getParameter('upload_directory').'/'.$gs->getBgImage()));
            }
            $gsForm = $this->createForm(GeneralSettingsType::class,$gs);
            return $this->render('@CMS/Admin/adminGeneral.html.twig',[  'gsForm'=>$gsForm->createView(),'gs'=>$gs ]);
        }
        return $this->render('CMSBundle:Admin:adminGeneral.html.twig',['gsForm'=>$gsForm->createView(),'gs'=>$gs]);
    }

    /**
     * @Route("/admin/general/delete/bgimage", name="delete_bg_image")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminDeleteBgImage()
    {
        $em = $this->getDoctrine()->getManager();
        $gs = $em->getRepository(General::class)->find(1);
        $imageFile = new File($this->getParameter('upload_directory').'\\'.$gs->getBgImage());
        $gs->setBgImage(null);
        $fs = new Filesystem();
        $fs->remove($imageFile);
        $em->persist($gs);
        $em->flush();
        return $this->redirectToRoute('general_settings');
    }

    /**
     * @Route("/google/color-picker", name="colors")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function colorPickerAction()
    {
        return $this->render('@CMS/ColorPicker/color.html.twig');
    }

    /**
     * @Route("/admin/navbar", name="edit_navbar")
     * @Method("GET")
     */
    public function editNavBarAction()
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $navbar = $this->getDoctrine()->getRepository(Navbar::class)->find(1);
        if($navbar == null){
            $navbar = new Navbar();
        }
        $singleLinks = $navbar->getSingleLink();
        $pagesFormArray = [];
        $pages = $this->getDoctrine()->getRepository(Pages::class)->findAll();
        foreach ($pages as $page){
            $pagesFormArray[$page->getTitle()]=$page->getSlug();
        }
        $form = $this->createForm(NavbarType::class, $navbar, ['pages'=>$pagesFormArray]);
        return $this->render('@CMS/Admin/adminEditNavbar.html.twig', ['form'=>$form->createView(), 'gs'=>$gs, 'sl'=>$singleLinks, 'navbar'=>$navbar]);

    }

    /**
     * @Route("/admin/navbar", name="edit_navbar_process")
     * @Method("POST")
     */
    public function editNavBarProcessAction(Request $request)
    {
        $navbar = $this->getDoctrine()->getRepository(Navbar::class)->find(1);
        if($navbar == null){
            $navbar = new Navbar();
        }
        $pagesFormArray = [];
        $pages = $this->getDoctrine()->getRepository(Pages::class)->findAll();
        foreach ($pages as $page){
            $pagesFormArray[$page->getTitle()]=$page->getSlug();
        }
        $form = $this->createForm(NavbarType::class, $navbar, ['pages'=>$pagesFormArray]);
        $form->handleRequest($request);
        if ($form->isValid()){
            if($navbar->getLogoFile()){
                $uploadDir = $this->getParameter('upload_directory');
                $this->get('template_creator_service')->setNavbarLogo($navbar,$uploadDir);
            }
            if ($navbar->getSl()!=null){
                $singleLinks=$navbar->getSingleLink();
                $singleLinks[]=['name'=>$navbar->getSl()];
                $navbar->setSingleLink($singleLinks);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($navbar);
            $em->flush();
            return $this->redirectToRoute('edit_navbar');
        }
        return $this->redirectToRoute('edit_navbar');
    }

    /**
     * @Route("/admin/navbar/delete/{link}", name="navbar_delete_link")
     */
    public function deleteSingleLinkNavbarAction($link)
    {
        $navbar = $this->getDoctrine()->getRepository(Navbar::class)->find(1);
        $singleLinks = $navbar->getSingleLink();
        unset($singleLinks[$link]);
        $navbar->setSingleLink($singleLinks);
        $em = $this->getDoctrine()->getManager();
        $em->persist($navbar);
        $em->flush();
        return $this->redirectToRoute('edit_navbar');
    }

    /**
     * @Route("/admin/navbar/dlete/logo", name="navbar_delete_logo")
     */
    public function removeNavbarLogo()
    {
        /**
         * @var Navbar $navbar
         */
        $navbar = $this->getDoctrine()->getRepository(Navbar::class)->find(1);
        $navbar->setLogo(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($navbar);
        $em->flush();
        return $this->redirectToRoute('edit_navbar');
    }

    /**
     * @Route("/admin/categories/add", name="add_categories")
     * @Method("GET")
     */
    public function addCategoriesAction()
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $categories = $this->getDoctrine()->getRepository(PageCategories::class)->findAll();
        $category = new PageCategories();
        $form = $this->createForm(CategoriesType::class,$category);
        return $this->render('@CMS/Admin/adminAddCategories.html.twig',['gs'=>$gs, 'categories'=>$categories,'form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/categories/add", name="add_categories_process")
     * @Method("POST")
     */
    public function addCategoriesProcessAction(Request $request)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $categories = $this->getDoctrine()->getRepository(PageCategories::class)->findAll();
        $category = new PageCategories();
        $form = $this->createForm(CategoriesType::class,$category);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            //return $this->render('@CMS/Admin/adminAddCategories.html.twig',['gs'=>$gs, 'categories'=>$categories,'form'=>$form->createView()]);
            return $this->redirectToRoute('add_categories');
        }
        return $this->render('@CMS/Admin/adminAddCategories.html.twig',['gs'=>$gs, 'categories'=>$categories,'form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/category/delete/{categoryId}", name="delete_category")
     */
    public function deleteCategoryAction( $categoryId)
    {
        $category = $this->getDoctrine()->getRepository(PageCategories::class)->find($categoryId);
        $pages = $category->getPages();
        $em = $this->getDoctrine()->getManager();
        foreach ($pages as $page){
            $page->setPageCategory(null);
            $em->persist($page);
            $em->flush();
        }
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('add_categories');
    }

    /**
     * @Route("/admin/tag/remove/{pageId}/{tagId}", name="remove_tag")
     */
    public function removeTagsAction($pageId,$tagId)
    {
        /**
         * @var Pages $page
         */
        $page = $this->getDoctrine()->getRepository(Pages::class)->find($pageId);
        $tag = $this->getDoctrine()->getRepository(Tags::class)->find($tagId);
        $page->removeTag($tag);
        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();
        return $this->redirectToRoute('page_properties',['slug'=>$page->getSlug()]);
    }

    /**
     * @Route("/admin/tag/add/{pageId}/{tagId}", name="add_tag")
     */
    public function addTagAction($pageId,$tagId)
    {
        $page = $this->getDoctrine()->getRepository(Pages::class)->find($pageId);
        $tag = $this->getDoctrine()->getRepository(Tags::class)->find($tagId);
        $page->addTag($tag);
        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();
        return $this->redirectToRoute('page_properties',['slug'=>$page->getSlug()]);

    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function adminUsersAction()
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('@CMS/Admin/adminUsers.html.twig', ['users'=>$users, 'gs'=>$gs]);
    }

    /**
     * @Route("/admin/user/edit/{userId}", name="admin_user-edit")
     */
    public function adminEditUserAction($userId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gs = $em->getRepository(General::class)->find(1);
        $user = $em->getRepository(User::class)->find($userId);
        $user->setRole($user->getRoles()[0]);
        $form = $this->createForm(EditUserRolesType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setRoles($user->getRole());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('@CMS/Admin/adminUserRoles.html.twig',['gs'=>$gs,'form'=>$form->createView(), 'user'=>$user]);
    }

    /**
     * @return Response
     * @Route("/map")
     */
    public function map()
    {
        return $this->render('@CMS/Partials/map_view.html.twig');
    }

}
