<?php

    $contactList = json_decode(file_get_contents('https://example.amocrm.ru/api/v4/contacts?limit=LIMIT&page=PAGE'));

    foreach ($contactList->_embedded->contacts as $key => $contact) {

        if (count($contact->_embedded->leads) === 0) {

            $taskParam = [
                'text'          => 'Контакт без сделок',
                'complete_till' => 1618815600,
                'entity_id'     => $contact->id,
                'entity_type'   => 'contacts'
            ];

            $curl = curl_init('https://example.amocrm.ru/api/v4/tasks');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($taskParam, JSON_UNESCAPED_UNICODE));

            curl_setopt($curl, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
            $response = curl_exec($curl);
            curl_close($curl);
        }

    }
