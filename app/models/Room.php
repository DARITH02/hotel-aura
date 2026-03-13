<?php
class Room extends Model {
    public function getAllRoomsWithDetails() {
        $query = "SELECT r.*, f.floor_number, f.description as floor_desc, rt.name as type_name, rt.price, rt.capacity,
                  (SELECT g.name FROM bookings b JOIN guests g ON b.guest_id = g.id 
                   WHERE b.room_id = r.id AND b.status IN ('pending', 'confirmed', 'checked_in', 'occupied') 
                   ORDER BY b.created_at DESC LIMIT 1) as current_guest,
                  (SELECT b.id FROM bookings b 
                   WHERE b.room_id = r.id AND b.status IN ('pending', 'confirmed', 'checked_in', 'occupied') 
                   ORDER BY b.created_at DESC LIMIT 1) as current_booking_id
                  FROM rooms r 
                  JOIN floors f ON r.floor_id = f.id 
                  JOIN room_types rt ON r.room_type_id = rt.id
                  ORDER BY f.floor_number, r.room_number";
        return $this->db->query($query)->fetchAll();
    }
    
    public function getRoomById($id) {
        $stmt = $this->db->prepare("SELECT r.*, rt.name as type_name, rt.price, rt.capacity,
                  (SELECT g.name FROM bookings b JOIN guests g ON b.guest_id = g.id 
                   WHERE b.room_id = r.id AND b.status IN ('pending', 'confirmed', 'checked_in', 'occupied') 
                   ORDER BY b.created_at DESC LIMIT 1) as current_guest,
                  (SELECT b.id FROM bookings b 
                   WHERE b.room_id = r.id AND b.status IN ('pending', 'confirmed', 'checked_in', 'occupied') 
                   ORDER BY b.created_at DESC LIMIT 1) as current_booking_id,
                  (SELECT b.status FROM bookings b 
                   WHERE b.room_id = r.id AND b.status IN ('pending', 'confirmed', 'checked_in', 'occupied') 
                   ORDER BY b.created_at DESC LIMIT 1) as current_booking_status
                  FROM rooms r 
                  JOIN room_types rt ON r.room_type_id = rt.id
                  WHERE r.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO rooms (room_number, floor_id, room_type_id, status, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['room_number'], $data['floor_id'], $data['room_type_id'], $data['status'], $data['image'] ?? null]);
    }
    
    public function update($id, $data) {
        if (isset($data['image'])) {
            $stmt = $this->db->prepare("UPDATE rooms SET room_number=?, floor_id=?, room_type_id=?, status=?, image=? WHERE id=?");
            return $stmt->execute([$data['room_number'], $data['floor_id'], $data['room_type_id'], $data['status'], $data['image'], $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE rooms SET room_number=?, floor_id=?, room_type_id=?, status=? WHERE id=?");
            return $stmt->execute([$data['room_number'], $data['floor_id'], $data['room_type_id'], $data['status'], $id]);
        }
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAvailableRoomByType($typeId) {
        $stmt = $this->db->prepare("
            SELECT r.* FROM rooms r 
            WHERE r.room_type_id = ? 
            AND r.status = 'available' 
            LIMIT 1
        ");
        $stmt->execute([$typeId]);
        return $stmt->fetch();
    }
}
