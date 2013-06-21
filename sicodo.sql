--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: cargos; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE cargos (
    id integer NOT NULL,
    cargo character varying(50) NOT NULL,
    status character varying(20) DEFAULT 'activo'::character varying NOT NULL
);


ALTER TABLE public.cargos OWNER TO sicodo;

--
-- Name: cargos_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE cargos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cargos_id_seq OWNER TO sicodo;

--
-- Name: cargos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE cargos_id_seq OWNED BY cargos.id;


--
-- Name: configuraciones; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE configuraciones (
    id integer NOT NULL,
    dias_laborables character varying(50) DEFAULT 'lun:mar:mie:jue:vie'::character varying NOT NULL,
    horas_laborables_por_dia integer DEFAULT 8 NOT NULL
);


ALTER TABLE public.configuraciones OWNER TO sicodo;

--
-- Name: configuraciones_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE configuraciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.configuraciones_id_seq OWNER TO sicodo;

--
-- Name: configuraciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE configuraciones_id_seq OWNED BY configuraciones.id;


--
-- Name: expedientes; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE expedientes (
    id integer NOT NULL,
    codigo character varying(50) NOT NULL,
    titulo text NOT NULL,
    descripcion text NOT NULL,
    status character varying(20) DEFAULT 'en curso'::character varying NOT NULL,
    "timestamp" integer DEFAULT 0 NOT NULL,
    ruta_fkey integer NOT NULL
);


ALTER TABLE public.expedientes OWNER TO sicodo;

--
-- Name: expedientes_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE expedientes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.expedientes_id_seq OWNER TO sicodo;

--
-- Name: expedientes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE expedientes_id_seq OWNED BY expedientes.id;


--
-- Name: estaciones; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE estaciones (
    id integer NOT NULL,
    ruta_fkey integer NOT NULL,
    unidad_fkey integer NOT NULL,
    cargo_fkey integer NOT NULL,
    usuario_fkey integer NOT NULL,
    orden integer NOT NULL,
    horas integer NOT NULL,
    descripcion text NOT NULL
);


ALTER TABLE public.estaciones OWNER TO sicodo;

--
-- Name: estaciones_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE estaciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estaciones_id_seq OWNER TO sicodo;

--
-- Name: estaciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE estaciones_id_seq OWNED BY estaciones.id;


--
-- Name: movimientos; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE movimientos (
    id integer NOT NULL,
    documento_fkey integer NOT NULL,
    unidad_fkey integer NOT NULL,
    cargo_fkey integer NOT NULL,
    usuario_fkey integer NOT NULL,
    descripcion text NOT NULL,
    orden integer NOT NULL,
    horas integer NOT NULL,
    ejecutado character varying(5) DEFAULT 'no'::character varying NOT NULL,
    testigo character varying(5) DEFAULT 'no'::character varying,
    CONSTRAINT movimientos_ejecutado_check CHECK ((((ejecutado)::text = 'si'::text) OR ((ejecutado)::text = 'no'::text))),
    CONSTRAINT movimientos_horas_check CHECK ((horas >= 0)),
    CONSTRAINT movimientos_orden_check CHECK ((orden > 0)),
    CONSTRAINT movimientos_testigo_check CHECK ((((testigo)::text = 'si'::text) OR ((testigo)::text = 'no'::text)))
);


ALTER TABLE public.movimientos OWNER TO sicodo;

--
-- Name: movimientos_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE movimientos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movimientos_id_seq OWNER TO sicodo;

--
-- Name: movimientos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE movimientos_id_seq OWNED BY movimientos.id;


--
-- Name: permisos; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE permisos (
    id integer NOT NULL,
    permiso character varying(50) NOT NULL,
    descripcion text NOT NULL,
    status character varying(20) DEFAULT 'activo'::character varying NOT NULL
);


ALTER TABLE public.permisos OWNER TO sicodo;

--
-- Name: permisos_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE permisos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permisos_id_seq OWNER TO sicodo;

--
-- Name: permisos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE permisos_id_seq OWNED BY permisos.id;


