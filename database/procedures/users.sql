DROP PROCEDURE IF EXISTS sp_create_user;
DROP PROCEDURE IF EXISTS sp_get_user;
DROP PROCEDURE IF EXISTS sp_update_user;
DROP PROCEDURE IF EXISTS sp_delete_user;

CREATE PROCEDURE sp_create_user(
    IN p_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_birth_date DATE,
    IN p_nationality VARCHAR(3),
    IN p_document_type VARCHAR(50),
    IN p_document_number VARCHAR(100),
    IN p_user_type VARCHAR(50),
    IN p_preferences JSON,
    IN p_opt_out_recommendations BOOLEAN,
    IN p_avatar VARCHAR(255),
    IN p_language VARCHAR(5),
    IN p_newsletter_subscription BOOLEAN
)
BEGIN
    DECLARE v_existing_id BIGINT;

    SELECT id INTO v_existing_id
    FROM users
    WHERE email = p_email
    LIMIT 1;

    IF v_existing_id IS NOT NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El correo ya está registrado.';
    END IF;

    SET v_existing_id = NULL;

    IF p_document_number IS NOT NULL THEN
        SELECT id INTO v_existing_id
        FROM users
        WHERE document_type = COALESCE(p_document_type, 'DNI')
          AND document_number = p_document_number
        LIMIT 1;

        IF v_existing_id IS NOT NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El documento de identidad ya está registrado.';
        END IF;
    END IF;

    INSERT INTO users (
        name,
        email,
        password,
        phone,
        birth_date,
        nationality,
        document_type,
        document_number,
        user_type,
        preferences,
        opt_out_recommendations,
        avatar,
        language,
        newsletter_subscription,
        created_at,
        updated_at
    ) VALUES (
        p_name,
        p_email,
        p_password,
        p_phone,
        p_birth_date,
        COALESCE(p_nationality, 'PER'),
        COALESCE(p_document_type, 'DNI'),
        p_document_number,
        COALESCE(p_user_type, 'tourist'),
        COALESCE(p_preferences, JSON_ARRAY()),
        IFNULL(p_opt_out_recommendations, 0),
        p_avatar,
        COALESCE(p_language, 'es'),
        IFNULL(p_newsletter_subscription, 1),
        NOW(),
        NOW()
    );

    SELECT * FROM users WHERE id = LAST_INSERT_ID();
END;

CREATE PROCEDURE sp_get_user(IN p_id BIGINT)
BEGIN
    SELECT * FROM users WHERE id = p_id LIMIT 1;
END;

CREATE PROCEDURE sp_update_user(
    IN p_id BIGINT,
    IN p_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_birth_date DATE,
    IN p_nationality VARCHAR(3),
    IN p_document_type VARCHAR(50),
    IN p_document_number VARCHAR(100),
    IN p_user_type VARCHAR(50),
    IN p_preferences JSON,
    IN p_opt_out_recommendations BOOLEAN,
    IN p_avatar VARCHAR(255),
    IN p_language VARCHAR(5),
    IN p_newsletter_subscription BOOLEAN
)
BEGIN
    DECLARE v_existing_id BIGINT;

    SELECT id INTO v_existing_id
    FROM users
    WHERE id = p_id
    LIMIT 1;

    IF v_existing_id IS NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El usuario no existe.';
    END IF;

    SELECT id INTO v_existing_id
    FROM users
    WHERE email = p_email AND id <> p_id
    LIMIT 1;

    IF v_existing_id IS NOT NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El correo ya está registrado por otro usuario.';
    END IF;

    IF p_document_number IS NOT NULL THEN
        SELECT id INTO v_existing_id
        FROM users
        WHERE document_type = COALESCE(p_document_type, 'DNI')
          AND document_number = p_document_number
          AND id <> p_id
        LIMIT 1;

        IF v_existing_id IS NOT NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El documento de identidad ya está registrado por otro usuario.';
        END IF;
    END IF;

    UPDATE users
    SET
        name = p_name,
        email = p_email,
        password = p_password,
        phone = p_phone,
        birth_date = p_birth_date,
        nationality = COALESCE(p_nationality, 'PER'),
        document_type = COALESCE(p_document_type, 'DNI'),
        document_number = p_document_number,
        user_type = COALESCE(p_user_type, 'tourist'),
        preferences = COALESCE(p_preferences, JSON_ARRAY()),
        opt_out_recommendations = IFNULL(p_opt_out_recommendations, 0),
        avatar = p_avatar,
        language = COALESCE(p_language, 'es'),
        newsletter_subscription = IFNULL(p_newsletter_subscription, 1),
        updated_at = NOW()
    WHERE id = p_id;

    SELECT * FROM users WHERE id = p_id;
END;

CREATE PROCEDURE sp_delete_user(IN p_id BIGINT)
BEGIN
    DELETE FROM users WHERE id = p_id;
    SELECT ROW_COUNT() AS affected_rows;
END;
