/* Formatted on 29/03/2016 05:17:03 p.m. (QP5 v5.114.809.3010) */
DECLARE
   p_capital              number;
   p_cargos_adicionales   number;
   p_mora                 number;
   p_intereses            number;
   p_anticipo             number;
   p_saldo                number;
   n_dif_dias             number (10);
   n_tasa_1               number (10, 2);
   d_fecha_pago           date;
   n_dias_desembolso      number;
   d_fecha_apertura       date;
   n_monto_cap            number (20, 2);
   n_dia                  number (15) := 30;
   n_mon_int              number (15, 2);
   n_valor_cuota          number (15, 2);
   n_cap_vigente          number (15, 2);
   n_mon_int_cuota1       number (15, 2);
   n_valor_nc_cap         number (15, 2);
   n_valor_nd_int         number (15, 2);
   n_valor_nd_cap_pr      number (15, 2);
   n_valor_cap1_cuota     number (15, 2);
   n_sec_movimiento       number (30);

   CURSOR c_data
   IS
      SELECT   TO_CHAR (fecha_primer_pago_capital, 'DD') dias_pago,
               fecha_primer_pago_capital - fecha_apertura dif_dias,
               fecha_primer_pago_capital - fecha_ultimo_desembolso - 1
                  dif_dias_int,
               numero_prestamo,
               tasa_total,
               fecha_primer_pago_capital,
               fecha_apertura,
               valor_cuota,
               codigo_empresa,
               codigo_agencia,
               codigo_sub_aplicacion
        FROM   pr_prestamos
       WHERE   estado = 1  --AND fecha_ultimo_desembolso = TRUNC (SYSDATE) - 1
                         AND numero_prestamo IN (423679, 423681, 423682);

   CURSOR capital_vi (
      p_prestamo                 number
   )
   IS
      SELECT   valor
        FROM   pr_saldos_plan_pago
       WHERE       codigo_tipo_saldo = 1
               AND numero_cuota = 1
               AND numero_prestamo = p_prestamo;
