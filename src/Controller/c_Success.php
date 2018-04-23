<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 06/02/2018
 * Time: 17:39
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class c_Success extends Controller
{
    /*
     * @Route("/success")
     */
    public function success()
    {
        $res = "Questionnaire - Action : Réussie";

        return $this->render('base.html.twig', array(
            'res' => $res,
        ));
    }
}