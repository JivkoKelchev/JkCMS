<?php

namespace CMSBundle\Controller;

use CMSBundle\Entity\General;
use CMSBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        
        if($this->getDoctrine()->getRepository(User::class)->findOneBy(['roles'=>'ROLE_ADMIN'])== null)
        {
            $admin = new User();
            $admin->setPassword($this->get('security.password_encoder')->encodePassword($admin,'admin'));
            $admin->setEmail('admin@CMS.com');
            $admin->setUsername('admin');
            $admin->setRoles('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
        }
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $gs = $this->get('doctrine')->getRepository('CMSBundle:General')->find(1);
        if ($gs == null){
            $gs= new General();
        }

        return $this->render('@CMS/Security/login.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'gs'            => $gs
            ));
    }

    /**
     * @Route("/logout", name="logout")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction()
    {
        return $this->redirectToRoute('login');
    }
}