--
-- Name: respuestas; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE respuestas (
    id integer NOT NULL,
    movimiento_fkey integer NOT NULL,
    respuesta text NOT NULL,
    "timestamp" integer NOT NULL
);


ALTER TABLE public.respuestas OWNER TO sicodo;

--
-- Name: respuestas_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE respuestas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.respuestas_id_seq OWNER TO sicodo;

--
-- Name: respuestas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE respuestas_id_seq OWNED BY respuestas.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE roles (
    id integer NOT NULL,
    rol text NOT NULL,
    status character varying(20) DEFAULT 'activo'::character varying NOT NULL
);


ALTER TABLE public.roles OWNER TO sicodo;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO sicodo;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE roles_id_seq OWNED BY roles.id;


--
-- Name: roles_permisos; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE roles_permisos (
    id integer NOT NULL,
    rol_fkey integer NOT NULL,
    permiso_fkey integer NOT NULL
);


ALTER TABLE public.roles_permisos OWNER TO sicodo;

--
-- Name: roles_permisos_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE roles_permisos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_permisos_id_seq OWNER TO sicodo;

--
-- Name: roles_permisos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE roles_permisos_id_seq OWNED BY roles_permisos.id;


--
-- Name: rutas; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE rutas (
    id integer NOT NULL,
    ruta character varying(120) NOT NULL,
    status character varying(20) DEFAULT 'activo'::character varying NOT NULL
);


ALTER TABLE public.rutas OWNER TO sicodo;

--
-- Name: rutas_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE rutas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rutas_id_seq OWNER TO sicodo;

--
-- Name: rutas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE rutas_id_seq OWNED BY rutas.id;


--
-- Name: unidades; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE unidades (
    id integer NOT NULL,
    unidad character varying(50) NOT NULL,
    status character varying(20) DEFAULT 'activo'::character varying
);


ALTER TABLE public.unidades OWNER TO sicodo;

--
-- Name: unidades_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE unidades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unidades_id_seq OWNER TO sicodo;

