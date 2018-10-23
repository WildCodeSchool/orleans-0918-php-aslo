<?php
/**
 * Created by PhpStorm.
 * User: wilder20
 * Date: 10/10/18
 * Time: 16:46
 */

namespace Controller;

use Model\AbstractManager;
use Model\Member;
use Model\MemberManager;

class MemberController extends AbstractController
{
    const NUMBER_MAX_FIELD = 11;
    const MAX_SIZE_MEMBER_FIELD = 45;
    private $id;
    
    private function memberFormDataValidation():array
    {
        $errorsForm=[];
        $emptyField=false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $value) {
                if (empty($value)) {
                    $emptyField = true;
                    $errorsForm[] = "ATTENTION, tous les champs doivent être renseigné";
                    break;
                }
            }
            if ($emptyField == false) {
                if (count($_POST) < self::NUMBER_MAX_FIELD) {
                    $errorsForm[] = "ATTENTION, tous les champs doivent être renseigné";
                }
    
                if (!preg_match(" /^.+@.+\.[a-zA-Z]{2,}$/ ", $_POST['email'])) {
                    $errorsForm['invalid email'] = "Le format de l'email n'est pas correct";
                }
    
                if (!preg_match(" #^[0-9]{2}[-/ ]?[0-9]{2}[-/ ]?[0-9]{2}[-/ ]?[0-9]{2}[-/ ]?[0-9]{2}?$# ", $_POST['tel'])
                    || !preg_match(" #^[0-9]{2}[-/ ]?[0-9]{2}[-/ ]?[0-9]{2}[-/ ]?[0-9]{2}[-/ ]?[0-9]{2}?$# ", $_POST['EmergencyContactTel'])) {
                    $errorsForm['invalid phone'] = "Le numéro de téléphone renseigné est incorrect";
                }
                if (!preg_match("#([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$# ", $_POST['birthDate'])) {
                    $errorsForm['invalid date'] = "le format de la date est incorrect";
                }
                foreach ($_POST as $value) {
                    if (mb_strlen($value) > self::MAX_SIZE_MEMBER_FIELD) {
                        $errorsForm['sizeString'] = "le nombre de caractère utilisé ne peut pas dépasser ".self::MAX_SIZE_MEMBER_FIELD." charactères";
                    }
                }
            }
        }
        return $errorsForm;
    }
    
    
    public function add()
    {
        if (!empty($_POST) and empty(self::memberFormDataValidation())) {
            $memberAdd = new MemberManager($this->getPdo());
            $member = new Member();
            $member->setFirstName(strip_tags(stripslashes(trim($_POST['firstname']))));
            $member->setLastname(strip_tags(stripslashes(trim($_POST['lastname']))));
            $member->setEmail(strip_tags(stripslashes(trim($_POST['email']))));
            $member->setAddress(strip_tags(stripslashes(trim($_POST['address']))));
            $member->setPostalCode(strip_tags(stripslashes(trim($_POST['postalcode']))));
            $member->setCity(strip_tags(stripslashes(trim($_POST['city']))));
            $member->setPhone(strip_tags(stripslashes(trim($_POST['tel']))));
            $member->setBirthDate(\DateTime::createFromFormat('Y-m-d', strip_tags(stripslashes(trim($_POST['birthDate'])))));
            $member->setEmergencyContact(strip_tags(stripslashes(trim($_POST['EmergencyContact']))));
            $member->setEmergencyPhone(strip_tags(stripslashes(trim($_POST['EmergencyContactTel']))));
            $member->setPayment(strip_tags(stripslashes(trim($_POST['paiement']))));
            
            $this->id = $memberAdd->insert($member);
        }
    
        return $this->twig->render('Member/memberForm.html.twig', ['errors' => self::memberFormDataValidation(), 'id' => $this->id]);
    }
}