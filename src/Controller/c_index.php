<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 20/02/2018
 * Time: 21:51
 */

namespace App\Controller;

use App\Entity\Questionnaire;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class c_index extends Controller
{
    /*
    * @Route("/")
    */
    public function affichQuestionnaires()
    {
        $quest = $this->getDoctrine()->getRepository(Questionnaire::class)->findAll();

        if(!$quest)
        {
          throw $this->createNotFoundException(
                'Pas de questionnaire trouvé.'
          );
        }


        return $this->render('quest.html.twig', array(
            'quest' => $quest,
        ));
    }

}