--
-- Name: unidades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE unidades_id_seq OWNED BY unidades.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE TABLE usuarios (
    id integer NOT NULL,
    usuario character varying(50) NOT NULL,
    clave character varying(128) NOT NULL,
    cedula character varying(15),
    nombre character varying(50) NOT NULL,
    status character varying(20) DEFAULT 'activo'::character varying,
    rol_fkey integer NOT NULL,
    email character varying(50) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO sicodo;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: sicodo
--

CREATE SEQUENCE usuarios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_seq OWNER TO sicodo;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sicodo
--

ALTER SEQUENCE usuarios_id_seq OWNED BY usuarios.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY cargos ALTER COLUMN id SET DEFAULT nextval('cargos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY configuraciones ALTER COLUMN id SET DEFAULT nextval('configuraciones_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY expedientes ALTER COLUMN id SET DEFAULT nextval('expedientes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY estaciones ALTER COLUMN id SET DEFAULT nextval('estaciones_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY movimientos ALTER COLUMN id SET DEFAULT nextval('movimientos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY permisos ALTER COLUMN id SET DEFAULT nextval('permisos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY respuestas ALTER COLUMN id SET DEFAULT nextval('respuestas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY roles ALTER COLUMN id SET DEFAULT nextval('roles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY roles_permisos ALTER COLUMN id SET DEFAULT nextval('roles_permisos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY rutas ALTER COLUMN id SET DEFAULT nextval('rutas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY unidades ALTER COLUMN id SET DEFAULT nextval('unidades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY usuarios ALTER COLUMN id SET DEFAULT nextval('usuarios_id_seq'::regclass);


--
-- Data for Name: cargos; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY cargos (id, cargo, status) FROM stdin;
4	Asistente	activo
5	Jefe de unidad	activo
6	Analista	activo
7	Director de linea	activo
8	Recepcionista	activo
10	Inspector	activo
12	Alcalde	activo
13	Revisor 2	activo
9	Abogado(a)	activo
11	Revisor 1	activo
\.


--
-- Name: cargos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('cargos_id_seq', 13, true);


--
-- Data for Name: configuraciones; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY configuraciones (id, dias_laborables, horas_laborables_por_dia) FROM stdin;
1	lun:mar:mie:jue:vie:sab:dom	8
\.


--
-- Name: configuraciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('configuraciones_id_seq', 1, true);


--
-- Data for Name: expedientes; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY expedientes (id, codigo, titulo, descripcion, status, "timestamp", ruta_fkey) FROM stdin;
59	000001	Pruba para el codigo identificador	asdasdasd	en curso	1371666738	19
\.


--
-- Name: expedientes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('expedientes_id_seq', 59, true);


--
-- Data for Name: estaciones; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY estaciones (id, ruta_fkey, unidad_fkey, cargo_fkey, usuario_fkey, orden, horas, descripcion) FROM stdin;
54	16	90	4	13	1	2	Paso 1
55	16	90	5	14	2	4	Paso 2
56	16	92	4	15	3	5	Paso 3
57	16	94	4	13	4	8	Paso 4
58	18	96	6	13	1	1	Descripcion del paso 1
59	18	90	6	14	2	12	Descripcion del paso 2
60	18	90	7	13	3	12	Descripcion del paso 3
61	18	92	8	14	4	2	Descripcion del paso 4
62	18	92	6	13	5	2	Descripcion del paso 5
63	18	92	5	14	6	2	Descripcion del paso 6
64	18	92	7	13	7	2	Descripcion del paso 7
65	18	97	8	14	8	22	Descripcion del paso 8
66	18	97	9	13	9	22	Descripcion del paso 9
67	18	97	5	14	10	22	Descripcion del paso 10
68	18	96	8	13	11	8	Descripcion del paso 11
69	18	96	10	14	12	4	Descripcion del paso 12
70	18	96	7	13	13	4	Descripcion del paso 13
71	18	90	6	14	14	8	Descripcion del paso 14
72	18	92	6	13	15	8	Descripcion del paso 15
73	18	92	6	14	16	8	Elvaboración de cheque
74	18	92	11	13	17	8	Descripcion del paso 16
75	18	92	11	14	18	8	Descripcion del paso 17
76	18	92	7	13	19	8	Firma
78	18	94	12	13	21	45	Firma
79	18	90	6	14	22	16	Descripcion del paso 22
80	18	90	6	13	23	8	Descripcion del paso 23
81	18	90	6	14	24	8	\tDescripcion del paso 24
77	18	94	6	14	20	8	Revisa el expediente  y cheque del anticipo
82	19	90	6	13	1	36	Disponibilidad financiera
83	19	90	7	14	2	36	Aprobación de disponibilidad financiera
84	19	92	6	13	3	8	Notificación con datos de obra. Disponibilidad Presupuestaria.
85	19	92	5	14	4	8	Revisión de disponibilidad presupuestaria.
86	19	92	7	13	5	8	Aprobación de disponibilidad presupuestaria.
87	19	97	9	14	6	96	Realización de procedimiento y elaboración de contrato.
88	19	97	5	13	7	96	Revisión del procedimiento y del contrato.
89	19	96	10	14	8	48	Oferta ganadora
90	19	96	7	13	9	48	Firma de documentos
91	19	90	6	14	10	24	Revisión de expediente
92	19	92	6	13	11	8	Elaboración del compromiso
93	19	92	5	14	12	8	Revisión del compromiso
94	19	92	7	13	13	8	Aprobación del compromiso
95	19	90	6	14	14	24	Elaboración de anticipo, elaboración de cheque
96	19	90	11	13	15	24	Revisión del anticipo y cheque
97	19	90	13	14	16	24	Revisión del anticipo y cheque
98	19	90	7	13	17	24	Aprobación del anticipo y cheque
99	19	94	6	14	18	24	Revisión del expediente
100	19	95	5	4	19	24	Revision del expediente
\.


--
-- Name: estaciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('estaciones_id_seq', 100, true);


--
-- Data for Name: movimientos; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY movimientos (id, documento_fkey, unidad_fkey, cargo_fkey, usuario_fkey, descripcion, orden, horas, ejecutado, testigo) FROM stdin;
53	59	92	6	13	Notificación con datos de obra. Disponibilidad Presupuestaria.	3	8	no	no
54	59	92	5	14	Revisión de disponibilidad presupuestaria.	4	8	no	no
55	59	92	7	13	Aprobación de disponibilidad presupuestaria.	5	8	no	no
56	59	97	9	14	Realización de procedimiento y elaboración de contrato.	6	96	no	no
57	59	97	5	13	Revisión del procedimiento y del contrato.	7	96	no	no
58	59	96	10	14	Oferta ganadora	8	48	no	no
59	59	96	7	13	Firma de documentos	9	48	no	no
60	59	90	6	14	Revisión de expediente	10	24	no	no
61	59	92	6	13	Elaboración del compromiso	11	8	no	no
62	59	92	5	14	Revisión del compromiso	12	8	no	no
63	59	92	7	13	Aprobación del compromiso	13	8	no	no
64	59	90	6	14	Elaboración de anticipo, elaboración de cheque	14	24	no	no
65	59	90	11	13	Revisión del anticipo y cheque	15	24	no	no
66	59	90	13	14	Revisión del anticipo y cheque	16	24	no	no
67	59	90	7	13	Aprobación del anticipo y cheque	17	24	no	no
68	59	94	6	14	Revisión del expediente	18	24	no	no
51	59	90	6	13	Disponibilidad financiera	1	36	si	no
52	59	90	7	14	Aprobación de disponibilidad financiera	2	36	no	si
\.


--
-- Name: movimientos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('movimientos_id_seq', 68, true);


--
-- Data for Name: permisos; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY permisos (id, permiso, descripcion, status) FROM stdin;
2	unidades.editar	Permite editar unidades	activo
4	cargos.editar	Permite editar cargos	activo
6	rutas.editar	Permite editar el nombre de las rutas de expedientes	activo
7	unidades.acceso	Permite el acceso al modulo de unidades	activo
8	cargos.acceso	Permite el acceso al modulo de Cargos	activo
1	unidades.insertar	Permite insertar una unidad	activo
3	cargos.insertar	Permite insertar cargos	activo
5	rutas.insertar	Permite insertar rutas de expedientes	activo
9	rutas.acceso	Permite el acceso al modulo Rutas de expedientes	activo
10	rutas.eliminar	Permite eliminar rutas de expedientes	activo
11	usuarios.acceso	Permite el acceso al adminstrador de usuario	activo
12	usuarios.roles.acceso	Permite el acceso al modulo de roles en el administrador de usuarios	activo
14	usuarios.insertar	Permite añadir un nuevo usuario	activo
13	usuarios.editar	Permite editar los usuarios	activo
15	permisos.acceso	Permite el acceso al modulo de permisos	activo
16	roles.acceso	Permite el acceso al modulo de Roles	activo
17	expedientes.acceso	Permite el acceso a modulo de Documentos	activo
18	expedientes.insertar	Permite añadir nuevos expedientes	activo
20	usuarios.activar	Permite activar el usuario	activo
21	usuarios.desactivar	Permite desactivar el usuario	activo
22	usuarios.bloquear	Permite bloquear a un usuario	activo
23	roles.insertar	Permite añadir un rol	activo
24	roles.permisos	Permite gestionar los permisos para un rol	activo
25	roles.activar	Permite activar los roles eliminados	activo
26	roles.eliminar	Permite eliminar roles	activo
27	usuarios.perfil.editar	Permite editar los datos de tu perfil	activo
19	usuarios.perfil.cambiar.clave	Permite cambiar la contrasenia del usuario	activo
\.


--
-- Name: permisos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('permisos_id_seq', 27, true);


--
-- Data for Name: respuestas; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY respuestas (id, movimiento_fkey, respuesta, "timestamp") FROM stdin;
152	51	Respuesta satisfactoria	1371672358
\.


--
-- Name: respuestas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('respuestas_id_seq', 152, true);


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY roles (id, rol, status) FROM stdin;
1	Administrador General	activo
14	asd asd	eliminado
7	asdasda	eliminado
9	Cediel	eliminado
6	Esto es una prueba	eliminado
5	Prueba	eliminado
8	qqq	eliminado
10	qqqq	eliminado
11	qqqqq	eliminado
12	qqqqqqqq	eliminado
13	sdfgg	eliminado
4	Secretaria	eliminado
3	Responsable	activo
15	Unidad de Origen	activo
\.


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('roles_id_seq', 15, true);


--
-- Data for Name: roles_permisos; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY roles_permisos (id, rol_fkey, permiso_fkey) FROM stdin;
5	1	7
6	1	8
7	1	9
8	1	5
9	1	6
10	1	10
11	1	11
12	1	12
14	1	14
20	1	4
21	1	3
22	1	2
23	1	1
24	1	15
26	1	17
27	1	18
28	1	19
29	1	20
30	1	21
31	1	13
32	1	22
33	1	16
34	1	23
35	1	24
36	1	25
37	1	26
38	3	17
39	3	19
40	1	27
41	15	17
42	15	18
43	15	19
44	15	27
\.


--
-- Name: roles_permisos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('roles_permisos_id_seq', 44, true);


--
-- Data for Name: rutas; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY rutas (id, ruta, status) FROM stdin;
16	Ruta 1	activo
17	Proyecto - Contrato	activo
18	Proyecto/Contrato (Dirección de Servicios Públicos)	activo
19	Proyecto Contrato (Dirección de Servicios Públicos)	activo
20	Valuación / Pago (Dirección de Servicios Públicos)	activo
\.


--
-- Name: rutas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('rutas_id_seq', 20, true);


--
-- Data for Name: unidades; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY unidades (id, unidad, status) FROM stdin;
90	Dirección de Gestión Interna	activo
91	Dirección de Gestión Externa	activo
92	Dirección de Presupuesto	activo
93	Jefatura de Compras y Suministros	activo
95	Dirección de Infraestructura	activo
96	Dirección de Servicios Públicos	activo
97	Unidad de Contrataciones	activo
94	Despacho del Alcalde	activo
\.


--
-- Name: unidades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('unidades_id_seq', 97, true);


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: sicodo
--

COPY usuarios (id, usuario, clave, cedula, nombre, status, rol_fkey, email) FROM stdin;
13	usuario1@mail.com	e10adc3949ba59abbe56e057f20f883e	00000001	Usuario 1	activo	3	usuario1@mail.com
14	usuario2@mail.com	e10adc3949ba59abbe56e057f20f883e	00000002	Usuario 2	activo	3	usuario2@mail.com
15	usuario3@mail.com	e10adc3949ba59abbe56e057f20f883e	00000003	Usuario 3	activo	3	usuario3@mail.com
16	by_link@hotmail.com	e10adc3949ba59abbe56e057f20f883e	17258021	Pedro Perez Pirela	activo	3	by_link@hotmail.com.ve
4	sicodo	e10adc3949ba59abbe56e057f20f883e	17515094	Johel Cediel	activo	1	cedielj@alcaldiadeguacara.gob.ve
17	josep@mail.com	e10adc3949ba59abbe56e057f20f883e	19000650	José Perez	activo	15	josep@mail.com
\.


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sicodo
--

SELECT pg_catalog.setval('usuarios_id_seq', 17, true);


--
-- Name: cargos_cargo_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY cargos
    ADD CONSTRAINT cargos_cargo_key UNIQUE (cargo);


--
-- Name: cargos_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY cargos
    ADD CONSTRAINT cargos_pkey PRIMARY KEY (id);


--
-- Name: configuraciones_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY configuraciones
    ADD CONSTRAINT configuraciones_pkey PRIMARY KEY (id);


--
-- Name: expedientes_codigo_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY expedientes
    ADD CONSTRAINT expedientes_codigo_key UNIQUE (codigo);


--
-- Name: expedientes_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY expedientes
    ADD CONSTRAINT expedientes_pkey PRIMARY KEY (id);


--
-- Name: estaciones_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY estaciones
    ADD CONSTRAINT estaciones_pkey PRIMARY KEY (id);


--
-- Name: movimientos_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY movimientos
    ADD CONSTRAINT movimientos_pkey PRIMARY KEY (id);


--
-- Name: permisos_permiso_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT permisos_permiso_key UNIQUE (permiso);


--
-- Name: permisos_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (id);


--
-- Name: respuestas_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY respuestas
    ADD CONSTRAINT respuestas_pkey PRIMARY KEY (id);


--
-- Name: roles_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: roles_rol_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_rol_key UNIQUE (rol);


--
-- Name: rutas_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY rutas
    ADD CONSTRAINT rutas_pkey PRIMARY KEY (id);


--
-- Name: rutas_ruta_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY rutas
    ADD CONSTRAINT rutas_ruta_key UNIQUE (ruta);


--
-- Name: unidades_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY unidades
    ADD CONSTRAINT unidades_pkey PRIMARY KEY (id);


--
-- Name: unidades_unidad_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY unidades
    ADD CONSTRAINT unidades_unidad_key UNIQUE (unidad);


--
-- Name: usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: usuarios_usuario_key; Type: CONSTRAINT; Schema: public; Owner: sicodo; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_usuario_key UNIQUE (usuario);


--
-- Name: roles_permisos_rol_fkey_permiso_fkey_idx; Type: INDEX; Schema: public; Owner: sicodo; Tablespace: 
--

CREATE INDEX roles_permisos_rol_fkey_permiso_fkey_idx ON roles_permisos USING btree (rol_fkey, permiso_fkey);


--
-- Name: expedientes_ruta_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY expedientes
    ADD CONSTRAINT expedientes_ruta_fkey_fkey FOREIGN KEY (ruta_fkey) REFERENCES rutas(id);


--
-- Name: estaciones_cargo_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY estaciones
    ADD CONSTRAINT estaciones_cargo_fkey_fkey FOREIGN KEY (cargo_fkey) REFERENCES cargos(id);


--
-- Name: estaciones_ruta_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY estaciones
    ADD CONSTRAINT estaciones_ruta_fkey_fkey FOREIGN KEY (ruta_fkey) REFERENCES rutas(id);


--
-- Name: estaciones_unidad_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY estaciones
    ADD CONSTRAINT estaciones_unidad_fkey_fkey FOREIGN KEY (unidad_fkey) REFERENCES unidades(id);


--
-- Name: estaciones_usuario_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY estaciones
    ADD CONSTRAINT estaciones_usuario_fkey_fkey FOREIGN KEY (usuario_fkey) REFERENCES usuarios(id);


--
-- Name: movimientos_cargo_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY movimientos
    ADD CONSTRAINT movimientos_cargo_fkey_fkey FOREIGN KEY (cargo_fkey) REFERENCES cargos(id);


--
-- Name: movimientos_documento_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY movimientos
    ADD CONSTRAINT movimientos_documento_fkey_fkey FOREIGN KEY (documento_fkey) REFERENCES expedientes(id);


--
-- Name: movimientos_unidad_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY movimientos
    ADD CONSTRAINT movimientos_unidad_fkey_fkey FOREIGN KEY (unidad_fkey) REFERENCES unidades(id);


--
-- Name: movimientos_usuario_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY movimientos
    ADD CONSTRAINT movimientos_usuario_fkey_fkey FOREIGN KEY (usuario_fkey) REFERENCES usuarios(id);


--
-- Name: respuestas_movimiento_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY respuestas
    ADD CONSTRAINT respuestas_movimiento_fkey_fkey FOREIGN KEY (movimiento_fkey) REFERENCES movimientos(id);


--
-- Name: roles_permisos_permiso_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY roles_permisos
    ADD CONSTRAINT roles_permisos_permiso_fkey_fkey FOREIGN KEY (permiso_fkey) REFERENCES permisos(id);


--
-- Name: roles_permisos_rol_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY roles_permisos
    ADD CONSTRAINT roles_permisos_rol_fkey_fkey FOREIGN KEY (rol_fkey) REFERENCES roles(id);


--
-- Name: usuarios_rol_fkey_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sicodo
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_rol_fkey_fkey FOREIGN KEY (rol_fkey) REFERENCES roles(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

