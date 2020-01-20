<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Mark
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MarkRepository")
 * @ORM\Table()
 */
class Mark {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="integer")
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
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value): void {
		if ($value > 20) {
			$value = 20;
		}

		if ($value < 0) {
			$value = 0;
		}

		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param mixed $subject
	 */
	public function setSubject($subject): void {
		$this->subject = $subject;
	}

	/**
	 * @return mixed
	 */
	public function getStudentId() {
		return $this->studentId;
	}

	/**
	 * @param mixed $studentId
	 */
	public function setStudentId($studentId): void {
		$this->studentId = $studentId;
	}
}