-- RBAC Database Schema for 4-Level Hierarchy
-- Super Admin → Admin → Manager → Agent

-- Roles lookup table
CREATE TABLE roles (
  id TINYINT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO roles (id, name) VALUES
(1, 'SUPER_ADMIN'),
(2, 'ADMIN'),
(3, 'MANAGER'),
(4, 'AGENT');

-- Companies table
CREATE TABLE companies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  status TINYINT DEFAULT 1,
  billing_status ENUM('active', 'suspended', 'cancelled') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Users table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE,
  phone VARCHAR(30),
  password VARCHAR(255) NOT NULL,
  role_id TINYINT NOT NULL DEFAULT 4,
  company_id INT DEFAULT NULL,
  manager_id INT DEFAULT NULL,
  status TINYINT DEFAULT 1,
  device_id VARCHAR(255) DEFAULT NULL,
  last_login TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id),
  FOREIGN KEY (company_id) REFERENCES companies(id),
  FOREIGN KEY (manager_id) REFERENCES users(id)
);

-- Teams table
CREATE TABLE teams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  manager_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  FOREIGN KEY (manager_id) REFERENCES users(id)
);

-- Leads table
CREATE TABLE leads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  team_id INT DEFAULT NULL,
  name VARCHAR(255) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  email VARCHAR(255),
  assigned_to INT DEFAULT NULL,
  source VARCHAR(100),
  status VARCHAR(50) DEFAULT 'new',
  disposition VARCHAR(100),
  score INT DEFAULT NULL,
  priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
  created_by INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  FOREIGN KEY (team_id) REFERENCES teams(id),
  FOREIGN KEY (assigned_to) REFERENCES users(id),
  FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Call logs table
CREATE TABLE call_logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  lead_id INT DEFAULT NULL,
  phone VARCHAR(30) NOT NULL,
  call_type ENUM('incoming', 'outgoing', 'missed') DEFAULT 'outgoing',
  duration_seconds INT DEFAULT 0,
  start_time DATETIME NOT NULL,
  end_time DATETIME,
  disposition VARCHAR(100),
  note TEXT,
  voice_note_path VARCHAR(255),
  device_call_id VARCHAR(255),
  synced_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (lead_id) REFERENCES leads(id),
  UNIQUE KEY unique_device_call (user_id, device_call_id)
);

-- Agent statistics table
CREATE TABLE agent_stats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  date DATE NOT NULL,
  total_calls INT DEFAULT 0,
  total_talk_seconds INT DEFAULT 0,
  conversions INT DEFAULT 0,
  leads_contacted INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  UNIQUE KEY user_date (user_id, date)
);

-- Audit logs table
CREATE TABLE audit_logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  action VARCHAR(100) NOT NULL,
  target_type VARCHAR(50),
  target_id INT,
  old_values JSON,
  new_values JSON,
  ip_address VARCHAR(45),
  user_agent TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Indexes for performance
CREATE INDEX idx_users_company_role ON users(company_id, role_id);
CREATE INDEX idx_leads_assigned ON leads(assigned_to, status);
CREATE INDEX idx_call_logs_user_date ON call_logs(user_id, DATE(start_time));
CREATE INDEX idx_agent_stats_date ON agent_stats(date);