BEGIN
   FOR i IN c_data
   LOOP
      IF i.dias_pago BETWEEN 1 AND 24
      THEN
         n_dia := 30;
      ELSE
         n_dia := i.dif_dias;
      END IF;

      pcrcrediq.proyeccion_cuota_pr_n_ws_cq (i.numero_prestamo,
                                             TRUNC (SYSDATE),
                                             p_capital,
                                             p_cargos_adicionales,
                                             p_mora,
                                             p_intereses,
                                             p_anticipo,
                                             p_saldo);

      --obtencion de variables necesaras para los respectivos calculos y ajustes

      n_tasa_1 := i.tasa_total;

      n_monto_cap := p_capital;

      n_valor_cuota := i.valor_cuota;

      n_dias_desembolso := i.dif_dias_int;

      FOR e IN capital_vi (i.numero_prestamo)
      LOOP
         n_cap_vigente := e.valor;
      END LOOP;

      ---calculos de intereses

      n_mon_int := ROUND ( (n_monto_cap / 360) * n_tasa_1 / 100, 2) * n_dia;

      n_mon_int_cuota1 :=
         ROUND ( (n_monto_cap / 360) * n_tasa_1 / 100, 2) * n_dias_desembolso;


      n_valor_cap1_cuota := (n_cap_vigente + n_mon_int);


      n_valor_nc_cap := n_valor_cap1_cuota - n_valor_cuota;
      n_valor_nd_int := n_mon_int - n_mon_int_cuota1;
      n_valor_nd_cap_pr := n_valor_nc_cap;

      DBMS_OUTPUT.put_line(   'ND Ajuste Capital 1er cuota: '
                           || n_valor_nc_cap
                           || ' - ND Ajuste Intereses 1er cuota : '
                           || n_valor_nd_int
                           || ' - ND Ajuste Capital Principal: '
                           || n_valor_nd_cap_pr);


      
                 /*
                             SELECT   pr_s_movimientos.NEXTVAL INTO sec_movimiento FROM DUAL;
INSERT INTO PCRCREDIQ.PR_MOVIMIENTOS (
                                         FECHA_VALIDA,
                                         SECUENCIA,
                                         CODIGO_USUARIO,
                                         FECHA_HORA,
                                         ESTADO_MOVIMIENTO,
                                         CODIGO_OPERACION,
                                         CODIGO_TIPO_TRANSACCION,
                                         CODIGO_APLICACION,
                                         CODIGO_EMPRESA,
                                         CODIGO_AGENCIA,
                                         CODIGO_SUB_APLICACION,
                                         NUMERO_PRESTAMO,
                                         NUMERO_CONTRATO,
                                         ESTADO_CARTERA_ACT,
                                         ESTADO_CARTERA_ANT,
                                         NUMERO_CUOTAS_ANT,
                                         ADICIONADO_POR,
                                         FECHA_ADICION,
                                         MOVIMIENTOS_RELACIONADOS,
                                         CODIGO_ORIGEN_ANT,
                                         CODIGO_ORIGEN_ACT,
                                         CODIGO_INVERSION_ANT,
                                         CODIGO_INVERSION_ACT,
                                         DESCRIPCION_MOVIMIENTO,
                                         CODIGO_AGENCIA_ANT,
                                         CODIGO_SUB_APLICACION_ANT,
                                         CODIGO_LINEA_FINANCIERA_ANT,
                                         CODIGO_SUBTIPO,
                                         CODIGO_TIPO
           )
  VALUES   (
               SYSDATE,
               sec_movimiento,
               USER,
               SYSDATE,
               '1',
               4,
               193,
               'BPR',
               i.codigo_empresa,
               i.codigo_agencia,
               i.codigo_sub_aplicacion,
               i.numero_prestamo,
               i.numero_prestamo,
               'A',
               'A',
               1,
               USER,
               SYSDATE,
               sec_movimiento,
               1,
               1,
               110,
               110,
               'TRANSACCION - NOTA DEBITO AJUSTE DESEMBOLSO AJUSTE DE CUOTA NRO.1',
               1,
               i.codigo_sub_aplicacion,
               '01',
               1,
               0
           );
COMMIT;
INSERT INTO PCRCREDIQ.PR_SALDOS_MOVIMIENTO (CODIGO_EMPRESA,
                                            FECHA_VALIDA,
                                            SECUENCIA,
                                            CODIGO_USUARIO,
                                            CODIGO_SUB_APLICACION,
                                            CODIGO_TIPO_SALDO,
                                            VALOR)
  VALUES   (1,
            SYSDATE,
            sec_movimiento,
            USER,
            i.codigo_sub_aplicacion,
            2,
            n_valor_nd_int);
COMMIT;
SELECT   pr_s_movimientos.NEXTVAL INTO sec_movimiento FROM DUAL;
INSERT INTO PCRCREDIQ.PR_MOVIMIENTOS (
                                         FECHA_VALIDA,
                                         SECUENCIA,
                                         CODIGO_USUARIO,
                                         FECHA_HORA,
                                         ESTADO_MOVIMIENTO,
                                         CODIGO_OPERACION,
                                         CODIGO_TIPO_TRANSACCION,
                                         CODIGO_APLICACION,
                                         CODIGO_EMPRESA,
                                         CODIGO_AGENCIA,
                                         CODIGO_SUB_APLICACION,
                                         NUMERO_PRESTAMO,
                                         NUMERO_CONTRATO,
                                         ESTADO_CARTERA_ACT,
                                         ESTADO_CARTERA_ANT,
                                         NUMERO_CUOTAS_ANT,
                                         ADICIONADO_POR,
                                         FECHA_ADICION,
                                         MOVIMIENTOS_RELACIONADOS,
                                         CODIGO_ORIGEN_ANT,
                                         CODIGO_ORIGEN_ACT,
                                         CODIGO_INVERSION_ANT,
                                         CODIGO_INVERSION_ACT,
                                         DESCRIPCION_MOVIMIENTO,
                                         CODIGO_AGENCIA_ANT,
                                         CODIGO_SUB_APLICACION_ANT,
                                         CODIGO_LINEA_FINANCIERA_ANT,
                                         CODIGO_SUBTIPO,
                                         CODIGO_TIPO
           )
  VALUES   (
               SYSDATE,
               sec_movimiento,
               USER,
               SYSDATE,
               '1',
               3,
               192,
               'BPR',
               i.codigo_empresa,
               i.codigo_agencia,
               i.codigo_sub_aplicacion,
               i.numero_prestamo,
               i.numero_prestamo,
               'A',
               'A',
               1,
               USER,
               SYSDATE,
               sec_movimiento,
               1,
               1,
               110,
               110,
               'TRANSACCION - NOTA CREDITO AJUSTE DESEMBOLSO AJUSTE DE CUOTA NRO.1',
               1,
               i.codigo_sub_aplicacion,
               '01',
               1,
               0
           );
COMMIT;
INSERT INTO PCRCREDIQ.PR_SALDOS_MOVIMIENTO (CODIGO_EMPRESA,
                                            FECHA_VALIDA,
                                            SECUENCIA,
                                            CODIGO_USUARIO,
                                            CODIGO_SUB_APLICACION,
                                            CODIGO_TIPO_SALDO,
                                            VALOR)
  VALUES   (1,
            SYSDATE,
            sec_movimiento,
            USER,
            i.codigo_sub_aplicacion,
            1,
            n_valor_nc_cap);
COMMIT;
SELECT   pr_s_movimientos.NEXTVAL INTO sec_movimiento FROM DUAL;
INSERT INTO PCRCREDIQ.PR_MOVIMIENTOS (
                                         FECHA_VALIDA,
                                         SECUENCIA,
                                         CODIGO_USUARIO,
                                         FECHA_HORA,
                                         ESTADO_MOVIMIENTO,
                                         CODIGO_OPERACION,
                                         CODIGO_TIPO_TRANSACCION,
                                         CODIGO_APLICACION,
                                         CODIGO_EMPRESA,
                                         CODIGO_AGENCIA,
                                         CODIGO_SUB_APLICACION,
                                         NUMERO_PRESTAMO,
                                         NUMERO_CONTRATO,
                                         ESTADO_CARTERA_ACT,
                                         ESTADO_CARTERA_ANT,
                                         ADICIONADO_POR,
                                         FECHA_ADICION,
                                         MOVIMIENTOS_RELACIONADOS,
                                         CODIGO_ORIGEN_ANT,
                                         CODIGO_ORIGEN_ACT,
                                         CODIGO_INVERSION_ANT,
                                         CODIGO_INVERSION_ACT,
                                         DESCRIPCION_MOVIMIENTO,
                                         CODIGO_AGENCIA_ANT,
                                         CODIGO_SUB_APLICACION_ANT,
                                         CODIGO_LINEA_FINANCIERA_ANT,
                                         CODIGO_SUBTIPO,
                                         CODIGO_TIPO
           )
  VALUES   (
               SYSDATE,
               sec_movimiento,
               USER,
               SYSDATE,
               '1',
               4,
               193,
               'BPR',
               i.codigo_empresa,
               i.codigo_agencia,
               i.codigo_sub_aplicacion,
               i.numero_prestamo,
               i.numero_prestamo,
               'A',
               'A',
               USER,
               SYSDATE,
               sec_movimiento,
               1,
               1,
               110,
               110,
               'TRANSACCION - NOTA DEBITO AJUSTE DESEMBOLSO **NO SE AFECTA LA CUOTA** ',
               1,
               i.codigo_sub_aplicacion,
               '01',
               1,
               0
           );
COMMIT;
INSERT INTO PCRCREDIQ.PR_SALDOS_MOVIMIENTO (CODIGO_EMPRESA,
                                            FECHA_VALIDA,
                                            SECUENCIA,
                                            CODIGO_USUARIO,
                                            CODIGO_SUB_APLICACION,
                                            CODIGO_TIPO_SALDO,
                                            VALOR)
  VALUES   (1,
            SYSDATE,
            sec_movimiento,
            USER,
            i.codigo_sub_aplicacion,
            1,
            n_valor_nd_cap_pr);
COMMIT;*/
   END LOOP;
END;