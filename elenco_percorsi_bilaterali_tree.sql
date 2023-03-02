

drop view etl.v_percorsi_bilaterali_4;
drop view etl.v_percorsi_bilaterali_3;
drop view etl.v_percorsi_bilaterali_2;
drop view etl.v_percorsi_bilaterali_1;
drop view etl.v_percorsi_bilaterali;



create or replace view etl.v_percorsi_bilaterali as 
select  
p.id_percorso, u.descrizione as ut_responsabile, 
s.descrizione as desc_servizio, ss.tipi_rifiuto,
case 
t.descrizione 
when 'D' then '04 - Domenicale'
when 'A' then '01 - Antimeridiano'
when 'P' then '02 - Pomeridiano'
when 'N' then '03 - Notturno'
when 'F' then '05 - Festivo'
when 'R' then '06 - Riposo'
when 'S' then '07 - Spezzato'
when 'G' then '08 - Giornaliero' 
end desc_turno, t.cod_turno, fo.descrizione_long as frequenza,
p.cod_percorso, p.descrizione as desc_percorso, ss.id_tipi_rifiuto[1] as id_tipo_rifiuto
from elem.percorsi p 
join elem.percorsi_ut pu on pu.cod_percorso = p.cod_percorso
join etl.frequenze_ok fo on fo.cod_frequenza = p.frequenza 
join topo.ut u on u.id_ut = pu.id_ut and pu.responsabile  = 'S'
join elem.turni t on t.id_turno =p.id_turno
join elem.servizi s on s.id_servizio = p.id_servizio
join (select distinct es.id_servizio, s.descrizione, array_agg(distinct tr.tipo_rifiuto) as id_tipi_rifiuto, string_agg(distinct tr.nome, ',') as tipi_rifiuto
from elem.elementi_servizio es 
join elem.tipi_elemento te on te.tipo_elemento = es.tipo_elemento 
join elem.tipi_rifiuto tr on tr.tipo_rifiuto = te.tipo_rifiuto 
join elem.servizi s on s.id_servizio = es.id_servizio
group by es.id_servizio, s.descrizione) ss on ss.id_servizio = s.id_servizio 
where id_categoria_uso = 3 
and p.id_servizio in (103,104,105,106)
order by desc_percorso;


-- livello 1
create or replace view etl.v_percorsi_bilaterali_1 as 
select row_number() OVER (ORDER BY ut_responsabile) as id_area, ut_responsabile as descrizione, null::int as id_padre 
from etl.v_percorsi_bilaterali
group by ut_responsabile;



-- livello 2
create or replace view etl.v_percorsi_bilaterali_2 as
select (select max(id_area) from etl.v_percorsi_bilaterali_1)  + row_number() OVER (ORDER BY ut_responsabile) as id_area, 
tipi_rifiuto as descrizione, 
b.id_area as id_padre 
from etl.v_percorsi_bilaterali a
join etl.v_percorsi_bilaterali_1 b on b.descrizione = a.ut_responsabile
group by b.id_area, a.ut_responsabile, tipi_rifiuto;

--livello 3
create or replace view etl.v_percorsi_bilaterali_3 as
select (select max(id_area) from etl.v_percorsi_bilaterali_2) +
row_number() OVER (ORDER BY ut_responsabile) as id_area, 
desc_turno as descrizione, 
c.id_area as id_padre 
from etl.v_percorsi_bilaterali a
join etl.v_percorsi_bilaterali_2 c on c.descrizione = a.tipi_rifiuto
join etl.v_percorsi_bilaterali_1 b on b.descrizione = a.ut_responsabile and b.id_area = c.id_padre
group by c.id_area, a.ut_responsabile, tipi_rifiuto, desc_turno




-- percorsi
create or replace view etl.v_percorsi_bilaterali_4 as
select (select max(id_area) from etl.v_percorsi_bilaterali_3) +
row_number() OVER (ORDER BY ut_responsabile) as id_area, 
concat(id_percorso, ';', desc_percorso, ' (cod. ', cod_percorso,')') as descrizione, 
d.id_area as id_padre 
from etl.v_percorsi_bilaterali a
join etl.v_percorsi_bilaterali_3 d on d.descrizione = a.desc_turno
join etl.v_percorsi_bilaterali_2 c on c.descrizione = a.tipi_rifiuto and c.id_area = d.id_padre
join etl.v_percorsi_bilaterali_1 b on b.descrizione = a.ut_responsabile and b.id_area = c.id_padre
group by d.id_area, ut_responsabile, tipi_rifiuto, desc_turno, id_percorso, cod_percorso, desc_percorso



-- tree OLD
select * from etl.v_percorsi_bilaterali_1
union 
select * from etl.v_percorsi_bilaterali_2
union 
select * from etl.v_percorsi_bilaterali_3
union 
select * from etl.v_percorsi_bilaterali_4
order by 1


-- tree 


