<?php
class Admin extends Model {
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM admins ORDER BY created_at DESC")->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO admins (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'], 
            $data['email'], 
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'admin'
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE admins SET name = :name, email = :email, role = :role";
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':id' => $id
        ];

        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM admins WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
