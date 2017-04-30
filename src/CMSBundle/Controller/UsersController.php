<?php

namespace CMSBundle\Controller;

use CMSBundle\Entity\General;
use CMSBundle\Entity\User;
use CMSBundle\Form\UserProfileType;
use CMSBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @Method("GET")
     */
    public function registerAction()
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $form = $this->createForm(UserType::class);
        return $this->render('@CMS/Security/registration.html.twig', array('form' => $form->createView(),'gs'=>$gs));
    }

    /**
     * @Route("/register", name="register_process")
     * @Method("POST")
     */
    public function registerProcessAction(Request $request)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid()){
            $plainPassword = $user->getPassword();
            $hashedPassword = $this->get('security.password_encoder')->encodePassword($user,$plainPassword);
            $user->setPassword($hashedPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('@CMS/Security/registration.html.twig', array('form' => $form->createView(),'gs'=>$gs));
    }

    /**
     * @Route("/user/profile", name="user_profile")
     *
     * @Security("is_fully_authenticated()")
     */
    public function userProfileAction(Request $request)
    {
        $gs = $this->getDoctrine()->getRepository(General::class)->find(1);
        $user = $this->getUser();
        $userPassHeshed = $user->getPassword();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if ($user->getPassword()){
                $plainPassword = $user->getPassword();
                $hashedPassword = $this->get('security.password_encoder')->encodePassword($user,$plainPassword);
                $user->setPassword($hashedPassword);
            }else{
                $user->setPassword($userPassHeshed);
            }
            $uploadDir = $this->getParameter('upload_directory');
            $em = $this->getDoctrine()->getManager();
            $this->get('form_helper_service')->userProfileSetter($user,$em,$uploadDir);
            return $this->redirectToRoute('user_profile');
        }
        return $this->render('@CMS/User/user_profile.html.twig',['form'=>$form->createView(), 'gs'=>$gs]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/user/dlete/avatar", name="user_delete_avatar")
     * @Security("is_fully_authenticated()")
     */
    public function deleteUserAvatarAction()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $fileDir = $this->getParameter('upload_directory').'/'.$user->getAvatar();
        $file = new File($fileDir);
        $fs = new Filesystem();
        $fs->remove($file);
        $user->setAvatar(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('user_profile');
    }

}
