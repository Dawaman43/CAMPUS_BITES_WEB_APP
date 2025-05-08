CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    post_id INTEGER NOT NULL REFERENCES food_posts(id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL CHECK (quantity > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample orders for testing (assuming food_posts has IDs 4 and 5)
INSERT INTO orders (post_id, quantity) VALUES
(4, 2),
(5, 1);