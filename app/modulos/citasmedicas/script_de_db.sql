select * from pacientes;


INSERT INTO pacientes (idpacientes, ape_paterno,ape_mat, nombres, ocupación, sexo,
 f_nacimiento, provincia,ciudad,zona,direccion,tlno_particular,tlno_personal,correo,afiliado,id_user_pac)
   VALUES ('0958548125', 'Murillo' ,'Medrano','Carlos Eduardo','Estudiante'
   ,'Hombre','1998-02-14','1','1','nose'
   ,'24 y maracaibo','2884455','0955884455','nomeama@outlook.com','','' );
   
   select * from especialidades;
   
   select * from empleados;
   
    INSERT INTO hora (id_hora, hora) values ('','18:00:00');
    
    
ALTER TABLE citas CHANGE hora  id_hora  int(20);

DELETE FROM citas where paciente=0958548125 ;

select * from citas;
   INSERT INTO citas (idcitas,fecha,id_hora,paciente,estado) values ('','2020-07-1','11','0958548125','Pendeinte');
   
   update citas set id_hora='1' where idcitas=1;
   SELECT * FROM USER;
   select * from citas;

update citas set fecha='2020-06-01' where paciente='0958548125';
   
   select * from citas_medicos;
   select * from cita_especialidad;
   select * from empleados_medico;
   select * from empleados;
   
drop view citas_medica;
   create view citas_medica as select pa.*,ho.*,ci.idcitas,ci.fecha, ci_me.medico,emp.id_empleados, esp.descripcion,emp.nombres as 'nombreD',emp.apellidos,
   emp.celular from citas as ci join pacientes as pa on pa.idpacientes=ci.paciente
   join hora as ho on ho.id_hora=ci.id_hora 
   join citas_medicos as ci_me on ci_me.cita=ci.idcitas
   join empleados_medico as em_me on em_me.id_medico=ci_me.medico
   join empleados as emp on em_me.id_empleados_medico=emp.id_empleados
   join especialidades as esp on esp.idespecialidades=em_me.id_especialidad_medico;
   
   select * from citas_medica;
   drop view citas_medica;
   