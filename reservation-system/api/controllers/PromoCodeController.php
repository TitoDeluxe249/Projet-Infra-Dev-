<?php
    // reservation-system/api/controllers/PromoCodeController.php

namespace App\Controllers;

use App\Models\PromoCode;

class PromoCodeController {
    public function index() {
        $promoCodes = PromoCode::getAll();
        return json_encode($promoCodes);
    }

    public function store($data) {
        $promoCode = new PromoCode();
        $promoCode->code = $data['code'];
        $promoCode->valeur = $data['valeur'];
        $promoCode->actif = $data['actif'];
        if ($promoCode->save()) {
            return json_encode(['message' => 'Promo code added successfully']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Failed to add promo code']);
        }
    }

    public function update($id, $data) {
        $promoCode = PromoCode::findById($id);
        if ($promoCode) {
            $promoCode->code = $data['code'];
            $promoCode->valeur = $data['valeur'];
            $promoCode->actif = $data['actif'];
            if ($promoCode->save()) {
                return json_encode(['message' => 'Promo code updated successfully']);
            } else {
                http_response_code(500);
                return json_encode(['message' => 'Failed to update promo code']);
            }
        } else {
            http_response_code(404);
            return json_encode(['message' => 'Promo code not found']);
        }
    }

    public function delete($id) {
        $promoCode = PromoCode::findById($id);
        if ($promoCode && $promoCode->delete()) {
            return json_encode(['message' => 'Promo code deleted successfully']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Failed to delete promo code']);
        }
    }
}
?>
