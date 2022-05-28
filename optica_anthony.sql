ALTER TABLE users ADD COLUMN salesman tinyint(1) DEFAULT 0;

select * from users;

CREATE TABLE states (
	id int(255) auto_increment,
	description varchar(100),
    acronyms varchar(3),
    active tinyint(1) DEFAULT 1,
    created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE orders (
	id int(255) auto_increment,
    reference varchar(16),
	data text,
    state_id int(255),
    state_acronyms varchar(3),
    closed tinyint(1) DEFAULT 1,
    created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_states_orders FOREIGN KEY (state_id) REFERENCES states (id)
);

CREATE TABLE detail_activities (
	id int(255) auto_increment,
	description varchar(100),
    state_id int(255),
    active tinyint(1) DEFAULT 1,
    created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_states_detail_activities FOREIGN KEY (state_id) REFERENCES states (id)
);

CREATE TABLE activities (
	id int(255) auto_increment,
	description varchar(255),
    detail_activity_id int(255),
    user_id bigint(20) unsigned NOT NULL,
    aperture_date datetime,
    departure_date datetime,
    delivery_date datetime,
    PRIMARY KEY(id),
    CONSTRAINT fk_detail_activities_activities FOREIGN KEY (detail_activity_id) REFERENCES detail_activities (id),
    CONSTRAINT fk_users_activities FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE orders_has_activity (
	id int(255) auto_increment,
	order_id int(255),
    activity_id int(255),
    PRIMARY KEY(id),
    CONSTRAINT fk_activities_orders_has_activity FOREIGN KEY (activity_id) REFERENCES activities (id),
    CONSTRAINT fk_orders_orders_has_activity FOREIGN KEY (order_id) REFERENCES orders (id)
)
