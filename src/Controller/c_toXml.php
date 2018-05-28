<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 24/04/2018
 * Time: 16:50
 */

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class c_toXml
 * Controller gérant les actions lié au XML
 * @package App\Controller
 */
class c_toXml extends Controller
{
    /*
     * @Route("/admin/xml/{parentId}")
     */
    public function creerXmlQuestionnaire(Request $request)
    {
        /***
         * récupère le paramètre passer par la route
         * ==> parentId == id du questionnaire.
         * Request + ou - identique a $_SESSION[''].
         */
        $id = $request->attributes->get('parentId');

        if (null !== $id) {
            /**
             * Initialisation du serializer.
             * $encoders    : est un tableau où on définit le ou les type(s) de
             *                fichier(s) que l'on souhaite sérialiser.
             * $normalizers : est un tableau qui possède un objet
             *                de ObjectNormaliser. Cette class consiste à convertir
             *                les objets en array.
             */
            $encoders = array(new XmlEncoder('questionnaire'), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            /**
             * Object Serializer qui récupère les deux variables
             * présentent au dessus afin d'initialiser le serializer.
             */
            $serializer = new Serializer($normalizers, $encoders);

            /**
             * Recherche du questionnaire dans la base de donnée
             * via l'id passé en paramètre par la route.
             */
            $questionnaireParent = $this
                ->getDoctrine()
                ->getRepository(Questionnaire::class)
                ->findOneBy(['id' => $id]);

            if (null !== $questionnaireParent) {
                $xml = $serializer
                    ->serialize(
                        $questionnaireParent,
                        'xml',
                        [
                            'xml_format_output' => 'true'
                        ]
                    );

                /**
                 * Partie enregistrement du fichier xml
                 */
                if (null !== $xml) {

                    /**
                     * $filePath : défini le dossier ou
                     *             aller sauvegarder les fichiers sérialiser.
                     * $fileName : Defini le nom du fichier ainsi que son extension.
                     */
                    $filePath = __DIR__ . './../../public/assets/doc_xml/';

                    /**
                     * Version horodaté:
                     * $fileName =
                     * $questionnaireParent->getName(). date('dmyhis') . '.xml';
                     */

                    /**
                     * Version simple car \SimpleXMLElement($xml)
                     * teste s'il est présent ou non.
                     */
                    $fileName = $questionnaireParent
                            ->getName(). '(' .date('is'). ')' .'.xml';
                    /**
                     * Créer un nouveau fichier si existe.
                     */
                    $mainNode = new \SimpleXMLElement($xml);

                    /**
                     *$fileSystem : est un objet de Filesystem() qui donne
                     *              les fonctions basic de gestion de fichier.
                     * ->mkdir     : permet de creer un dossier.
                     */
                    $fileSystem = new Filesystem();
                    $fileSystem->mkdir($filePath);

                    /**
                     * Sauvegarde le xml.
                     */
                    $mainNode->asXML($filePath . $fileName);
                }
                //Objet permettant de renvoyer le xml.
                $response = new Response($xml);

                $response->headers->set('Content-Type', 'xml');
            }
        }

        return $response;
    }

    /*
     * @Route("/admin/download/{file}")
     */
    public function download(Request $request)
    {
        /***
         * Récupère le paramètre passer par la route
         * ==> file == nom + extension fichier.
         * Request + ou - identique a $_SESSION[''].
         */
        $file = $request->attributes->get('file');

        /***
         * Recherche le chemin relatif du fichier.
         */
        $path = __DIR__ . './../../public/assets/doc_xml/';;

        /***
         * en récupère le contenu.
         */
        $content = file_get_contents($path.$file);

        $response = new Response();

        /***
         * Permet de mettre en disposition le contenu du xml
         * et permet de download le fichier.
         */
        $response
            ->headers
            ->set('Content-Disposition', 'attachment;filename="'.$file);

        /***
         * Ajoute le contenu au fichier xml téléchargé.
         */
        $response->setContent($content);

        return $response;
    }
}