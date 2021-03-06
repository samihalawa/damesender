<?php

namespace App;

use Redstar\AgileCRM\Connection;
use Log;

class CrmAgile extends Connection
{

    const CRM_DOMAIN    = 'megacursos';
    // const CRM_EMAIL     = 'webapps@megacursos.com';
    // const CRM_KEY       = 'vrm1mdkfg14r73u7hmsfg1hlr7';
    const CRM_ERROR_DUP = 'error_duplicity';
    const CRM_ERROR_OTH = 'other_error';

    function __construct()
    {
        $mailCredential = "autoemail@megacursos.net";
        $keyCredential = "vrm1mdkfg14r73u7hmsfg1hlr7";

        parent::__construct(self::CRM_DOMAIN, $mailCredential, $keyCredential);
    }

    public function get(User $user)
    {
        return $this->makeRequest("contacts/" . $user->id_agile, null, "GET", "application/json");
    }

    public function sendAgile(User $user , $tags)
    {
       
        $search=$this->search($user);

        if($search){
            $tag=json_encode($tags);
            $this->add_agiletags($user->email, $tag);
        }else{
            $this->create($user,$tags);
        }

    }


    public function search(User $user)
    {
        // return $this->makeRequest("contacts/search/email/" . $user->email, null, "GET", "application/json");
        $result = $this->curl_wrap("contacts/search/email/" . $user->email, null, "GET", "application/json");
        return json_decode($result);
    }
    public function searchPerson($email)
    {
        // return $this->makeRequest("contacts/search/email/" . $user->email, null, "GET", "application/json");
        $result = $this->curl_wrap("contacts/search/email/" . $email, null, "GET", "application/json");
        return json_decode($result);
    }

    public function create(User $user, $tags)
    {

        $contact_json = [
            "tags" => $tags,
            "properties" => $this->properties($user)
        ];

        $contact_json = json_encode($contact_json);

        // return $this->makeRequest("contacts", $contact_json, "POST", "application/json");

        $result = $this->curl_wrap("contacts", $contact_json, "POST", "application/json");

        return json_decode($result);
    }

    public function createNotes($request, $data)
    {
        $note_json[] = array(
            "subject"=>"Sus ingresos mensuales aproximados.",
            "description"=>$request->ingress,
            "contact_ids"=>array($data->id),
            "owner_id"=>$data->owner->id
        );
        $note_json[] = array(
            "subject"=>"El sitio web que estás vendiendo (en caso de negocios en línea).",
            "description"=>$request->site,
            "contact_ids"=>array($data->id),
            "owner_id"=>$data->owner->id
        );
        $note_json[] = array(
            "subject"=>"Naturaleza de los negocios.",
            "description"=>$request->business,
            "contact_ids"=>array($data->id),
            "owner_id"=>$data->owner->id
        );
        $note_json[] = array(
            "subject"=>"Cómo desea recibir los pagos que nos envían sus clientes (cuenta bancaria en qué país o BTC).",
            "description"=>$request->account,
            "contact_ids"=>array($data->id),
            "owner_id"=>$data->owner->id
        );
        $note_json[] = array(
            "subject"=>"Si desea adjuntar alguna cuenta de comunicación instantánea como Whatsapp es bienvenido a hacerlo para acelerar la comunicación.",
            "description"=>$request->wpp,
            "contact_ids"=>array($data->id),
            "owner_id"=>$data->owner->id
        );
          
        foreach($note_json as $data){
            $note_json_aux = json_encode($data);
            $result = $this->curl_wrap("notes", $note_json_aux, "POST", "application/json");
        }
    }

    public function createNew($request, $tags)
    {

        $contact_json = [
            "tags" => $tags,
            "properties" => $this->propertiesNew($request)
        ];

        $contact_json = json_encode($contact_json);

        // return $this->makeRequest("contacts", $contact_json, "POST", "application/json");

        $result = $this->curl_wrap("contacts", $contact_json, "POST", "application/json");

        return json_decode($result);
    }

    public function update(User $user)
    {
        if ($user->id_agile) {
            $contact_json = [
                "id" => $user->id_agile,
                "properties" => $this->properties($user)
            ];

            return $this->makeRequest("contacts/edit-properties", $contact_json, "PUT", "application/json");
        }

        return false;
    }
    public function contacts()
    {
       $result = $this->curl_wrap("contacts?page_size=5&cursor=", null, "GET", "application/json");
       // $result = $this->curl_wrap("contacts/list", null, "GET", "application/json");

        return $result = json_decode($result, false, 512, JSON_BIGINT_AS_STRING);
    }


    public function add_agiletags($email, $tags)
    {
       
        $fields = array(
            'email' => urlencode($email),
            'tags' => urlencode($tags)
        );

        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        $result = $this->curl_wrap("contacts/email/tags/add", rtrim($fields_string, '&'), "POST", "application/x-www-form-urlencoded");

        return json_decode($result);
    }

    public function delete(User $user)
    {
        if (!is_null($user->id_agile)) {
            return $this->makeRequest("contacts/" . $user->id_agile, null, "DELETE", "application/json");
        }

        return false;
    }

    protected function properties(User $user)
    {
        return [
            [
                "name" => "first_name",
                "value" => $user->name,
                "type" => "SYSTEM"
            ],
            [
                "name" => "last_name",
                "value" => $user->lastname,
                "type" => "SYSTEM"
            ],
            [
                "name" => "email",
                "value" => $user->email,
                "type" => "SYSTEM"
            ],
            [
                "name" => "phone",
                "value" => $user->phone ? $user->phone : null,
                "type" => "SYSTEM"
            ],

        ];
    }

    protected function propertiesNew($user)
    {
        return [
            [
                "name" => "first_name",
                "value" => $user->name,
                "type" => "SYSTEM"
            ],
            [
                "name" => "last_name",
                "value" => $user->lastname,
                "type" => "SYSTEM"
            ],
            [
                "name" => "email",
                "value" => $user->email,
                "type" => "SYSTEM"
            ],
            [
                "name" => "phone",
                "value" => $user->phone ? $user->phone : null,
                "type" => "SYSTEM"
            ],

        ];
    }

    public function makeRequest($entity, $data, $method, $content_type)
    {
        if (!is_null($data)) {
            $data = json_encode($data);
        }

        $json = parent::makeRequest($entity, $data, $method, $content_type);
        $r = json_decode($json);

        if (($method != 'GET' || $method != 'DELETE') && is_null($r)) {
            $error = '';
            if ($json == 'Sorry, duplicate contact found with the same email address.') {
                $error = self::CRM_ERROR_DUP;
                Log::notice('Running AgileCrmSync: sync: CRM_ERROR_DUP - ' . $json);
            } else {
                $error = self::CRM_ERROR_OTH;
                Log::error('ERROR Running AgileCrmSync: makeRequest: ' . $json);
            }

            return $error;
        }

        return $r;
    }


    function curl_wrap($entity, $data, $method, $content_type)
    {

        $mailCredential = "autoemail@megacursos.net";
        $keyCredential = "vrm1mdkfg14r73u7hmsfg1hlr7";

        if ($content_type == NULL) {
            $content_type = "application/json";
        }

        $agile_url = "https://" . self::CRM_DOMAIN . ".agilecrm.com/dev/api/" . $entity;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
        switch ($method) {
            case "POST":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "GET":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "PUT":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                break;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:$content_type;", 'Accept:application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $mailCredential . ':' . $keyCredential);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
