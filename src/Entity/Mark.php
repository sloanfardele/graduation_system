<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Mark
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MarkRepository")
 * @ORM\Table()
 */
class Mark
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "The mark have to be at least {{ limit }}",
     *      maxMessage = "The mark have to be at maximum {{ limit }}"
     * )
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="integer")
     */
    private $studentId;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Mark
     */
    public function setId($id): Mark
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Mark
     */
    public function setValue($value): Mark
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return Mark
     */
    public function setSubject($subject): Mark
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStudentId(): int
    {
        return $this->studentId;
    }

    /**
     * @param mixed $studentId
     * @return Mark
     */
    public function setStudentId($studentId): Mark
    {
        $this->studentId = $studentId;

        return $this;
    }
}
