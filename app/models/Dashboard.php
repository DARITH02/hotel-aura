<?php
class Dashboard extends Model {
    
    public function getQuickStats() {
        $stats = [
            'total_guests' => 0,
            'active_bookings' => 0,
            'available_rooms' => 0,
            'today_revenue' => 0
        ];

        // Total Guests
        $stats['total_guests'] = $this->db->query("SELECT COUNT(*) FROM guests")->fetchColumn();

        // Active Bookings (checked in or confirmed)
        $stats['active_bookings'] = $this->db->query("SELECT COUNT(*) FROM bookings WHERE status IN ('confirmed', 'checked_in')")->fetchColumn();

        // Available Rooms
        $stats['available_rooms'] = $this->db->query("SELECT COUNT(*) FROM rooms WHERE status = 'available'")->fetchColumn();

        // Today's Revenue (payments collected today)
        $stats['today_revenue'] = $this->db->query("SELECT SUM(amount) FROM payments WHERE DATE(payment_date) = CURDATE()")->fetchColumn() ?: 0;

        return $stats;
    }

    public function getRecentBookings($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT b.*, g.name as guest_name, r.room_number,
                   DATEDIFF(b.check_out, b.check_in) as nights
            FROM bookings b
            JOIN guests g ON b.guest_id = g.id
            JOIN rooms r ON b.room_id = r.id
            ORDER BY b.created_at DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getRoomStatusCounts() {
        return $this->db->query("
            SELECT status, COUNT(*) as count 
            FROM rooms 
            GROUP BY status
        ")->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
