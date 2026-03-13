<?php
class Floor extends Model {
    public function getAllFloors() {
        return $this->db->query("SELECT * FROM floors ORDER BY floor_number")->fetchAll();
    }

    public function addFloor($floor_number, $description) {
        $stmt = $this->db->prepare("INSERT INTO floors (floor_number, description) VALUES (:number, :desc)");
        return $stmt->execute([
            ':number' => $floor_number,
            ':desc' => $description
        ]);
    }

    public function updateFloor($id, $floor_number, $description) {
        $stmt = $this->db->prepare("UPDATE floors SET floor_number = :number, description = :desc WHERE id = :id");
        return $stmt->execute([
            ':number' => $floor_number,
            ':desc' => $description,
            ':id' => $id
        ]);
    }

    public function deleteFloor($id) {
        $stmt = $this->db->prepare("DELETE FROM floors WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
