<?php
class Guest extends Model {
    public function getAllGuests() {
        return $this->db->query("SELECT * FROM guests ORDER BY created_at DESC")->fetchAll();
    }
    
    public function getGuestById($id) {
        $stmt = $this->db->prepare("SELECT * FROM guests WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function searchGuests($search) {
        $stmt = $this->db->prepare("SELECT * FROM guests WHERE name LIKE ? OR email LIKE ? OR phone LIKE ? ORDER BY created_at DESC");
        $searchTerm = "%$search%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO guests (name, phone, email, address, telegram_chat_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'], 
            $data['phone'], 
            $data['email'], 
            $data['address'] ?? '', 
            $data['telegram_chat_id'] ?? null
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE guests SET name=?, phone=?, email=?, address=?, telegram_chat_id=? WHERE id=?");
        return $stmt->execute([
            $data['name'], 
            $data['phone'], 
            $data['email'], 
            $data['address'] ?? '', 
            $data['telegram_chat_id'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM guests WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countBookings($id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM bookings WHERE guest_id = ?");
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public function updateTelegramChatId($id, $chatId) {
        // 1. Remove this chatId from any other guests (ensure unique link)
        $stmt1 = $this->db->prepare("UPDATE guests SET telegram_chat_id = NULL WHERE telegram_chat_id = ? AND id != ?");
        $stmt1->execute([$chatId, $id]);

        // 2. Assign to this guest
        $stmt2 = $this->db->prepare("UPDATE guests SET telegram_chat_id = ? WHERE id = ?");
        return $stmt2->execute([$chatId, $id]);
    }

    public function getGuestStats() {
        return [
            'total' => $this->db->query("SELECT COUNT(*) FROM guests")->fetchColumn(),
            'online' => $this->db->query("SELECT COUNT(*) FROM guests WHERE telegram_chat_id IS NOT NULL")->fetchColumn(),
            'new_30_days' => $this->db->query("SELECT COUNT(*) FROM guests WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn()
        ];
    }
}
