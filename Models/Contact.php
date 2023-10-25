<?php declare(strict_types=1);
class Contact
{
    private $id;

    private $firstname;

    private $lastname;

    private $birsthday;

    public function __construct($firstname, $lastname , $birsthday) {
        $this->firstname = $firstname;
        $this->lastname  =  $lastname ;
        $this->birsthday = $birsthday;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstname() {
        return strtoupper($this->firstname);
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }
    public function getBirsthday() {
        return $this->birsthday;
    }

    public function setName($birsthday) {
        $this->birsthday = $birsthday;
    }

}
