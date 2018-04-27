<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 30/01/2018
 * Time: 16:38
 */
namespace App\Controller;

use App\Entity\Questionnaire;
use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class c_questionnaire
 * Controller gérant la création
 * et l'ajout dans la base de donnée de Questionnaire et de Question.
 * @package App\Controller
 */
class c_questionnaire extends Controller
{
    /*
     * @Route("/creer_Questionnaire")
     */
    public function new(Request $request)
    {
        /**
         * Initialisation de l'objet $quest de la class Questionnaire
         */
        $quest = new Questionnaire();

        /**
         * Construction du formulaire de création de questionnaire
         */

        $form = $this->createFormBuilder(
            $quest,
            array(
            'method' => 'POST',
            )
        )
            ->add(
                'name',
                TextType::class,
                array(
                        'label' => 'Nom : ',
                        'attr' => array(
                            'placeholder' => 'Nom du questionnaire')
                        )
            )
            ->add(
                'displayName',
                TextType::class,
                array(
                    'label' => 'Libellé : ',
                    'attr' => array
                    (
                        'placeholder' => 'Libellé de votre questionnaire')
                    )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'label' => 'Description : ',
                    'attr' => array(
                                'placeholder' => 'Description'
                    ),
                    'required' => false
                )
            )
            ->add(
                'envoyer',
                SubmitType::class,
                array(
                    'label' => 'Valider',
                    'attr'  => ["class" => 'btn btn-primary btn-lg btn-block']
                )
            )
            ->getForm();

        /**
         * Récupération des différent gestionnaire d'entity / base de donnée.
         */
        $em = $this->getDoctrine()->getEntityManager();

        /**
         * Récupère les données du formulaire.
         */
        $form->handleRequest($request);

        /**
         * Initialisation d'un objet $questionnaire
         */
        $questionnaire = new Questionnaire();

        /**
         * Vérifie si le formulaire a été soumi et valide.
         * Et ensuite ajoute à la base de donnée le questionnaire.
         */
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * Attribut les données du formulaire.
             */
            $questionnaire = $form->getData();
            $em->persist($questionnaire);
            $em->flush();

