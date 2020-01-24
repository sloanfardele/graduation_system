<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Student
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     */
    private $birthDate;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Student
     */
    public function setId($id): Student
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return Student
     */
    public function setLastName($lastName): Student
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Student
     */
    public function setFirstName($firstName): Student
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     * @return Student
     */
    public function setBirthDate($birthDate): Student
    {
        $this->birthDate = $birthDate;

        return $this;
    }
}
