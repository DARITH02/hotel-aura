<?php
class RoomType extends Model {
    public function getAllTypes() {
        return $this->db->query("SELECT * FROM room_types ORDER BY name")->fetchAll();
    }

    public function addType($name, $description, $price, $capacity = 2, $image = null) {
        $stmt = $this->db->prepare("INSERT INTO room_types (name, description, price, capacity, image) VALUES (:name, :desc, :price, :capacity, :image)");
        if ($stmt->execute([
            ':name' => $name,
            ':desc' => $description,
            ':price' => $price,
            ':capacity' => $capacity,
            ':image' => $image
        ])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function updateType($id, $name, $description, $price, $capacity = 2, $image = null) {
        if ($image !== null) {
            $stmt = $this->db->prepare("UPDATE room_types SET name = :name, description = :desc, price = :price, capacity = :capacity, image = :image WHERE id = :id");
            return $stmt->execute([
                ':name' => $name,
                ':desc' => $description,
                ':price' => $price,
                ':capacity' => $capacity,
                ':image' => $image,
                ':id' => $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE room_types SET name = :name, description = :desc, price = :price, capacity = :capacity WHERE id = :id");
            return $stmt->execute([
                ':name' => $name,
                ':desc' => $description,
                ':price' => $price,
                ':capacity' => $capacity,
                ':id' => $id
            ]);
        }
    }

    public function getTypeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM room_types WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function deleteType($id) {
        $stmt = $this->db->prepare("DELETE FROM room_types WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // --- Gallery Images Methods ---

    public function getGalleryImages($roomTypeId) {
        $stmt = $this->db->prepare("SELECT * FROM room_type_images WHERE room_type_id = :id");
        $stmt->execute([':id' => $roomTypeId]);
        return $stmt->fetchAll();
    }

    public function addGalleryImage($roomTypeId, $image) {
        $stmt = $this->db->prepare("INSERT INTO room_type_images (room_type_id, image) VALUES (:id, :image)");
        return $stmt->execute([
            ':id' => $roomTypeId,
            ':image' => $image
        ]);
    }

    public function getGalleryImageById($imageId) {
        $stmt = $this->db->prepare("SELECT * FROM room_type_images WHERE id = :id");
        $stmt->execute([':id' => $imageId]);
        return $stmt->fetch();
    }

    public function deleteGalleryImage($imageId) {
        $stmt = $this->db->prepare("DELETE FROM room_type_images WHERE id = :id");
        return $stmt->execute([':id' => $imageId]);
    }
}
