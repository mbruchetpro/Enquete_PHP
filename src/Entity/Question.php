<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questionnaire", inversedBy="questions")
     * @ORM\JoinColumn(name="questionnaire_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $questionnaire;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank()
     */
    private $rang;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank()
     */
    private $typeQ;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
    private $texte;

    /**
     * @ORM\Column(type="string", length=31)
     * @Assert\NotBlank()
     */
    private $response1;

    /**
     * @ORM\Column(type="string", length=31, nullable=true)
     */
    private $response2;

    /**
     * @ORM\Column(type="string", length=31, nullable=true)
     */
    private $response3;

    /**
     * @ORM\Column(type="string", length=31, nullable=true)
     */
    private $response4;

    /**
     * @ORM\Column(type="string", length=31, nullable=true)
     */
    private $response5;

    /**
     * @ORM\Column(type="string", length=31)
     * @Assert\NotBlank()
     */
    private $defaut;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * @param mixed $rang
     */
    public function setRang($rang): void
    {
        $this->rang = $rang;
    }

    /**
     * @return mixed
     */
    public function getTypeQ()
    {
        return $this->typeQ;
    }

    /**
     * @param mixed $typeQ
     */
    public function setTypeQ($typeQ): void
    {
        $this->typeQ = $typeQ;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $name
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param mixed $text
     */
    public function setTexte($texte): void
    {
        $this->texte = $texte;
    }

    /**
     * @return mixed
     */
    public function getResponse1()
    {
        return $this->response1;
    }

    /**
     * @param mixed $response1
     */
    public function setResponse1($response1): void
    {
        $this->response1 = $response1;
    }

    /**
     * @return mixed
     */
    public function getResponse2()
    {
        return $this->response2;
    }

    /**
     * @param mixed $response2
     */
    public function setResponse2($response2): void
    {
        $this->response2 = $response2;
    }

    /**
     * @return mixed
     */
    public function getResponse3()
    {
        return $this->response3;
    }

    /**
     * @param mixed $response3
     */
    public function setResponse3($response3): void
    {
        $this->response3 = $response3;
    }

    /**
     * @return mixed
     */
    public function getResponse4()
    {
        return $this->response4;
    }

    /**
     * @param mixed $response4
     */
    public function setResponse4($response4): void
    {
        $this->response4 = $response4;
    }

    /**
     * @return mixed
     */
    public function getResponse5()
    {
        return $this->response5;
    }

    /**
     * @param mixed $response5
     */
    public function setResponse5($response5): void
    {
        $this->response5 = $response5;
    }

    /**
     * @return mixed
     */
    public function getDefaut()
    {
        return $this->defaut;
    }

    /**
     * @param mixed $defaut
     */
    public function setDefaut($defaut): void
    {
        $this->defaut = $defaut;
    }

    /**
     * @param mixed $questionnaire
     */
    public function setQuestionnaire($questionnaire): void
    {
        $this->questionnaire = $questionnaire;
    }

}
