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
        $stmt = $this->db->prepare("INSERT INTO guests (name, phone, email, address) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['phone'], $data['email'], $data['address']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE guests SET name=?, phone=?, email=?, address=? WHERE id=?");
        return $stmt->execute([$data['name'], $data['phone'], $data['email'], $data['address'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM guests WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateTelegramChatId($id, $chatId) {
        $stmt = $this->db->prepare("UPDATE guests SET telegram_chat_id = ? WHERE id = ?");
        return $stmt->execute([$chatId, $id]);
    }
}
