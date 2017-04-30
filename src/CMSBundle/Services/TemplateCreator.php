<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 4.4.2017 г.
 * Time: 0:12
 */

namespace CMSBundle\Services;


use CMSBundle\Entity\Navbar;
use CMSBundle\Entity\PageCategories;
use CMSBundle\Entity\Pages;
use CMSBundle\Entity\Positions;
use CMSBundle\Entity\Rows;
use CMSBundle\Entity\Styles;
use CMSBundle\Entity\TextElement;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityManager;
use \Symfony\Component\HttpFoundation\File\UploadedFile;

class TemplateCreator
{

    public function getElementStyle(Positions $position)
    {
        $object = $position->getStyle();
        if ($object == null) {
            $string = '';
        } else {
            $string = 'style = "';
            if ($object->getBgColor() !== null) {
                $string .= 'background-color: ' . $object->getBgColor() . ';';
            }
            if ($object->getBgImage() !== null) {
                $string .= 'background-image: url("../Uploads/' . $object->getBgImage() . '");';
            }
            if ($object->getBorders()!= null) {
                foreach ($object->getBorders() as $border=>$value){
                    if ($value != null){
                        $string .= 'border-'.$border.'-width:'.$value.'px ;';
                        if ($object->getBorderColor() !==null) {
                            $string .= 'border-'.$border.'-style:solid;';
                            $string .= 'border-'.$border.'-color:'.$object->getBorderColor().';';
                        }
                    }
                }
            }
            if ($object->getMargin()!=null) {
                foreach ($object->getMargin() as $margin => $value){
                    if ($value != null){
                        $string .= 'margin-'.$margin.':'.$value.'%;';
                    }
                }
            }
            if ($object->getPadding()!=null) {
                foreach ($object->getPadding() as $padding => $value){
                    if ($value != null) {
                        $string .= 'padding-'.$padding.': '.$value.'%;';
                    }
                }
            }
            if ($object->getRoundBorder()!=null){
                $string .= 'border-radius: '.$object->getRoundBorder().'px;';
            }
            if ($object->getSize()!=null){
                foreach ($object->getSize() as $size => $value){
                    if ($size == 'minWidth'){$string .= 'min-width:'.$value.'%;';}
                    elseif ($size == 'maxWidth'){$string .= 'max-width:'.$value.'%;';}
                    elseif ($size == 'minHeight'){$string .= 'min-height:'.$value.'vh;';}
                    elseif ($size == 'maxHeight'){$string .= 'max-height:'.$value.'vh;';}
                }
                $string .= 'overflow:auto;';
            }
            $string .= '"';
        }

        return $string;
    }

    public function getHomeBtnNavbar(Navbar $navbar, $uploadDir)
    {

        $nameString = '';
        $logoString = '';
        if ($navbar->getLogo()!='' && $navbar->getBrand()!=''){

            $logoString = '../Uploads/'.$navbar->getLogo();
            $nameString = $navbar->getBrand();
        }
        elseif ($navbar->getLogo()!='' && $navbar->getBrand()== ''){
            $logoString = '../Uploads/'.$navbar->getLogo();
        }
        elseif($navbar->getBrand()!='' && $navbar->getLogo()==''){
            $nameString = $navbar->getBrand();
        }else{
            $nameString = 'Brand';
        }
        $homeBtn['name']=$nameString;
        $homeBtn['logo']=$logoString;
        return $homeBtn;
    }

    public function getCategoriesNavbar(Navbar $navbar, EntityManager $entityManager)
    {
        $string = '';
        $categories = $entityManager->getRepository(PageCategories::class)->findAll();
        if($navbar->getCategories()=='list'){
            $string = '<ul class="nav navbar-nav">
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Categories <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">';
            foreach ($categories as $index => $category){
                $string .= '<li><a href="/search/category/'.$category->getName().'">'.$category->getName().'</a></li>';
            }
            $string .= '</ul>
                        </li>
                        </ul>';

        }elseif ($navbar->getCategories()=='links'){
            foreach ($categories as $index => $category) {
                $string .= '<ul class="nav navbar-nav">
                        <li><a href="/search/category/'.$category->getName().'">'.$category->getName().'</a></li>
                    </ul>';
            }
        }

        return $string;



    }

    public function getSingleLinks(Navbar $navbar, EntityManager $entityManager)
    {
        $string = '';
        if ($navbar->getSingleLink() != null){
            foreach ($navbar->getSingleLink() as $link){

                $page = $entityManager->getRepository(Pages::class)->findOneBy(['slug'=>$link['name']]);
                if ($page == null){
                    $string.='<ul class="nav navbar-nav navbar">
                        <li><a href="#" class="btn btn-danger">'.$link['name'].' NOT FOUND</a></li>
                    </ul>';
                }else{
                $string.='<ul class="nav navbar-nav navbar">
                        <li><a href="/page/'.$page->getSlug().'">'.$page->getTitle().'</a></li>
                    </ul>';
                }
            }
            return $string;
        }
        return $string;
    }

    public function setNavbarLogo(Navbar $navbar, $uploadDir)
    {

        /**
         * @var \Symfony\Component\HttpFoundation\File\UploadedFile $image
         */
        $image = $navbar->getLogoFile();
        $fileName ='logo.' . $image->guessExtension();
        $image->move($uploadDir,$fileName);
        $navbar->setLogo($fileName);
        return true;
    }
}