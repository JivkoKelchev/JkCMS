<?php

namespace CMSBundle\Controller;

use CMSBundle\Entity\Comments;
use CMSBundle\Entity\CommentsElement;
use CMSBundle\Entity\ContactElement;
use CMSBundle\Entity\ContactMail;
use CMSBundle\Entity\ElementType;
use CMSBundle\Entity\General;
use CMSBundle\Entity\MapElement;
use CMSBundle\Entity\Navbar;
use CMSBundle\Entity\PageCategories;
use CMSBundle\Entity\PageImageElement;
use CMSBundle\Entity\PageLinkElement;
use CMSBundle\Entity\PageListElement;
use CMSBundle\Entity\Pages;
use CMSBundle\Entity\Positions;
use CMSBundle\Entity\TextElement;
use CMSBundle\Form\CommentType;
use CMSBundle\Form\ContactMailType;
use CMSBundle\Form\MapElementType;
use CMSBundle\Form\PageImageElementType;
use CMSBundle\Form\PageLinkType;
use CMSBundle\Form\PageListElementType;
use CMSBundle\Form\SearchByTags;
use CMSBundle\Form\SelectElementType;
use CMSBundle\Form\TextElementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RenderPartialsController extends Controller
{
    public function headerAction()
    {
        $navbar = $this->getDoctrine()->getRepository(Navbar::class)->find(1);

        if($navbar == null){
            $navbar = new Navbar();
        }
        $em = $this->getDoctrine()->getManager();
        $uploadDir = $this->getParameter('upload_directory');
        $homebtn = $this->get('template_creator_service')->getHomeBtnNavbar($navbar,$uploadDir);
//        var_dump()
        $categories = $this->get('template_creator_service')->getCategoriesNavbar($navbar,$em);
        $links = $this->get('template_creator_service')->getSingleLinks($navbar,$em);
        $search = $navbar->getSearchByTags();
        $loginout = $navbar->getLogInOut();
        $form = $this->createForm(SearchByTags::class);
        return $this->render('@CMS/Partials/navbar.html.twig',['homeBtn'=>$homebtn,
                                                        //'logo'=>$homebtn['logo'],
                                                        'categories'=>$categories,
                                                        'links'=>$links,
                                                        'search'=>$search,
                                                        'form'=>$form->createView(),
                                                        'loginout'=>$loginout]);
    }

    /**
     * @Route("/admin/text/edit/{positionId}/{pageSlug}",name="EditTextElement")
     */
    public function editTextElementAction($positionId,
                                          $pageSlug,
                                          Request $request)
    {
        $element = $this->getDoctrine()->getRepository(TextElement::class)->findOneBy(['positionId'=>$positionId]);
        $form = $this->get('form.factory')->createNamedBuilder('text_form_'.$positionId, TextElementType::class, $element, ['action'=>'/admin/text/edit/'.$positionId.'/'.$pageSlug])->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            return $this->redirect('/admin/pages/edit/'
                .$pageSlug
            );
        }
        return $this->render('@CMS/Partials/text_edit_form.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("view/text/{positionId}", name="ViewTextElement")
     */
    public function viewTextElementAction($positionId)
    {
        $element = $this->getDoctrine()->getRepository(TextElement::class)->findOneBy(['positionId'=>$positionId]);
        $content = $element->getContent();
        return new Response($content);
    }

    public function editCommentsElementAction($positionId,
                                             $pageSlug,
                                             Request $request)
    {
        $element = $this->getDoctrine()->getRepository(CommentsElement::class)->findOneBy(['positionId'=>$positionId]);

        return $this->render('@CMS/Partials/comment_edit_form.html.twig',['comment'=>$element]);
    }

    /**
     * @Route("/public/add/comment/{positionId}")
     *
     */
        public function viewCommentsElementAction(Request $request, $positionId)
        {
            $position = $this->getDoctrine()->getRepository(Positions::class)->find($positionId);
            $page = $position->getRow()->getPage();
            $comments = $page->getComments();
            $newComment = new Comments();
            $form = $this->createForm(CommentType::class, $newComment, ['action'=>'/public/add/comment/'.$positionId]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $newComment->setDatetime(new \DateTime('now'));
                $newComment->setPage($page);
                $newComment->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();
                return $this->redirectToRoute('view_page',['slug'=>$page->getSlug()]);
            }

            return $this->render('@CMS/Partials/comment_view_form.html.twig',['comments'=>$comments, 'form'=>$form->createView()]);
        }

    /**
     * @Route("/admin/pagelist/edit/{positionId}/{pageSlug}",name="EditPageListElement")
     */
    public function editPageListElementAction($positionId,
                                          $pageSlug,
                                          Request $request)
    {
        $element = $this->getDoctrine()->getRepository(PageListElement::class)->findOneBy(['positionId'=>$positionId]);
        $categories = $this->getDoctrine()->getRepository(PageCategories::class)->findCategoryNames();
        $form = $this->get('form.factory')
            ->createNamedBuilder('page_list_'.$positionId, PageListElementType::class, $element,
                                ['action'=>'/admin/pagelist/edit/'.$positionId.'/'.$pageSlug, 'categories'=>$categories])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if($element->getPageLimit()<1 && $element->getPageLimit()!==null){
                $this->addFlash('list_error','There must be minimum 1 page in list!');
                return $this->redirect('/admin/pages/edit/'.$pageSlug);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            return $this->redirect('/admin/pages/edit/'.$pageSlug);
        }
        return $this->render('@CMS/Partials/page_list_edit_form.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("view/pagelist/{positionId}", name="ViewPageListElement")
     */
    public function viewPageListElementAction($positionId)
    {
        $element = $this->getDoctrine()->getRepository(PageListElement::class)->findOneBy(['positionId'=>$positionId]);

            $limit = $element->getPageLimit();


        $category = $this->getDoctrine()->getRepository(PageCategories::class)->findOneBy(['name'=>$element->getCatFilter()]);
        if($category){
            $pages = $this->getDoctrine()->getRepository(Pages::class)->findBy(['pageCategory'=>$category],['date'=>'desc'],$limit);
        }else{
            $pages = $this->getDoctrine()->getRepository(Pages::class)->findBy([],['date'=>'desc'],$limit);
        }
        if($element->getType() == 'list'){
            return $this->render('@CMS/Partials/page_list_view.html.twig',['pages'=>$pages]);
        }
        return $this->render('@CMS/Partials/page_list_view_carousel.html.twig',['pages'=>$pages]);

    }

    /**
     * @Route("/admin/pageimage/edit/{positionId}/{pageSlug}",name="EditPageImageElement")
     */
    public function editPageImageElementAction($positionId,
                                              $pageSlug,
                                              Request $request)
    {
        $element = $this->getDoctrine()->getRepository(PageImageElement::class)->findOneBy(['positionId'=>$positionId]);
        $page = $this->getDoctrine()->getRepository(Pages::class)->findOneBy(['slug'=>$pageSlug]);
        $form = $this->get('form.factory')
            ->createNamedBuilder('page_list_'.$positionId, PageImageElementType::class, $element,
                ['action'=>'/admin/pageimage/edit/'.$positionId.'/'.$pageSlug])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($element);
            $em->flush();
            return $this->redirect('/admin/pages/edit/'
                .$pageSlug
            );
        }
        return $this->render('@CMS/Partials/page_image_edit_view.html.twig',['form'=>$form->createView(),'image'=>$page->getImage()]);
    }

    /**
     * @Route("view/pageimage/{positionId}", name="ViewPageImageElement")
     */
    public function viewPageImageElementAction($positionId)
    {
        $element = $this->getDoctrine()->getRepository(PageImageElement::class)->findOneBy(['positionId'=>$positionId]);
        $position = $this->getDoctrine()->getRepository(Positions::class)->find($positionId);
        $page = $position->getRow()->getPage();
        $imageName = $page->getImage();
        $imageStyle = 'style =';
        if ($element->getHeight()){
            $imageStyle.='height:'.$element->getHeight().'px;';
        }
        if ($element->getWidth()){
            $imageStyle.='width:'.$element->getWidth().'px;';
        }
        return $this->render('@CMS/Partials/page_image_view.html.twig',['image'=>$imageName, 'imageStyle'=>$imageStyle]);
    }

    /**
     * @Route("/admin/contact/edit/{positionId}/{pageSlug}",name="EditContactElement")
     */
    public function editContactElementAction()
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        return new Response('<br> Form to send mails to '.$gs->getContactMail());
    }

    /**
     * @Route("/public/send/mail/{positionId}")
     */
    public function viewContactElementAction(Request $request, $positionId)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $position = $this->getDoctrine()->getRepository(Positions::class)->find($positionId);
        $page = $position->getRow()->getPage();

        $newMail = new ContactMail();
        $newMail->setPositionId($positionId);
        $form = $this->createForm(ContactMailType::class, $newMail, ['action'=>'/public/send/mail/'.$positionId]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $plainMessage = 'FROM :'.$newMail->getFromUser().'<br>'.$newMail->getBody();
            $message = \Swift_Message::newInstance()
                ->setSubject($newMail->getSubject())
                ->setFrom($newMail->getFromUser())
                ->setTo($gs->getContactMail())
                ->setContentType("text/html")
                ->setBody($this->renderView('@CMS/mail_view.html.twig',['message'=>$plainMessage]));
            $this->get('mailer')->send($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newMail);
            $em->flush();
            return $this->redirectToRoute('view_page',['slug'=>$page->getSlug()]);
        }

        return $this->render('@CMS/Partials/contact_form_view.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/pagelink/edit/{positionId}/{pageSlug}",name="EditPageLinkElement")
     */
    public function editPageLinkElementAction($positionId,
                                              $pageSlug,
                                              Request $request)
    {
        $element = $this->getDoctrine()->getRepository(PageLinkElement::class)->findOneBy(['positionId'=>$positionId]);
        $pages = $this->getDoctrine()->getRepository(Pages::class)->findAll();
        $pagesArray = [];
        foreach ($pages as $page){
            $pagesArray[$page->getTitle()] = $page->getSlug();
        }
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $form = $this->get('form.factory')
            ->createNamedBuilder('page_link_'.$positionId, PageLinkType::class, $element,
                ['action'=>'/admin/pagelink/edit/'.$positionId.'/'.$pageSlug,'pages'=>$pagesArray])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            return $this->redirect('/admin/pages/edit/'
                .$pageSlug);
        }

        return $this->render('@CMS/Partials/page_link_edit.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("view/pagelink/{positionId}", name="ViewPageLinkElement")
     */
    public function viewPageLinkElementAction($positionId)
    {
        $element = $this->getDoctrine()->getRepository(PageLinkElement::class)->findOneBy(['positionId'=>$positionId]);
        $page = $this->getDoctrine()->getRepository(Pages::class)->findOneBy(['slug'=>$element->getSlug()]);

        return $this->render('@CMS/Partials/page_link_button_view.html.twig',['page'=>$page]);
    }

    /**
     * @Route("/admin/map/edit/{positionId}/{pageSlug}",name="EditMapElement")
     */
    public function editMapElementAction($positionId,
                                              $pageSlug,
                                              Request $request)
    {
        $element = $this->getDoctrine()->getRepository(MapElement::class)->findOneBy(['positionId'=>$positionId]);
        $form = $this->get('form.factory')
            ->createNamedBuilder('map'.$positionId, MapElementType::class, $element,
                ['action'=>'/admin/map/edit/'.$positionId.'/'.$pageSlug])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($element);
                $em->flush();
                return $this->redirect('/admin/pages/edit/'.$pageSlug);
        }

        return $this->render('@CMS/Partials/map_edit_form.html.twig', ['form'=>$form->createView()]);
    }
    /**
     * @Route("view/map/{positionId}", name="ViewMapElement")
     */
    public function viewMapElementAction($positionId)
    {
        $element = $this->getDoctrine()->getRepository(MapElement::class)->findOneBy(['positionId'=>$positionId]);

        return $this->render('@CMS/Partials/map_view.html.twig',['map'=>$element]);
    }













    /**
     * @Route("/edit/element/select/{positionId}")
     */
    public function selectElementAction(Request $request, $positionId)
    {
        $selectElement = new ElementType();
        $form = $this->get('form.factory')->createNamedBuilder('text_form_'.$positionId, SelectElementType::class, $selectElement, ['action'=>'/edit/element/select/'.$positionId])->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $elementType = $this->getDoctrine()->getRepository(ElementType::class)->findOneBy(['type'=>$selectElement->getType()]);
            $position = $this->getDoctrine()->getRepository(Positions::class)->find($positionId);
            $page = $position->getRow()->getPage();
            $position->setElementType($elementType);
            $elementClassName = '\CMSBundle\Entity\\'.$selectElement->getType();
            $element = new $elementClassName();
            $element->setPositionId($positionId);
            $em = $this->getDoctrine()->getManager();

            $em->persist($position);
            $em->persist($element);
            $em->flush();
            return $this->redirectToRoute('editPage',['slug'=>$page->getSlug()]);
        }

        return $this->render('@CMS/Partials/select_elemens_form.html.twig',['form'=>$form->createView()]);
    }

}
