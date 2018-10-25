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
use Filter\Text;
var_dump($_POST);

class MemberController extends AbstractController
{
    const MAX_SIZE_MEMBER_FIELD = 255;
    
    /**
     * @var int
     */
    private $id;
    
    /**
     * @param $userData
     * @return array
     */
    private function memberFormDataValidation($userData): array
    {
        $errorsForm = [];
        $emptyField=false;
        $label = array('firstname' => 'Prénom', 'lastname' => 'Nom', 'email' => 'Email', 'address' => 'Adresse', 'postalcode' => 'Code Postal', 'city' => 'Ville', 'tel' => 'Téléphone', 'birthDate' => 'Date de naissance', 'EmergencyContact' => 'Contact d\'urgence', 'EmergencyContactTel' => 'Tel d\'urgence', 'paiement' => 'Modalité de paiement');
        var_dump($_POST);
        foreach ($userData as $key => $value) {
            if (empty($value)) {
                $errorsForm[] = "le champ " . $label[$key] . " doit être renseigné";
                $emptyField=true;
            }
        }
    
        if ($emptyField == false) {

            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $errorsForm['invalid email'] = "Le format de l'email n'est pas correct";
            }

            $checkDate=explode("-",$userData["birthDate"]);
            if (!checkdate($checkDate[1], $checkDate[2], $checkDate[0])){
                $errorsForm['invalid date'] = "le format de la date est incorrect";
            }
        }
        return $errorsForm;
    
    }
    
    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function add()
    {
        $errors=[];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = $_POST;
            $textFilter = new Text();
            $textFilter->setTexts($userData);
            $userData = $textFilter->filter();
            $errors=$this->memberFormDataValidation($userData);
            
            if (!empty($_POST) and empty($errors)) {
                $memberAdd = new MemberManager($this->getPdo());
                $member = new Member();
                $member->setFirstName($userData['firstname']);
                $member->setLastname($userData['lastname']);
                $member->setEmail($userData['email']);
                $member->setAddress($userData['address']);
                $member->setPostalCode($userData['postalcode']);
                $member->setCity($userData['city']);
                $member->setPhone($userData['tel']);
                $member->setBirthDate(new \DateTime($userData['birthDate']));
                $member->setEmergencyContact($userData['EmergencyContact']);
                $member->setEmergencyPhone($userData['EmergencyContactTel']);
                $member->setPayment($userData['paiement']);
                
                $this->id = $memberAdd->insert($member);
                if (isset( $this->id)) {
                    $success = true;
                }
            }
            
        }
        return $this->twig->render('Member/memberForm.html.twig', ['errors' => $errors, 'success' => $success]);
    }
}