<?php
    // reservation-system/api/controllers/ContactController.php

namespace App\Controllers;

use App\Models\Contact;

class ContactController {
    public function store($data) {
        $contact = new Contact();
        $contact->email = $data['email'];
        $contact->sujet = $data['sujet'];
        $contact->message = $data['message'];
        if ($contact->save()) {
            return json_encode(['message' => 'Contact request submitted successfully']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Failed to submit contact request']);
        }
    }
}
?>
