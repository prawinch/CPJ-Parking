<?php
class Commoninfo extends CI_Model
{

    function get_count($tbl)
    {
        return $this->db->get($tbl)->num_rows();
    }

    function get_count_id($tbl,$col,$val)
    {
        return $this->db->where($col,$val)->get($tbl)->num_rows();
    }


    function get_headers_parking()
    {

        return array($this->lang->line('s_no'),$this->lang->line('name'),$this->lang->line('group'),$this->lang->line('type'),$this->lang->line('amount_annual'),$this->lang->line('status'),$this->lang->line('action'));
    }
    function get_headers_users()
    {
        return array($this->lang->line('s_no'),$this->lang->line('first_name'),$this->lang->line('last_name'),$this->lang->line('mobile'),$this->lang->line('email'),$this->lang->line('address'),$this->lang->line('apartment_no'),$this->lang->line('alloted_parking'),$this->lang->line('action'));
    }

    function get_headers_allocation()
    {
        return array($this->lang->line('s_no'),$this->lang->line('parking'),$this->lang->line('user'),$this->lang->line('from_date'),$this->lang->line('to_date'),$this->lang->line('status'),$this->lang->line('action'));
    }

    function get_headers_approve()
    {
        return array($this->lang->line('s_no'),$this->lang->line('contract_no'),$this->lang->line('parking'),$this->lang->line('parking_type'),$this->lang->line('apartment_no'),$this->lang->line('user'),$this->lang->line('personal_number'),$this->lang->line('mobile'),$this->lang->line('action'));
    }
    function get_headers_approve_dashboard()
    {
        return array($this->lang->line('s_no'),$this->lang->line('contract_no'),$this->lang->line('parking'),$this->lang->line('parking_type'),$this->lang->line('apartment_no'),$this->lang->line('user'),$this->lang->line('personal_number'),$this->lang->line('mobile'));
    }
    function get_headers_queue()
    {
        return array($this->lang->line('s_no'),$this->lang->line('user'),$this->lang->line('queue_no'),$this->lang->line('status'),$this->lang->line('queue_starts_from'));

    }
    function get_headers_reports()
    {
        return array($this->lang->line('s_no'),$this->lang->line('generated_by'),$this->lang->line('report_by_month'),$this->lang->line('view_pdf'));
    }

    function get_headers_alloted()
    {
        return array($this->lang->line('alloted_parking'),$this->lang->line('parking_type'),$this->lang->line('parking_starts_from'),$this->lang->line('status'),$this->lang->line('action'),'');
    }


    function get_headers_parking_confirm()
    {
        return array($this->lang->line('parking_name'),$this->lang->line('parking_type'),$this->lang->line('from_date'),$this->lang->line('to_date'),$this->lang->line('status'));
    }

        function get_queue_headers_dashboard()
    {
        return array($this->lang->line('queue_no'),$this->lang->line('user'),$this->lang->line('apartment_no'),$this->lang->line('status'));
    }

    function get_column_pdf()
    {
        return array('Kontraktsnr','Hyresgäst','Pnr/Orgnr','Objektstyp','Yta','Årshyra','Tillägg','Summa','Utflyttning','Upps','Förl','Upps.datum','Slutdatum');
    }

    function get_parking_headers_dashbard()
    {
            return array($this->lang->line('s_no'),$this->lang->line('parking_type'),$this->lang->line('total'));
    }

    function str_pad_left($val,$dec)
    {
        return str_pad($val, $dec, "0", STR_PAD_LEFT);
    }
}