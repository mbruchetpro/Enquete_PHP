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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class c_questionnaire extends Controller
{
    /*
     * @Route("/creer_Questionnaire")
     */
    public function new(Request $request)
    {
        $quest = new Questionnaire();

        $form = $this->createFormBuilder($quest,
                                          array
                                          (
                                            'method' => 'POST',
                                          )
                )
                ->add('name', TextType::class, array(
                                                                'label' => 'Nom : ',
                                                                'attr' => array(
                                                                    'placeholder' => 'Nom du questionnaire')
                                                                ))
                ->add('displayName', TextType::class , array(
                                                                'label' => 'Libellé : ',
                                                                'attr' => array(
                                                                                'placeholder' => 'Libellé de votre questionnaire')
                                                                ))
                ->add('description', TextareaType::class, array(
                                                                            'label' => 'Description : ',
                                                                            'attr' => array(
                                                                                        'placeholder' => 'Description'
                                                                            ),
                                                                            'required' => false

                ))
                ->add('envoyer', SubmitType::class, array(
                    'label' => 'Valider',
                    'attr'  => ["class" => 'btn btn-primary btn-lg btn-block']
                ))
                ->getForm();

        $em = $this->getDoctrine()->getEntityManager();

        $form->handleRequest($request);

        $questionnaire = new Questionnaire();

        if($form->isSubmitted() && $form->isValid()) {
            $questionnaire = $form->getData();
            $em->persist($questionnaire);
            $em->flush();
        }

        return $this->render('new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /*
     * @Route("/admin/questionnaire/edit/{parentId}")
     */
    public function questionnaireEdit(Request $request)
    {
        $id = $request->attributes->get('parentId');
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();

        $questionnaire = $this->getDoctrine()->getRepository(Questionnaire::class)->find($id);

        $questionForm = $this->createFormBuilder($questions,
            [
                'method' => 'POST',
            ])
            ->add('typeQ', ChoiceType::class,
            [
                'choices' => [
                    'Liste déroulantes' => "list",
                    'Liste à choix multiple' => "combo",
                    'Zone de texte' => "text"
                ],
                'label' => 'Type de composant',
            ])
            ->add('nom', TextType::class,
                [
                    'label' => 'Nom ',
                    'attr'  => [
                        'placeholder' => 'Renseigner votre question'
                    ]
                ])
                ->add('texte', TextType::class,
                [
                    'label' => 'Libellé à afficher ',
                    'attr'  => [
                        'placeholder' => 'Renseigner le libellé question'
                    ]
                ])
            ->add('reponse', TextareaType::class,
                [
                    'label' => 'Réponse(s)(1 par ligne et 5 réponses possible) ',
                    'attr'  => ["rows" => '5']
                ])
            ->add('defaut', ChoiceType::class,
            [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'label' => 'Réponse par défault ?',
            ])
            ->add('envoyer', SubmitType::class,
            [
                'label' => 'Valider',
                'attr'  => ["class" => 'btn btn-primary btn-lg btn-block']
            ])
            ->getForm();

        $em = $this->getDoctrine()->getEntityManager();

        $questionForm->handleRequest($request);
        $question = new Question();

        if($questionForm->isSubmitted() && $questionForm->isValid()) {

            $questionData = $questionForm->getData();
            $reponse = explode("\n", $questionData['reponse']);

            $rang = time();
            $rang = date("his", $rang);


            $question->setRang($rang);

            $question->setTypeQ($questionData['typeQ']);

            $question->setNom($questionData['nom']);

            $question->setTexte($questionData['texte']);

            $question->setResponse1($reponse[0]);
            if (count($reponse) > 1) {
                $question->setResponse2($reponse[1]);
                if (count($reponse) > 2) {
                    $question->setResponse3($reponse[2]);
                }
                if (count($reponse) > 3) {
                    $question->setResponse4($reponse[3]);
                }
                if (count($reponse) > 4){
                    $question->setResponse5($reponse[4]);
                }
            }

            $question->setDefaut($questionData['defaut']);

            $question->setQuestionnaire($questionnaire);


            $em->persist($question);
            $em->flush();
        }

        $questionShow =
            $this->getDoctrine()
                 ->getRepository(Question::class)
                 ->findBy(
                     ['questionnaire' => $id]
                 );


        return $this->render('questionnaire-edit.html.twig', array(
          'title' => $questionnaire->getName(),
          'questionForm' => $questionForm->createView(),
          'question' => $questionShow
      ));
    }

}
