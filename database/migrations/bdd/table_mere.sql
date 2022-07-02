

CREATE TABLE password_resets (
  email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  token varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


create table users(
    id  bigint(20) unsigned not null primary key auto_increment,
    name varchar(255) COLLATE utf8mb4_unicode_ci,
    email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
    password varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    email_verified_at timestamp NULL DEFAULT NULL,
    stripe_id varchar(255) COLLATE utf8mb4_unicode_ci ,
    number_card varchar(255),
    card_brand varchar(4),
    remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    trial_ends_at timestamp,
    created_at timestamp NULL DEFAULT  current_timestamp(),
    updated_at timestamp NULL DEFAULT  current_timestamp()
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

alter table users add column google_id bigint(20) ;

create table events(
    id  bigint(20) unsigned not null primary key auto_increment,
    user_id bigint(20) UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name varchar(255),
    stripe_id varchar(255) COLLATE utf8mb4_unicode_ci ,
    stripe_plan varchar(255),
    quantity INT NOT NULL,
    trial_ends_at timestamp,
    ends_at timestamp,
    created_at timestamp NULL DEFAULT  current_timestamp(),
    updated_at timestamp NULL DEFAULT  current_timestamp()
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



create table subscriptions(
    id  bigint(20) unsigned not null primary key auto_increment,
    user_id bigint(20) UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name varchar(255),
    stripe_id varchar(255) COLLATE utf8mb4_unicode_ci ,
    stripe_plan varchar(255),
    quantity INT NOT NULL,
    trial_ends_at timestamp,
    ends_at timestamp,
    created_at timestamp NULL DEFAULT  current_timestamp(),
    updated_at timestamp NULL DEFAULT  current_timestamp()
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


create table plans(
    id  bigint(20) unsigned not null primary key auto_increment,
    name varchar(255),
    slug varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE ,
    stripe_plan varchar(255),
    cost DECIMAL(15,2),
    description TEXT,
    created_at timestamp NULL DEFAULT  current_timestamp(),
    updated_at timestamp NULL DEFAULT  current_timestamp()
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




drop table plans;drop table subscriptions; drop table users;