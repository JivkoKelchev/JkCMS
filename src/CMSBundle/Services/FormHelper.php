<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 24.4.2017 г.
 * Time: 20:59
 */

namespace CMSBundle\Services;


use CMSBundle\Entity\PageCategories;
use CMSBundle\Entity\Pages;
use CMSBundle\Entity\Tags;
use CMSBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class FormHelper
{
    public function pagePropertiesSetter(Pages $page,EntityManager $em, $uploadDir)
    {
        if ($page->getNewTagName()){
            if(!$em->getRepository(Tags::class)->findOneBy(['name'=>$page->getNewTagName()])){
                $newTag = new Tags();
                $newTag->setName($page->getNewTagName());
            }else{
                $newTag = $em->getRepository(Tags::class)->findOneBy(['name'=>$page->getNewTagName()]);
            }

            $em->persist($newTag);
            $page->addTag($newTag);
            }

        if($page->getPageCategory()){
            $page->setPageCategory($em->getRepository(PageCategories::class)->find($page->getPageCategory()));
        }
        if ($page->getImageFile()){
            $image = $page->getImageFile();
            $fileName = $page->getSlug() .'.'. $image->guessExtension();
            $image->move($uploadDir,$fileName);
            $page->setImage($fileName);
        }

        $em->persist($page);
        $em->flush();
    }

    public function pageCreateNewSetter(Pages $page, EntityManager $em, $uploadDir)
    {
        if ($page->getImageFile()){
            $image = $page->getImageFile();
            $fileName = $page->getSlug() .'.'. $image->guessExtension();
            $image->move($uploadDir,$fileName);
            $page->setImage($fileName);
        }
        if($page->getPageCategory()){
            $PageCategory = $em->getRepository(PageCategories::class)->find($page->getPageCategory());
            $page->setPageCategory($PageCategory);
        }
        $em->persist($page);
        $em->flush();
        return true;
    }

    public function userProfileSetter(User $user, EntityManager $em, $uploadDir)
    {
        if ($user->getavatarFile()){
            $image = $user->getAvatarFile();
            $fileName = $user->getUsername() .'.'. $image->guessExtension();
            $image->move($uploadDir,$fileName);
            $user->setAvatar($fileName);
        }
        $em->persist($user);
        $em->flush();
        return true;
    }
}