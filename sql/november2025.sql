CREATE TABLE IF NOT EXISTS users (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(50) NOT NULL UNIQUE,
    `surname` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `reset_token` VARCHAR(255) DEFAULT NULL,
    `reset_expires` TIMESTAMP DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `language` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bugs (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `status` ENUM('open', 'in_progress', 'closed') DEFAULT 'open',
    `priority` ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    `bug_url` TEXT NULL,
    `user_id` INT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_bugs_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_bugs_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL
);


CREATE TABLE comments (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `bug_id` INT NOT NULL,
    `user_id` INT NULL,
    `comment` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comments_bug
        FOREIGN KEY (`bug_id`)
        REFERENCES bugs(`id`)
        ON DELETE CASCADE,

    CONSTRAINT fk_comments_user
        FOREIGN KEY (`user_id`)
        REFERENCES `users`(`id`)
        ON DELETE SET NULL
);


CREATE TABLE IF NOT EXISTS attachments (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `bug_id` INT,
    `file_path` VARCHAR(255) NOT NULL,
    `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`bug_id`) REFERENCES `bugs`(`id`) ON DELETE CASCADE
);

CREATE TABLE password_resets (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `expires_at` DATETIME NOT NULL
);

CREATE TABLE user_notification_channels (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `email_notifications` BOOLEAN DEFAULT TRUE,
    `sms_notifications` BOOLEAN DEFAULT FALSE,
    `push_notifications` BOOLEAN DEFAULT FALSE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

