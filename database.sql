create table casinos(
    id_casino int(10) primary key auto_increment,
    name_casino varchar(255) not null,
    address_casino varchar(255) not null,
    phone_casino varchar(255) not null,
    email_casino varchar(255) not null,
    responsible_casino varchar(255) not null,
    status_casino int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
/* validamos que el email sea unico y valido */
alter table casinos add unique(email_casino);
delimiter $$
    create trigger validate_email_casino before insert on casinos
    for each row
    begin
        if new.email_casino not regexp '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$' then
            signal sqlstate '45000' set message_text = 'El email no es valido';
        end if;
    end $$
delimiter ;
/* validamos que el phone_number sea unico y valido */
alter table casinos add unique(phone_casino);
delimiter $$
    create trigger validate_phone_casino before insert on casinos
    for each row
    begin
        if new.phone_casino not regexp '^[0-9]{10}$' then
            signal sqlstate '45000' set message_text = 'El numero de telefono no es valido';
        end if;
    end $$
delimiter ;

create table rols(
    id_rol int(10) primary key auto_increment,
    id_casino_fk int(10) not null,
    name_rol varchar(255) not null,
    description_rol varchar(255) not null,
    status_rol int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table rols add foreign key (id_casino_fk) references casinos(id_casino);

create table users(
    id_user int(10) primary key auto_increment,
    id_rol_fk int(10) not null,
    name_user varchar(255) not null,
    last_name_user varchar(255) not null,
    email_user varchar(255) not null,
    password_user varchar(255) not null,
    phone_user varchar(255) not null,
    address_user varchar(255) not null,
    status_user int(1) not null,
    image_user varchar(255) default 'noimage',
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table users add foreign key (id_rol_fk) references rols(id_rol);
/* validamos que el email sea unico y valido */
alter table users add unique(email_user);
delimiter $$
    create trigger validate_email_user before insert on users
    for each row
    begin
        if new.email_user not regexp '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$' then
            signal sqlstate '45000' set message_text = 'El email no es valido';
        end if;
    end $$
delimiter ;
/* validamos que el phone_number sea unico y valido */
alter table users add unique(phone_user);
delimiter $$
    create trigger validate_phone_user before insert on users
    for each row
    begin
        if new.phone_user not regexp '^[0-9]{10}$' then
            signal sqlstate '45000' set message_text = 'El numero de telefono no es valido';
        end if;
    end $$
delimiter ;
/* validamos que el password tenga al menos 8 caracteres y contenga almenos una mayuscula y un signo */
delimiter $$
    create trigger validate_pass_user before insert on users
    for each row
    begin
        if new.password_user not regexp '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})' then
            signal sqlstate '45000' set message_text = 'La contraseña no es valida, es muy corta o no contiene almenos una mayuscula, un numero y un signo';
        end if;
    end $$
delimiter ;


create table sessions(
    id_session int(10) primary key auto_increment,
    id_user_fk int(10) not null,
    token_session text not null,
    status_session int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table sessions add foreign key (id_user_fk) references users(id_user);

create table providers(
    id_provider int(10) primary key auto_increment,
    id_casino_fk int(10) not null,
    name_provider varchar(255) not null,
    address_provider varchar(255) not null,
    phone_provider varchar(255) not null,
    email_provider varchar(255) not null,
    status_provider int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table providers add foreign key (id_casino_fk) references casinos(id_casino);
/* validamos que el email sea unico y valido */
alter table providers add unique(email_provider);
delimiter $$
    create trigger validate_email_provider before insert on providers
    for each row
    begin
        if new.email_provider not regexp '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$' then
            signal sqlstate '45000' set message_text = 'El email no es valido';
        end if;
    end $$
delimiter ;
/* validamos que el phone_number sea unico y valido */
alter table providers add unique(phone_provider);
delimiter $$
    create trigger validate_phone_proveider before insert on providers
    for each row
    begin
        if new.phone_provider not regexp '^[0-9]{10}$' then
            signal sqlstate '45000' set message_text = 'El numero de telefono no es valido';
        end if;
    end $$
delimiter ;

create table models(
    id_model int(10) primary key auto_increment,
    id_provider_fk int(10) not null,
    name_model varchar(255) not null,
    description_model text not null,
    status_model int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table models add foreign key (id_provider_fk) references providers(id_provider);

create table machines(
    id_machine int(10) primary key auto_increment,
    id_model_fk int(10) not null,
    uid_machine int(10) not null,
    serial_machine varchar(255) not null unique,
    ip_machine varchar(255) not null,
    game_machine varchar(255) not null,
    operative_machine int(1) not null,
    status_machine int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table machines add foreign key (id_model_fk) references models(id_model);

create table permissions(
    id_permission int(10) primary key auto_increment,
    id_casino_fk int(10) not null,
    name_permission varchar(255) not null,
    description_permission text not null,
    require_auth_permission int(1) not null default 1,
    status_permission int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table permissions add foreign key (id_casino_fk) references casinos(id_casino);

create table permissions_rols(
    id_permission_rol int(10) primary key auto_increment,
    id_permission_fk int(10) not null,
    id_rol_fk int(10) not null,
    status_permission_rol int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table permissions_rols add foreign key (id_permission_fk) references permissions(id_permission);
alter table permissions_rols add foreign key (id_rol_fk) references rols(id_rol);

create table reports(
    id_report int(10) primary key auto_increment,
    id_machine_fk int(10) not null,
    id_user_fk int(10) not null,
    description_report text not null,
    isopen_report int(1) not null,
    status_report int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table reports add foreign key (id_machine_fk) references machines(id_machine);
alter table reports add foreign key (id_user_fk) references users(id_user);

create table test_carrieds(
    id_test_carried int(10) primary key auto_increment,
    id_report_fk int(10) not null,
    id_user_fk int(10) not null,
    description_test_carried text not null,
    solution_test_carried text not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table test_carrieds add foreign key (id_report_fk) references reports(id_report);
alter table test_carrieds add foreign key (id_user_fk) references users(id_user);

create table requests_changes(
    id_request_change int(10) primary key auto_increment,
    id_user_fk int(10) not null,
    description_request_change text not null,
    isopen_request_change int(1) not null,
    status_request_change int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);
alter table requests_changes add foreign key (id_user_fk) references users(id_user);

create table logs(
    id_log int(10) primary key auto_increment,
    id_do int(10) not null,
    who_do varchar(255) not null,
    description_log text not null,
    status_log int(1) not null,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp() on update current_timestamp()
);

create table notifications(
    id_notification int(10) primary key auto_increment,
    id_user_fk int(10) not null,
    tittle_notification varchar(255) not null,
    description_notification text not null,
    content_notification text not null,
    read_notification int(1) not null default 0,
    created_at timestamp default current_timestamp()
);
alter table notifications add foreign key (id_user_fk) references users(id_user);

create table messages(
    id_message int(10) primary key auto_increment,
    id_send_user_fk int(10) not null,
    id_to_user_fk int(10) not null,
    tittle_message varchar(255) not null,
    content_message text not null,
    read_message int(1) not null default 0,
    created_at timestamp default current_timestamp()
);
alter table messages add foreign key (id_send_user_fk) references users(id_user);
alter table messages add foreign key (id_to_user_fk) references users(id_user);


/* triggers for tables */
delimiter $$
    create trigger set_default_rols_user_to_casino after insert on casinos
    for each row 
    begin
        insert into logs(id_do, who_do, description_log, status_log) values(new.id_casino, 'system', 'Se ha insertado un nuevo casino', 1);
        /* insertamos un administrador al nuevo casino */
        insert into rols(id_casino_fk, name_rol, description_rol, status_rol) values(new.id_casino, 'Administrador', 'control todal de la aplicacion', 1);
        insert into users(id_rol_fk, name_user, last_name_user, email_user, password_user, phone_user, address_user, status_user) 
        values((select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 'admin', 'admin', 'admin@admin.com', 'Chido1993$', '0000000000', 'admin', 1);

        /* insertamos los permisos por defecto */
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver reportes', 'permite ver los reportes de las maquinas', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver maquinas', 'permite ver las maquinas', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver proveedores', 'permite ver los proveedores', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver modelos', 'permite ver los modelos', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver usuarios', 'permite ver los usuarios', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver roles', 'permite ver los roles', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver permisos', 'permite ver los permisos', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver solicitudes de cambio', 'permite ver las solicitudes de cambio', 1);
        insert into permissions(id_casino_fk, name_permission, description_permission, status_permission) values(new.id_casino, 'Ver logs', 'permite ver los logs', 1);

        /* asignamos los permisos por defecto al rol de administrador */
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol) 
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver reportes'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver maquinas'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver proveedores'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver modelos'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver usuarios'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver roles'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver permisos'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver solicitudes de cambio'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);
        insert into permissions_rols(id_permission_fk, id_rol_fk, status_permission_rol)
        values((select id_permission from permissions where id_casino_fk = new.id_casino and name_permission = 'Ver logs'), (select id_rol from rols where id_casino_fk = new.id_casino and name_rol = 'Administrador'), 1);

        /* agregamos los logs */
        insert into logs(id_do, who_do, description_log, status_log) values(new.id_casino, 'system', concat('se han creado y generado los permisos por defecto y un usuario administrador para ',new.name_casino), 1);
    end $$
delimiter ;

/* agregamos una nueva funcion, cuando se llame verificar si el log es mas de 30 dias, si es asi, se elimina */
delimiter $$
    create procedure delete_logs()
    begin
        declare id_log int;
        declare created_at_log timestamp;
        declare today timestamp;
        declare diff int;
        declare done int default 0;
        declare cur cursor for select id_log, created_at from logs;
        declare continue handler for not found set done = 1;

        open cur;
        read_loop: loop
            fetch cur into id_log, created_at_log;
            if done = 1 then
                leave read_loop;
            end if;
            set today = now();
            set diff = datediff(today, created_at_log);
            if diff > 30 then
                delete from logs where id_log = id_log;
            end if;
        end loop;
        close cur;
    end $$
delimiter ;

    /* agregamos un procedimiento almacenado para eliminar las notificaciones vistas o leidas */
    delimiter $$
        create procedure delete_notifications()
        begin
            delete from notifications where read_notification = 1;
        end $$
    delimiter ;

    /* ejecutar la funcion delete_logs cada 15 dias */
    set global event_scheduler = on; /* ejecutar esta linea para activar el planificador de eventos ( solo una vez)*/

    /* eliminamos el evento si existe */
    drop event if exists delete_logs_event;

delimiter $$
    create event delete_logs_event
    on schedule every 15 day
    do
    begin
        call delete_logs();
    end $$
delimiter ;

/* creamos un evento que se ejecuta cada 30 minutos para eliminar las sesiones que no han sido actualizadas por más de 8 horas, lo eliminamos si existe */
    drop event if exists delete_sessions_event;
    delimiter $$
        create event delete_sessions_event
        on schedule every 30 minute
        do
        begin
            delete from sessions where timestampdiff(HOUR, updated_at, now()) > 8;
        end $$
    delimiter ;

    /* creamos un evento que se ejecute cada dia para eliminar las notificaciones leidas */
    drop event if exists delete_notifications_event;
    delimiter $$
        create event delete_notifications_event
        on schedule every 1 day
        do
        begin
            call delete_notifications();
        end $$
    delimiter ;

    /* insertamos un casino como prueba*/
    -- insert into casinos(name_casino, address_casino, phone_casino, email_casino, responsible_casino, status_casino) 
    --   values('casinode prueba', 'direccion por defecto', '0000000000', 'prueba@casino.com', 'admin', 1);