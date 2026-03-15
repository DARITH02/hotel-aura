<?php
class Booking extends Model {
    public function getAllBookingsWithDetails() {
        $query = "SELECT b.*, g.name as guest_name, g.phone as guest_phone, g.telegram_chat_id, 
                         r.room_number, rt.price as nightly_price
                  FROM bookings b 
                  JOIN guests g ON b.guest_id = g.id 
                  JOIN rooms r ON b.room_id = r.id 
                  JOIN room_types rt ON r.room_type_id = rt.id
                  ORDER BY b.created_at DESC";
        return $this->db->query($query)->fetchAll();
    }
    public function getBookingById($id) {
        $stmt = $this->db->prepare("
            SELECT b.*, g.name as guest_name, g.email as guest_email, g.phone as guest_phone, g.telegram_chat_id, 
                   r.room_number, rt.name as room_type, rt.price as room_price
            FROM bookings b 
            JOIN guests g ON b.guest_id = g.id 
            JOIN rooms r ON b.room_id = r.id 
            JOIN room_types rt ON r.room_type_id = rt.id
            WHERE b.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO bookings (guest_id, room_id, check_in, check_out, total_price, status, online_book) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['guest_id'], 
            $data['room_id'], 
            $data['check_in'], 
            $data['check_out'], 
            $data['total_price'], 
            $data['status'],
            $data['online_book'] ?? 1
        ]);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE bookings SET status = ?";
        $params = [$status];

        if ($status === 'occupied') {
            $sql .= ", actual_check_in = NOW()";
        } elseif ($status === 'checked_out') {
            $sql .= ", actual_check_out = NOW()";
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE bookings 
            SET guest_id = ?, room_id = ?, check_in = ?, check_out = ?, total_price = ?, status = ?, 
                actual_check_in = ?, actual_check_out = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['guest_id'],
            $data['room_id'],
            $data['check_in'],
            $data['check_out'],
            $data['total_price'],
            $data['status'],
            $data['actual_check_in'] ?? null,
            $data['actual_check_out'] ?? null,
            $id
        ]);
    }
}
