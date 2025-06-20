# Goods Receipt Documentation

## Overview
The Goods Receipt module handles the creation, tracking, and management of goods receipts within the system. It integrates with purchase orders and users to maintain accurate records of received goods.

## API Endpoints

### 1. List All Goods Receipts
- **HTTP Method**: GET
- **Endpoint**: `/api/goods-receipts`
- **Description**: Retrieve a paginated list of all goods receipts.
- **Response**: 
```json
{
    "data": [
        {
            "id": 1,
            "po_id": 1,
            "tanggal": "2025-06-18",
            "status": "Pending",
            "created_by": 1,
            "created_at": "2025-06-18 16:48:00",
            "updated_at": "2025-06-18 16:48:00"
        },
        // ... more receipts
    ],
    "links": {
        "first": "1",
        "last": "10",
        "prev": null,
        "next": "2"
    }
}
```

### 2. Create a New Goods Receipt
- **HTTP Method**: POST
- **Endpoint**: `/api/goods-receipts`
- **Description**: Create a new goods receipt.
- **Request Parameters**:
  - `po_id`: Required, foreign key to purchase orders.
  - `tanggal`: Required date.
  - `status`: Optional string (default: "Pending").
  - `created_by`: Required, foreign key to users.
- **Response**: 
```json
{
    "id": 1,
    "po_id": 1,
    "tanggal": "2025-06-18",
    "status": "Pending",
    "created_by": 1,
    "created_at": "2025-06-18 16:48:00",
    "updated_at": "2025-06-18 16:48:00"
}
```

### 3. Show Single Goods Receipt
- **HTTP Method**: GET
- **Endpoint**: `/api/goods-receipts/{id}`
- **Description**: Retrieve a specific goods receipt by ID.
- **Response**: 
```json
{
    "id": 1,
    "po_id": 1,
    "tanggal": "2025-06-18",
    "status": "Pending",
    "created_by": 1,
    "created_at": "2025-06-18 16:48:00",
    "updated_at": "2025-06-18 16:48:00"
}
```

### 4. Update a Goods Receipt
- **HTTP Method**: PUT
- **Endpoint**: `/api/goods-receipts/{id}`
- **Description**: Update an existing goods receipt.
- **Request Parameters**:
  - Same as create parameters.
- **Response**: 
```json
{
    "id": 1,
    "po_id": 1,
    "tanggal": "2025-06-18",
    "status": "Received",
    "created_by": 1,
    "created_at": "2025-06-18 16:48:00",
    "updated_at": "2025-06-18 16:48:00"
}
```

### 5. Delete a Goods Receipt
- **HTTP Method**: DELETE
- **Endpoint**: `/api/goods-receipts/{id}`
- **Description**: Delete a goods receipt by ID.
- **Response**: 
```json
{
    "message": "Goods receipt deleted successfully"
}
```

## Model: GoodsReceipt

### Fields
- `po_id`: Foreign key to `purchase_orders` table.
- `tanggal`: Date of receipt.
- `status`: Current status (e.g., "Pending", "Received").
- `created_by`: Foreign key to `users` table.

### Relationships
- **BelongsTo**: `purchase_order` (through `po_id`).
- **BelongsTo**: `user` (through `created_by`).

## Database Schema
The `goods_receipts` table is defined with the following schema:

```php
Schema::create('goods_receipts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('po_id')->constrained('purchase_orders');
    $table->date('tanggal');
    $table->string('status')->default('Pending');
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
});
```

### Key Points:
- Primary key: `id`
- Foreign keys: `po_id`, `created_by`
- Default status: "Pending"
