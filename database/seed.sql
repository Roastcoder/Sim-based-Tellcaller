-- Seed data for RBAC system

-- Insert sample company
INSERT INTO companies (id, name, status, billing_status) VALUES
(1, 'Demo Telecom Corp', 1, 'active'),
(2, 'Sample Sales Inc', 1, 'active');

-- Insert Super Admin (platform owner)
INSERT INTO users (id, name, email, password, role_id, company_id, status) VALUES
(1, 'Platform Admin', 'admin@platform.com', '$2y$10$example_hash', 1, NULL, 1);

-- Insert Company Admins
INSERT INTO users (id, name, email, password, role_id, company_id, status) VALUES
(2, 'John Admin', 'john@democorp.com', '$2y$10$example_hash', 2, 1, 1),
(3, 'Sarah Admin', 'sarah@samplesales.com', '$2y$10$example_hash', 2, 2, 1);

-- Insert Managers
INSERT INTO users (id, name, email, password, role_id, company_id, manager_id, status) VALUES
(4, 'Mike Manager', 'mike@democorp.com', '$2y$10$example_hash', 3, 1, 2, 1),
(5, 'Lisa Manager', 'lisa@democorp.com', '$2y$10$example_hash', 3, 1, 2, 1);

-- Insert Teams
INSERT INTO teams (id, company_id, manager_id, name, status) VALUES
(1, 1, 4, 'Sales Team A', 1),
(2, 1, 5, 'Sales Team B', 1);

-- Insert Agents
INSERT INTO users (id, name, email, password, role_id, company_id, manager_id, status) VALUES
(6, 'Agent Smith', 'smith@democorp.com', '$2y$10$example_hash', 4, 1, 4, 1),
(7, 'Agent Jones', 'jones@democorp.com', '$2y$10$example_hash', 4, 1, 4, 1),
(8, 'Agent Brown', 'brown@democorp.com', '$2y$10$example_hash', 4, 1, 5, 1),
(9, 'Agent Davis', 'davis@democorp.com', '$2y$10$example_hash', 4, 1, 5, 1);

-- Insert sample leads
INSERT INTO leads (id, company_id, team_id, name, phone, email, assigned_to, source, status, created_by) VALUES
(1, 1, 1, 'Customer One', '+1234567890', 'customer1@email.com', 6, 'website', 'new', 4),
(2, 1, 1, 'Customer Two', '+1234567891', 'customer2@email.com', 7, 'referral', 'contacted', 4),
(3, 1, 2, 'Customer Three', '+1234567892', 'customer3@email.com', 8, 'campaign', 'interested', 5),
(4, 1, 2, 'Customer Four', '+1234567893', 'customer4@email.com', 9, 'cold_call', 'follow_up', 5);

-- Insert sample call logs
INSERT INTO call_logs (user_id, lead_id, phone, call_type, duration_seconds, start_time, end_time, disposition, note) VALUES
(6, 1, '+1234567890', 'outgoing', 120, '2024-01-15 10:00:00', '2024-01-15 10:02:00', 'interested', 'Customer showed interest in product'),
(7, 2, '+1234567891', 'outgoing', 300, '2024-01-15 11:00:00', '2024-01-15 11:05:00', 'callback', 'Requested callback tomorrow'),
(8, 3, '+1234567892', 'outgoing', 180, '2024-01-15 14:00:00', '2024-01-15 14:03:00', 'not_interested', 'Not interested at this time'),
(9, 4, '+1234567893', 'outgoing', 240, '2024-01-15 15:00:00', '2024-01-15 15:04:00', 'meeting_scheduled', 'Meeting scheduled for next week');

-- Insert sample agent stats
INSERT INTO agent_stats (user_id, date, total_calls, total_talk_seconds, conversions, leads_contacted) VALUES
(6, '2024-01-15', 5, 600, 1, 3),
(7, '2024-01-15', 4, 480, 0, 2),
(8, '2024-01-15', 6, 720, 2, 4),
(9, '2024-01-15', 3, 360, 1, 2);

-- Insert audit log samples
INSERT INTO audit_logs (user_id, action, target_type, target_id, new_values, ip_address) VALUES
(2, 'user_created', 'user', 6, '{"name":"Agent Smith","role":"AGENT"}', '192.168.1.100'),
(4, 'lead_assigned', 'lead', 1, '{"assigned_to":6}', '192.168.1.101'),
(6, 'call_logged', 'call_log', 1, '{"duration":120,"disposition":"interested"}', '192.168.1.102');