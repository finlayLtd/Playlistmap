<?php

namespace App\Lib;

use Config;

class SendgridController {

    private $sendgridApiKey;
    private $freeListID;
    private $paidListID;
    private $sendgridApiBasepath;

    public function __construct() {
        $this->sendgridApiKey = Config('services.sendgrid.apikey');
        $this->freeListID = Config('services.sendgrid.sendgrid_free_users_list_id');
        $this->paidListID = Config('services.sendgrid.sendgrid_paid_users_list_id');
        $this->sendgridApiBasepath = "https://api.sendgrid.com/v3/";
    }

    function getSendgridApiKey() {
        return $this->sendgridApiKey;
    }

    function getFreeListID() {
        return $this->freeListID;
    }

    function getPaidListID() {
        return $this->paidListID;
    }

    function setSendgridApiKey($sendgridApiKey): void {
        $this->sendgridApiKey = $sendgridApiKey;
    }

    function setFreeListID($freeListID): void {
        $this->freeListID = $freeListID;
    }

    function setPaidListID($paidListID): void {
        $this->paidListID = $paidListID;
    }

    function getSendgridApiBasepath() {
        return $this->sendgridApiBasepath;
    }

    function setSendgridApiBasepath($sendgridApiBasepath): void {
        $this->sendgridApiBasepath = $sendgridApiBasepath;
    }

    public function test() {
//        var_dump($this->getFreeListID());
//        echo "<pre>";
//        var_dump('This is a test');
//        $id = "1a0bde15-9211-41a8-915d-0ee7276f81b4";

//        $user = auth()->user();
//        $id = $this->getRecipientIdByEmail("rlgindos+plm20@gmail.com");
//        var_dump($id);
//        $this->addRecipientToList($this->getPaidListID(), $user->email);
//        $this->removeRecipientFromList($this->getPaidListID(), $id);
//        $this->removeRecipientFromList($this->getFreeListID(), $id);
//        $this->changeUserEmailListToPaid();
        $this->changeUserEmailListToFree();

//        $this->removeRecipientFromList($this->getFreeListID(), $id);
//        $this->addRecipientToList($this->getPaidListID(), $id);
//        $this->createRecipient('rlgindos-test1011@gmail.com', 'Arel', 'Gindos', 44);
//        $this->doRequestToSendgrid('contacts/count');
    }

    private function doRequestToSendgrid($uri, $method = "GET", $body = false) {

//        var_dump($this->getSendgridApiKey());exit;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getSendgridApiBasepath() . $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->getSendgridApiKey(),
                'Content-Type: application/json'
            ),
        ));
        if ($body) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $json = json_decode($response, true);
        try {
            if (array_key_exists('errors', $json)) {
                var_dump('errors');
                var_dump($json);
                return false;
            }
        } catch (\Throwable $ex) {
//            var_dump($httpcode);
//            exit;
            
        }

        return $json;
    }

    public function createRecipient($user) {
        $body = array(
            "list_ids" => array($this->getFreeListID()),
            "contacts" => array(
                array(
                    "email" => strtolower($user->email),
                    "unique_name" => $user->name,
                    "custom_fields" => array("e1_N" => $user->id)
                )
            )
        );
        $res = $this->doRequestToSendgrid('marketing/contacts', 'PUT', json_encode($body));
        return $res ? true : false;
    }

    private function getRecipientIdByEmail($email) {
        $email = strtolower($email);
        
        $body = array(
            "emails" => array($email),
        );
        $res = $this->doRequestToSendgrid('marketing/contacts/search/emails', 'POST', json_encode($body));
        if ($res && count($res['result']) > 0) {
            try {
                return $res['result'][$email]['contact']['id'];
            } catch (\Throwable $ex) {
                return false;
            }
        }
        return false;
    }

    private function removeRecipientFromList($listID, $recipientID) {
        $res = $this->doRequestToSendgrid("marketing/lists/{$listID}/contacts?contact_ids={$recipientID}", 'DELETE');
        return $res ? true : false;
    }

    private function addRecipientToList($listID, $email) {
        $body = array(
            "list_ids" => array($listID),
            "contacts" => array(
                array(
                    "email" => strtolower($email)
                )
            )
        );
        $res = $this->doRequestToSendgrid('marketing/contacts', 'PUT', json_encode($body));
        return $res ? true : false;
    }

    public function changeUserEmailListToFree() {
        $user = auth()->user();
        $recipientID = $this->getRecipientIdByEmail($user->email);
        $res = $this->removeRecipientFromList($this->getPaidListID(), $recipientID);
        $res1 = $this->addRecipientToList($this->getFreeListID(), $user->email);
        return $res && $res1;
    }

    public function changeUserEmailListToPaid() {
        $user = auth()->user();
        $recipientID = $this->getRecipientIdByEmail($user->email);
        $res = $this->removeRecipientFromList($this->getFreeListID(), $recipientID);
        $res1 = $this->addRecipientToList($this->getPaidListID(), $user->email);
        return $res && $res1;
    }

}