            return $this->redirectToRoute('default');
        } else {
            /**
             * Renvoie vers le template new.html.twig
             * Et donne en paramètre le formulaire afin de l'afficher avec TWIG.
             */
            return $this->render(
                'new.html.twig',
                array(
                    'form' => $form->createView(),
                )
            );
        }

    }

    /*
     * @Route("/admin/questionnaire/edit/{parentId}")
     */
    public function questionnaireEdit(Request $request)
    {
        /***
         *   Récupère le paramètre
         *   passer par la route ==> parentId == id du questionnaire.
         *   Request + ou - identique a $_SESSION[''].
         */
        $id = $request->attributes->get('parentId');

        /**
         * Requête qui cherche toute les questions.
         */
        $questions = $this
            ->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();

        /**
         * Requête qui cherche le questionnaire posséfant l'id == $id
         */
        $questionnaire = $this
            ->getDoctrine()
            ->getRepository(Questionnaire::class)
            ->find($id);

        /**
         * Création du formulaire de création des questions.
         */

        $questionForm = $this
            ->createFormBuilder(
                $questions,
                [
                    'method' => 'POST',
                ]
            )
            ->add(
                'typeQ',
                ChoiceType::class,
                [
                    'choices' => [
                        'Liste déroulantes' => "list",
                        'Liste à choix multiple' => "combo",
                        'Zone de texte' => "text"
                    ],
                    'label' => 'Type de composant',
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'label' => 'Nom ',
                    'attr'  => [
                        'placeholder' => 'Renseigner votre question'
                    ]
                ]
            )
            ->add(
                'texte',
                TextType::class,
                [
                    'label' => 'Libellé à afficher ',
                    'attr'  => [
                        'placeholder' => 'Renseigner le libellé question'
                    ]
                ]
            )
            ->add(
                'reponse',
                TextareaType::class,
                [
                    'label' => 'Réponse(s)(1 par ligne et 5 réponses possible) ',
                    'attr'  => ["rows" => '5']
                ]
            )
            ->add(
                'defaut',
                ChoiceType::class,
                [
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                    ],
                    'label' => 'Réponse par défault ?',
                ]
            )
            ->add(
                'envoyer',
                SubmitType::class,
                [
                    'label' => 'Valider',
                    'attr'  => ["class" => 'btn btn-primary btn-lg btn-block']
                ]
            )
            ->getForm();

        /**
         * Récupération des différent gestionnaire d'entity / base de donnée.
         */
        $em = $this->getDoctrine()->getEntityManager();

        /**
         * Récupère les donnée du formulaire.
         */
        $questionForm->handleRequest($request);

        /**
         * Question $question ==> Initialisation
         */
        $question = new Question();

        /**
         * Vérifie si le formulaire a été soumi et valide.
         * Et ensuite ajoute à la base de donnée la question
         * lié au questionnaire courant.
         */
        if ($questionForm->isSubmitted() && $questionForm->isValid()) {
            /**
             * Attribut les données du formulaire.
             */
            $questionData = $questionForm->getData();
            /**
             * $reponse separe les différentes réponse entre elle
             * du textarea lors d'un passage à la ligne.
             */
            $reponse = explode("\n", $questionData['reponse']);

            /**
             * $rang le rang est défini par l'heure seconde et minute courante
             */
            $rang = time();
            $rang = date("his", $rang);


            /**
             * Attribution des données du formulaire au méthode correspondante.
             */
            $question->setRang($rang);

            $question->setTypeQ($questionData['typeQ']);

            $question->setNom($questionData['nom']);

            $question->setTexte($questionData['texte']);

            $question->setResponse1($reponse[0]);

            /**
             * Test combien y a de réponse est ajoute
             * en fonction du nombre de réponse saisi.
             */
            if (count($reponse) > 1) {
                $question->setResponse2($reponse[1]);
                if (count($reponse) > 2) {
                    $question->setResponse3($reponse[2]);
                }
                if (count($reponse) > 3) {
                    $question->setResponse4($reponse[3]);
                }
                if (count($reponse) > 4) {
                    $question->setResponse5($reponse[4]);
                }
            }

            $question->setDefaut($questionData['defaut']);

            $question->setQuestionnaire($questionnaire);


            $em->persist($question);
            $em->flush(); // envoie dans la base de donnée.
        }

        /**
         * Récupère dans la base les questions correspondant au questionnaire courant
         */
        $questionShow = $this
            ->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(
                ['questionnaire' => $id]
            );

        /**
         * Renvoie vers le template questionnaire-edit.html.twig
         * Et donne en paramètre :
         * title        : titre du questionnaire
         * questionForm : Formulaire de création de question.
         * question     : Les questions correspondant au questionnaire courant.
         * afin de les afficher avec TWIG.
         */
        return $this->render(
            'questionnaire-edit.html.twig',
            array(
                  'title' => $questionnaire->getName(),
                  'questionForm' => $questionForm->createView(),
                  'question' => $questionShow
            )
        );
    }



    /*
     * @Route("/admin/questionnaire/delete/{parentId}")
     */
    public function questionnaireDelete(Request $request)
    {
        /***
         *   Récupère le paramètre
         *   passer par la route ==> parentId == id du questionnaire.
         *   Request + ou - identique a $_SESSION[''].
         */
        $id = $request->attributes->get('parentId');

        /**
         * Requête qui cherche le questionnaire posséfant l'id == $id
         */
        $questionnaire = $this
            ->getDoctrine()
            ->getRepository(Questionnaire::class)
            ->find($id);

        $em = $this->getDoctrine()->getEntityManager();

        try {
            if (null !== $questionnaire) {
                $em->remove($questionnaire);
                $em->flush();
            }

            $info =
                [
                    'message' => 'Le questionnaire n°'.$id.' a bien été supprimé',
                    'id'      => $id
                ]
            ;

        } catch (\Exception $e) {
            $info =
                [
                    'message' => 'Le questionnaire n°'.$id.' n\'a pas été supprimé',
                    'id'      => $id
                ]
            ;
        }


        /**
         * Recherche des différents questionnaires présent dans la base de donnée.
         */
        $questionnaires = $this
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
                'info' => $info,
                'quest' => $questionnaires,
                'files'   => $files
            ]
        );
    }
}

