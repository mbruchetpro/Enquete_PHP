<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 20/02/2018
 * Time: 21:51
 * PHP : 7.0
 */

namespace App\Controller;

use App\Entity\Questionnaire;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;

/**
 *Class c_index
 *Controller gérant le template par défault.
 *
 *@package App\Controller
 */

class c_index extends Controller
{
    /*
     *  @Route("/")
     */
    public function affichQuestionnaires()
    {
        /**
         * Recherche des différents questionnaires présent dans la base de donnée.
         */
        $questionnaire = $this
            ->getDoctrine()
            ->getRepository(Questionnaire::class)
            ->findAll();

        /**
         *  Partie affichant les différents fichiers XML précédemment créés.
         */
        $finder = new Finder();
        $finder
            ->files()
            ->in(__DIR__ . './../../public/assets/doc_xml/')
            ->sortByChangedTime();

        $files = array();
        $id = 0;
        foreach ($finder as $file) {
            $files = $files +
                [
                $id =>
                    [
                      'name' => $file->getFilename(),
                      'path' => $file->getRealPath()
                    ]
                ];

            $id = $id+1;
        }
        /**
         * Fin partie
         */

        /**
         * Renvoie vers le template quest.html.twig
         * Et donne en paramètre :
         *                          quest : renvoi une liste des questionnaires
         *                          files : Renvoi une liste des fichiers.
         * afin de les afficher avec TWIG.
         */
        return $this->render(
            'quest.html.twig',
            [
                'quest' => $questionnaire,
                'files'   => $files
            ]
        );
    }

}