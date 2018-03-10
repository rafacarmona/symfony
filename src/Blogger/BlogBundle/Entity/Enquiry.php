<?php

	namespace Blogger\BlogBundle\Entity;

	use Symfony\Component\Validator\Constraints as Assert;
	/*
	* Clase modelo con los campos con sus respectivas 
	* restricciones y getters y setters.
	*/
	class Enquiry{
		/**
	     * @Assert\NotBlank()
	     */
		protected $name;
		/**
	     * @Assert\Email(
	     *     message = "El email '{{ value }}' no es un email valido.",
	     *     checkMX = true
	     * )
	     */
		protected $email;
		/**
	     * @Assert\NotBlank()
		 * @Assert\Length(
	     *     min = 2,
	     *     max = 50,
	     *     minMessage = "Debe tener un minimo de {{ limit }} caracteres",
	     *     maxMessage = "No puede ser mas largo de {{ limit }} caracteres"
	     * )
	     */
		protected $subject;
		/**
	     * @Assert\NotBlank()
		 * @Assert\Length(
	     *     min = 2,
	     *     minMessage = "Debe tener un minimo de {{ limit }} caracteres"
	     * )
	     */
		protected $body;

		public function getName() {return $this->name;}
		public function setName($name) {$this->name = $name;}
		public function getEmail() {return $this->email;}
		public function setEmail($email) {$this->email = $email;}
		public function getSubject() {return $this->subject;}
		public function setSubject($subject) {$this->subject = $subject;}
		public function getBody() {return $this->body;}
		public function setBody($body) {$this->body = $body;}

	}

?>