ALTER TABLE users
ADD COLUMN mfa_email_enabled TINYINT(1) NOT NULL DEFAULT 1 AFTER reset_token,
ADD COLUMN mfa_email_pin VARCHAR(6) DEFAULT NULL AFTER mfa_email_enabled,
ADD COLUMN mfa_pin_expires DATETIME DEFAULT NULL AFTER mfa_email_pin;
