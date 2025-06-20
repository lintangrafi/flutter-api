-- Membuat tabel invoices sesuai kebutuhan Flutter
CREATE TABLE invoices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(255) NOT NULL UNIQUE,
    gr_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    total DECIMAL(15,2) NOT NULL,
    status ENUM('Draft', 'Paid') NOT NULL DEFAULT 'Draft',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_invoices_gr_id FOREIGN KEY (gr_id) REFERENCES goods_receipts(id) ON DELETE CASCADE
);
