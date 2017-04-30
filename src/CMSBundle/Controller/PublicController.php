<?php

namespace CMSBundle\Controller;

use CMSBundle\Entity\General;
use CMSBundle\Entity\PageCategories;
use CMSBundle\Entity\Pages;
use CMSBundle\Entity\Tags;
use CMSBundle\Form\SearchByTags;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

class PublicController extends Controller
{
    /**
     * @Route("/page/{slug}", name="view_page")
     *
     */
    public function viewPage($slug)
    {
        /**
         * @var General $gs
         */
        $gs = $this->get('doctrine')->getRepository('CMSBundle:General')->find(1);
        $navbar = $this->getDoctrine()->getRepository('CMSBundle:Navbar')->find(1);
        $logo = $navbar->getLogo();
        $page = $this->getDoctrine()->getRepository('CMSBundle:Pages')->findOneBy(['slug'=>$slug]);
        if ($gs == null){
            $gs= new General();
        }

        if($gs->getGuestMode() == false && $this->getUser()==null){
           return $this->redirectToRoute('login');

        }else{
            return $this->render('@CMS/Default/viewPage.html.twig', ['page'=>$page, 'gs'=>$gs , 'logo'=>$logo]);
        }
    }

    /**
     * @Route("/",name="home")
     */
    public function indexAction()
    {
        $navbar = $this->getDoctrine()->getRepository('CMSBundle:Navbar')->find(1);
        $logo = $navbar->getLogo();
        $gs = $this->get('doctrine')->getRepository('CMSBundle:General')->find(1);
        $page = $this->getDoctrine()->getRepository('CMSBundle:Pages')->find(1);
        if ($gs == null){
            $gs= new General();
        }
        if($gs->getGuestMode() == false && $this->getUser()==null){
            return $this->redirectToRoute('login');
        }else {
            return $this->render('CMSBundle:Default:index.html.twig', ['page' => $page, 'gs' => $gs, 'logo'=>$logo]);
        }
    }

    /**
     * @Route("/search/category/{category}", name="search_categories")
     * 
     * @param string $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchResult(string $category)
    {
        $navbar = $this->getDoctrine()->getRepository('CMSBundle:Navbar')->find(1);
        $logo = $navbar->getLogo();
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $category=$this->getDoctrine()->getRepository(PageCategories::class)->findOneBy(['name'=>$category]);
        $pages = $category->getPages();
        return $this->render('@CMS/Default/search_result.html.twig',['gs'=>$gs,'pages'=>$pages, 'logo'=>$logo]);
    }

    /**
     * @Route("/search/tags")
     */
    public function searchByTags(\Symfony\Component\HttpFoundation\Request $request)
    {
        $navbar = $this->getDoctrine()->getRepository('CMSBundle:Navbar')->find(1);
        $logo = $navbar->getLogo();
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository(Tags::class);
        $form = $this->createForm(SearchByTags::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data= $form->getData();
            $dataArray = explode(' ',$data['tagString']);
            $pagesArray = new ArrayCollection();
            foreach ($dataArray as $string){
                $tags =$tagRepo->createQueryBuilder('t')
                                ->where('t.name LIKE :string' )
                                ->setParameter('string', '%'.$string.'%')
                                ->getQuery()->getResult();
                foreach ($tags as $tag){
                    $pages = $tag->getPage();
                    foreach ($pages as $page){
                        if(!$pagesArray->contains($page)){
                            $pagesArray->add($page);
                        }
                    }
                }
            }
            return $this->render('@CMS/Default/search_result.html.twig',['gs'=>$gs,'pages'=>$pagesArray, 'logo'=>$logo]);
        }
    }



}

