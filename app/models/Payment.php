<?php
class Payment extends Model {
    public function getAllPayments() {
        $query = "SELECT p.*, b.status as booking_status, g.name as guest_name, r.room_number 
                  FROM payments p 
                  JOIN bookings b ON p.booking_id = b.id 
                  JOIN guests g ON b.guest_id = g.id 
                  JOIN rooms r ON b.room_id = r.id
                  ORDER BY p.payment_date DESC";
        return $this->db->query($query)->fetchAll();
    }
    
    public function getPaymentsByBooking($booking_id) {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE booking_id = ? ORDER BY payment_date DESC");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO payments (booking_id, amount, payment_method) VALUES (?, ?, ?)");
        return $stmt->execute([$data['booking_id'], $data['amount'], $data['payment_method']]);
    }
}
