<?php
class Service extends Model {
    public function getAllServices() {
        return $this->db->query("SELECT * FROM services ORDER BY name")->fetchAll();
    }
    
    public function getServiceById($id) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO services (name, description, price, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['description'], $data['price'], $data['image'] ?? null]);
    }

    public function update($id, $data) {
        if (isset($data['image'])) {
            $stmt = $this->db->prepare("UPDATE services SET name=?, description=?, price=?, image=? WHERE id=?");
            return $stmt->execute([$data['name'], $data['description'], $data['price'], $data['image'], $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE services SET name=?, description=?, price=? WHERE id=?");
            return $stmt->execute([$data['name'], $data['description'], $data['price'], $id]);
        }
    }

    public function delete($id) {
        // Soft delete via checking or constraint fail handling omitted for simplicity
        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Booking Services mapping
    public function getServicesForBooking($booking_id) {
        $stmt = $this->db->prepare("
            SELECT bs.*, s.name, s.price, s.image 
            FROM booking_services bs 
            JOIN services s ON bs.service_id = s.id 
            WHERE bs.booking_id = ? 
            ORDER BY bs.id DESC
        ");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll();
    }
    
    public function addServiceToBooking($booking_id, $service_id, $quantity) {
        $stmt = $this->db->prepare("INSERT INTO booking_services (booking_id, service_id, quantity) VALUES (?, ?, ?)");
        $success = $stmt->execute([$booking_id, $service_id, $quantity]);
        
        if ($success) {
            // Also need to update the total price of the booking
            $service = $this->getServiceById($service_id);
            $additional_cost = $service['price'] * $quantity;
            
            $updateStmt = $this->db->prepare("UPDATE bookings SET total_price = total_price + ? WHERE id = ?");
            $updateStmt->execute([$additional_cost, $booking_id]);
        }
        
        return $success;
    }
}
